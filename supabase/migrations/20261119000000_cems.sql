begin;
create table public.cems_content (
  id uuid primary key default gen_random_uuid(),
  kind text not null check (kind in ('news','course','faq','download','link')),
  title text not null check (length(trim(title)) between 1 and 200),
  body text not null default '' check (length(body) <= 20000),
  link text check (link ~ '^https://' and length(link) <= 2048),
  published boolean not null default false,
  created_at timestamptz not null default now()
);
create table public.cems_admins (
  user_id uuid primary key references auth.users on delete cascade
);
create table public.cems_requests (
  id uuid primary key default gen_random_uuid(),
  user_id uuid not null default auth.uid() references auth.users on delete cascade,
  kind text not null check (kind in ('course','rental')),
  course_id uuid references public.cems_content,
  name text not null check (length(trim(name)) between 1 and 100),
  organization text not null check (length(trim(organization)) between 1 and 160),
  email text not null check (length(email) between 3 and 254 and position('@' in email) > 1),
  phone text not null default '' check (length(phone) <= 40),
  room text check (length(trim(room)) between 1 and 120),
  requested_date date,
  requested_time text check (length(trim(requested_time)) between 1 and 120),
  notes text not null default '' check (length(notes) <= 2000),
  status text not null default 'pending' check (status in ('pending','approved','rejected')),
  created_at timestamptz not null default now(),
  unique (user_id, course_id),
  check ((kind = 'course' and course_id is not null and room is null and requested_date is null and requested_time is null)
      or (kind = 'rental' and course_id is null and room is not null and requested_date is not null and requested_time is not null))
);
create index cems_requests_user on public.cems_requests(user_id);

alter table public.cems_content enable row level security;
alter table public.cems_admins enable row level security;
alter table public.cems_requests enable row level security;
revoke all on public.cems_content, public.cems_admins, public.cems_requests from public, anon, authenticated;
grant select on public.cems_content to anon, authenticated;
grant insert (kind, title, body, link, published) on public.cems_content to authenticated;
grant update (title, body, link, published) on public.cems_content to authenticated;
grant select on public.cems_admins, public.cems_requests to authenticated;
grant insert (kind, course_id, name, organization, email, phone, room, requested_date, requested_time, notes) on public.cems_requests to authenticated;
grant update (status) on public.cems_requests to authenticated;

create policy admins_read_self on public.cems_admins for select to authenticated
  using (user_id = (select auth.uid()));
create policy content_read on public.cems_content for select to anon, authenticated using (published);
create policy content_admin_read on public.cems_content for select to authenticated
  using (exists (select 1 from public.cems_admins));
create policy content_admin_insert on public.cems_content for insert to authenticated
  with check (exists (select 1 from public.cems_admins));
create policy content_admin_update on public.cems_content for update to authenticated
  using (exists (select 1 from public.cems_admins))
  with check (exists (select 1 from public.cems_admins));
create policy requests_read on public.cems_requests for select to authenticated
  using (user_id = (select auth.uid()) or exists (select 1 from public.cems_admins));
create policy requests_insert on public.cems_requests for insert to authenticated
  with check (
    user_id = (select auth.uid()) and status = 'pending'
    and (
      (kind = 'rental' and requested_date >= (now() at time zone 'Asia/Taipei')::date)
      or (kind = 'course' and exists (
        select 1 from public.cems_content
        where id = cems_requests.course_id and kind = 'course' and published
      ))
    )
  );
create policy requests_admin_review on public.cems_requests for update to authenticated
  using (exists (select 1 from public.cems_admins))
  with check (exists (select 1 from public.cems_admins));

insert into public.cems_content (kind,title,body,published) values
  ('news','測試公告','這是用於驗證新版網站的合成資料。',true),
  ('course','測試課程｜模擬教學入門','這是測試課程，可用於檢查登入、報名和後台審核。',true),
  ('faq','如何查看申請進度？','登入後到「我的申請」查看測試申請的審核狀態。',true);
commit;

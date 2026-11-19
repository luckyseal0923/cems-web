import { supabaseUrl, supabasePublishableKey } from './config.js';

const view = document.querySelector('#view');
const notice = document.querySelector('#notice');
const adminLink = document.querySelector('#admin-link');
const sections = { news: '最新消息', course: '課程報名', faq: '常見問題', download: '下載', link: '相關連結' };
const statuses = { pending: '待審核', approved: '已核准', rejected: '未核准' };
const configured = Boolean(supabaseUrl && supabasePublishableKey);
let client;
let session;
let isAdmin = false;
let renderVersion = 0;

function element(tag, text, attributes = {}) {
  const node = document.createElement(tag);
  if (text) node.textContent = text;
  for (const [name, value] of Object.entries(attributes)) node.setAttribute(name, value);
  return node;
}

function field(label, name, options = {}) {
  const wrapper = element('label', label);
  const { tag = 'input', ...attributes } = options;
  const control = element(tag, '', { name, ...attributes });
  wrapper.append(control);
  return wrapper;
}

function choice(label, name, options) {
  const wrapper = field(label, name, { tag: 'select' });
  for (const [value, text] of Object.entries(options)) {
    wrapper.lastChild.append(element('option', text, { value }));
  }
  return wrapper;
}

function form(title, buttonLabel, fields, submit) {
  const node = element('form');
  const button = element('button', buttonLabel, { type: 'submit' });
  node.append(element('h2', title), ...fields, button);
  node.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (button.disabled) return;
    button.disabled = true;
    notice.textContent = '';
    try {
      await submit(new FormData(node));
    } catch (error) {
      notice.textContent = error.code === '23505'
        ? '你已送出這門課的報名。'
        : '操作未完成，請確認輸入資料或稍後重試。';
    } finally {
      button.disabled = false;
    }
  });
  return node;
}

async function query(operation) {
  const { data, error } = await operation;
  if (error) throw error;
  return data;
}

function link(text, href) {
  return element('a', text, { href });
}

function home() {
  const hero = element('article', '', { class: 'hero' });
  const copy = element('div');
  copy.append(
    element('h1', '醫學模擬教育中心'),
    element('p', '臺北醫學大學醫學模擬教育中心透過模擬課程、師資培育及臨床技能訓練，支持醫療專業教育與病人安全。'),
    link('查看課程', '#course')
  );
  hero.append(copy, element('img', '', { src: './assets/center.jpg', alt: '醫學模擬教育中心' }));
  return hero;
}

function requestForm(course) {
  const fields = [
    field('姓名', 'name', { maxlength: 100, required: '' }),
    field('服務單位', 'organization', { maxlength: 160, required: '' }),
    field('電子郵件', 'email', { type: 'email', maxlength: 254, required: '' }),
    field('聯絡電話', 'phone', { type: 'tel', maxlength: 40 }),
  ];
  fields[2].lastChild.value = session.user.email ?? '';
  if (!course) {
    fields.push(
      field('場地', 'room', { maxlength: 120, required: '' }),
      field('借用日期', 'requested_date', { type: 'date', required: '' }),
      field('借用時段', 'requested_time', { maxlength: 120, required: '' })
    );
  }
  fields.push(field('備註', 'notes', { tag: 'textarea', maxlength: 2000 }));
  return form(course ? '報名｜' + course.title : '場地借用申請', '送出申請', fields, async (data) => {
    const row = Object.fromEntries([...data].map(([key, value]) => [key, value.trim()]));
    row.kind = course ? 'course' : 'rental';
    if (course) row.course_id = course.id;
    await query(client.from('cems_requests').insert(row));
    location.hash = 'requests';
    notice.textContent = '已送出申請。';
  });
}

function contentCard(row) {
  const card = element('article', '', { class: 'card' });
  card.append(element('h2', row.title), element('p', row.body, { class: 'body' }));
  if (row.link?.startsWith('https://')) card.append(link('開啟連結', row.link));
  if (row.kind === 'course') {
    card.append(element('p'));
    card.append(link('報名', '#apply/' + row.id));
  }
  return card;
}

const requestSelect = 'id,kind,course_id,room,requested_date,requested_time,status,created_at,cems_content(title)';
async function requests(admin) {
  const columns = admin ? requestSelect + ',name,organization,email,phone,notes' : requestSelect;
  const request = client.from('cems_requests').select(columns).order('created_at', { ascending: false }).limit(100);
  if (!admin) request.eq('user_id', session.user.id);
  const rows = await query(request);
  if (!rows.length) return element('p', '目前沒有申請。');
  const grid = element('div', '', { class: 'grid' });
  for (const row of rows) {
    const card = element('article', '', { class: 'card' });
    const title = row.kind === 'course' ? row.cems_content?.title ?? '課程報名' : row.room;
    card.append(element('h3', title), element('p', statuses[row.status]));
    if (row.requested_date) card.append(element('p', row.requested_date + ' ' + row.requested_time));
    if (admin) {
      card.append(element('p', [row.name, row.organization, row.email, row.phone, row.notes].filter(Boolean).join(' / '), { class: 'body' }));
      const status = choice('審核狀態', 'status', statuses);
      status.lastChild.value = row.status;
      card.append(form('更新申請', '儲存', [status], async (data) => {
        const updated = await query(client.from('cems_requests').update({ status: data.get('status') })
          .eq('id', row.id).eq('status', row.status).select('id').maybeSingle());
        await render();
        notice.textContent = updated ? '審核狀態已更新。' : '申請狀態已變更，請確認最新狀態。';
      }));
    }
    grid.append(card);
  }
  return grid;
}

function contentForm(row) {
  const kind = choice('類別', 'kind', sections);
  const title = field('標題', 'title', { maxlength: 200, required: '' });
  const body = field('內文', 'body', { tag: 'textarea', maxlength: 20000 });
  const url = field('HTTPS 連結', 'link', { type: 'url', pattern: 'https://.*', maxlength: 2048 });
  const published = field('公開', 'published', { type: 'checkbox' });
  if (row) {
    kind.lastChild.value = row.kind;
    kind.lastChild.disabled = true;
    title.lastChild.value = row.title;
    body.lastChild.value = row.body;
    url.lastChild.value = row.link ?? '';
    published.lastChild.checked = row.published;
  }
  return form(row ? '編輯內容' : '新增內容', '儲存', [kind, title, body, url, published], async (data) => {
    const values = {
      title: data.get('title').trim(),
      body: data.get('body').trim(),
      link: data.get('link').trim() || null,
      published: data.has('published'),
    };
    const table = client.from('cems_content');
    await query(row ? table.update(values).eq('id', row.id).select('id').single() : table.insert({ ...values, kind: data.get('kind') }));
    await render();
    notice.textContent = '內容已儲存。';
  });
}

function account() {
  const container = element('div');
  if (session) {
    container.append(
      element('p', session.user.email), link('我的申請', '#requests'),
      form('會員帳號', '登出', [], async () => {
        await query(client.auth.signOut());
        session = null;
        isAdmin = false;
        await render();
      })
    );
    return container;
  }
  const redirect = new URL('./', location.href).href;
  const email = () => field('電子郵件', 'email', { type: 'email', required: '', autocomplete: 'email' });
  const password = (purpose) => field('密碼', 'password', { type: 'password', required: '', minlength: 8, autocomplete: purpose });
  container.append(
    form('會員登入', '登入', [email(), password('current-password')], async (data) => {
      await query(client.auth.signInWithPassword(Object.fromEntries(data)));
    }),
    form('註冊測試帳號', '註冊', [email(), password('new-password')], async (data) => {
      const result = await query(client.auth.signUp({ ...Object.fromEntries(data), options: { emailRedirectTo: redirect } }));
      if (!result.session) notice.textContent = '請查收驗證信並完成註冊。';
    }),
    form('忘記密碼', '寄出重設連結', [email()], async (data) => {
      await query(client.auth.resetPasswordForEmail(data.get('email'), { redirectTo: redirect }));
      notice.textContent = '若該帳號可重設密碼，請查看信箱。';
    })
  );
  return container;
}

async function page(route, id) {
  if (route === 'home') return home();
  if (!client) return element('p', 'Supabase 尚未連線，資料與登入功能目前無法使用。');
  if (route === 'account') return account();
  if (Object.hasOwn(sections, route)) {
    const rows = await query(client.from('cems_content').select('*')
      .eq('kind', route).eq('published', true).order('created_at', { ascending: false }));
    const grid = element('div', '', { class: 'grid' });
    grid.append(...rows.map(contentCard));
    return rows.length ? grid : element('p', '目前沒有已發布的內容。');
  }
  if (!['rental', 'apply', 'requests', 'admin'].includes(route)) return element('p', '找不到此頁面。');
  if (!session) return link('請先登入會員', '#account');
  if (route === 'rental') return requestForm();
  if (route === 'requests') return requests(false);
  if (route === 'apply') {
    const course = await query(client.from('cems_content').select('id,title').eq('id', id)
      .eq('kind', 'course').eq('published', true).maybeSingle());
    return course ? requestForm(course) : element('p', '此課程目前無法報名。');
  }
  if (!isAdmin) return element('p', '此帳號沒有管理權限。');
  const [rows, queue] = await Promise.all([
    query(client.from('cems_content').select('*').order('created_at', { ascending: false })),
    requests(true),
  ]);
  const container = element('div');
  const entries = element('div', '', { class: 'grid' });
  for (const row of rows) {
    const entry = element('details');
    entry.append(element('summary', row.title), contentForm(row));
    entries.append(entry);
  }
  container.append(element('h2', '申請紀錄'), queue, element('h2', '網站內容'), contentForm(), entries);
  return container;
}

const routeTitles = { ...sections, account: '會員', rental: '場地借用', apply: '課程報名', requests: '我的申請', admin: '管理後台' };
let recovering = false;

async function render() {
  const version = ++renderVersion;
  const [route = 'home', id] = (location.hash.slice(1) || 'home').split('/');
  adminLink.hidden = !isAdmin;
  view.replaceChildren();
  if (recovering) {
    view.append(form('設定新密碼', '更新密碼', [
      field('新密碼', 'password', { type: 'password', minlength: 8, required: '', autocomplete: 'new-password' }),
    ], async (data) => {
      await query(client.auth.updateUser({ password: data.get('password') }));
      recovering = false;
      location.hash = 'account';
      await render();
      notice.textContent = '密碼已更新。';
    }));
    return;
  }
  if (route !== 'home') view.append(element('h1', Object.hasOwn(routeTitles, route) ? routeTitles[route] : '找不到此頁面'));
  try {
    const content = await page(route, id);
    if (version === renderVersion) view.append(content);
  } catch {
    if (version === renderVersion) view.append(element('p', '無法載入資料，請稍後重試。'));
  }
}

window.addEventListener('hashchange', render);
await render();

if (configured) {
  try {
    const { createClient } = await import('https://esm.sh/@supabase/supabase-js@2.89.0');
    client = createClient(supabaseUrl, supabasePublishableKey);
    let authVersion = 0;
    client.auth.onAuthStateChange((event, nextSession) => {
      if (event === 'PASSWORD_RECOVERY') recovering = true;
      if (event === 'SIGNED_OUT') recovering = false;
      const version = ++authVersion;
      session = nextSession;
      isAdmin = false;
      setTimeout(async () => {
        if (version !== authVersion) return;
        let admin = false;
        if (nextSession) {
          const { data } = await client.from('cems_admins').select('user_id').eq('user_id', nextSession.user.id).maybeSingle();
          admin = Boolean(data);
        }
        if (version !== authVersion) return;
        isAdmin = admin;
        await render();
      }, 0);
    });
  } catch {
    notice.textContent = '目前無法載入 Supabase 連線。';
  }
}

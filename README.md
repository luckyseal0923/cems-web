# CEMS WEB

新版前端位於 `docs/`，GitHub Pages 由 `main` 分支的 `/docs` 發布。原始 PHP 網站保留在 `sim_tmu/web/`。

## Supabase 測試環境

1. 在獨立測試專案執行 [資料庫 migration](supabase/migrations/20261119000000_cems.sql)。它一次建立內容、申請、管理員表、存取規則和三筆合成測試資料。
2. 在 Authentication 的 URL Configuration 設定 Site URL 為 `https://luckyseal0923.github.io/cems-web/`，並允許同一網址作為重新導向目的地。
3. 在 [config.js](docs/config.js) 填入 Project URL 和 Publishable key。這兩項會由瀏覽器讀取。管理金鑰與資料庫密碼應留在 Supabase 控制台。
4. 建立測試帳號並驗證信箱。如需後台權限，在 SQL Editor 將該帳號的 Auth User ID 加入管理員表。

```sql
insert into public.cems_admins (user_id)
values ('請替換成已確認的測試帳號 UUID')
on conflict do nothing;
```

## 驗收範圍

訪客可查看已發布的公告、課程、常見問題、下載與相關連結。會員可註冊、登入、重設密碼、送出課程報名與場地借用，以及查看自己的申請。管理員可審核申請及編輯網站內容。

新版使用繁體中文，並以合成資料起步。舊版的雙語內容、歷史會員和申請、附件、郵件通知、名額與場地排程規則需另行對照與移轉。場地申請由管理員人工查核時段。

## 原版公開網站

GitHub Pages 首頁轉到 `docs/tc/`，英文站位於 `docs/en/`。HTML 是以原版 PHP 版型產生，並沿用原有 CSS、圖片和前端互動。公開內容由 Supabase 的歷史資料在發布前轉成靜態頁面，瀏覽器無法存取私人 archive。會員與申請測試介面在 `docs/service.html`；原站 PHP 後台沒有部署到 Pages。

維護者可在具備原始備份、附件和本機匯入設定的工作區，使用 PHP CLI（含 PDO SQLite、mbstring）和 Python 套件 `psycopg[binary]`、`bleach[css]` 執行：

```powershell
python scripts/build-legacy.py --php C:/path/to/php.exe --output C:/path/to/cems-rendered
```

檢查輸出後，以產出的語系目錄和靜態資產更新 `docs/`。可加 `--local` 以原 MySQL 備份預覽。公開網站須重新產生與發布才會反映資料庫後續修改。

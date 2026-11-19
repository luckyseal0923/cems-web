"""Build the GitHub Pages presentation from the original CEMS public templates."""
import argparse
from collections import deque
from contextlib import closing
import html
import importlib.util
import os
from pathlib import Path
import posixpath
import re
import shutil
import sqlite3
import subprocess
import tempfile
from urllib.parse import parse_qsl, unquote, urlencode, urlsplit

import bleach
from bleach.css_sanitizer import CSSSanitizer

ROOT = Path(__file__).resolve().parents[1]
LEGACY = ROOT / "sim_tmu/web"
LANGUAGES = ("tc", "en")
TABLES = ("count", "course", "course_class1", "course_class2", "course_img", "faq",
          "faq_img", "filedown", "filedown_class1", "link_item", "news",
          "news_class1", "news_class2", "news_img")
LANG_PAGES = re.compile(r"(?:index|clause|p\d[\w-]*)\.php$")
PHP_URL = re.compile(r"(?P<quote>['\"])(?P<url>(?:\.\./(?:tc|en)/)?[\w-]+\.php(?:\?[^'\"<>\s]*)?)(?P=quote)")
PAGE_LINK = re.compile(r"javascript:GotoPage\((\d+),document\.SearchF,'[^']*'\);")
MEDIA = re.compile(r"(?:\.\./)?(?:images|css|js|fonts|engine1|Upload)/[^\s'\"<>?#()]+", re.I)
ASSET_TYPES = {".css", ".js", ".png", ".jpg", ".jpeg", ".gif", ".webp", ".svg", ".eot",
               ".woff", ".woff2", ".ttf", ".otf", ".pdf", ".doc", ".docx", ".xls", ".xlsx",
               ".ppt", ".pptx", ".ico"}
SERVICE = {"p4_login": "#account", "p4_join": "#account", "p4_forget": "#account",
           "p4_member": "#account", "p4_edit": "#account", "p4_mem_list": "#requests",
           "p4_mem_check": "#account", "mem_logout": "#account", "p5_classroom": "#rental",
           "mail": "#rental", "code": "#rental"}
CLEAN = bleach.Cleaner(
    tags=set(bleach.sanitizer.ALLOWED_TAGS) | set("p div span img br hr h1 h2 h3 h4 h5 h6 center font table thead tbody tr td th blockquote pre figure figcaption strong u sub sup ol ul li".split()),
    attributes={"*": ["class", "style", "align", "width", "height", "valign"],
                "a": ["href", "title", "target", "rel"], "img": ["src", "alt", "title"],
                "font": ["color", "size", "face"], "td": ["colspan", "rowspan"],
                "th": ["colspan", "rowspan"]},
    css_sanitizer=CSSSanitizer(), strip=True,
)


def public_snapshot(database, local):
    if local:
        spec = importlib.util.spec_from_file_location("cems_import", ROOT / "sim_tmu/mySQL/import_supabase.py")
        module = importlib.util.module_from_spec(spec)
        spec.loader.exec_module(module)
        columns, rows = module.load_backup(module.BACKUP.read_bytes())
        tables = [(table, [name for name, _ in columns[table]], rows[table]) for table in TABLES]
    else:
        import psycopg
        from psycopg import sql
        spec = importlib.util.spec_from_file_location("cems_import", ROOT / "sim_tmu/mySQL/import_supabase.py")
        module = importlib.util.module_from_spec(spec)
        spec.loader.exec_module(module)
        with psycopg.connect(host=module.HOST, port=5432, dbname="postgres",
                             user=f"postgres.{module.PROJECT}", password=module.read_password(),
                             sslmode="verify-full",
                             sslrootcert=str(module.BACKUP.with_name("prod-ca-2021.crt")),
                             connect_timeout=10) as connection, connection.cursor() as cursor:
            cursor.execute("set transaction read only")
            tables = []
            for table in TABLES:
                cursor.execute(sql.SQL("select * from {}").format(sql.Identifier(module.SCHEMA, table)))
                tables.append((table, [column.name for column in cursor.description], cursor.fetchall()))
    with closing(sqlite3.connect(database)) as connection, connection:
        for table, cols, rows in tables:
            declarations = ", ".join(
                '"' + col + '" ' + ("INTEGER" if any(isinstance(row[i], int) for row in rows) else "TEXT COLLATE NOCASE")
                for i, col in enumerate(cols)
            )
            connection.execute(f'CREATE TABLE "{table}" ({declarations})')
            placeholders = ",".join(["?"] * len(cols))
            content = [i for i, col in enumerate(cols) if col.lower().startswith("contents")]
            for row in rows:
                row = list(row)
                for index in content:
                    if isinstance(row[index], str):
                        row[index] = CLEAN.clean(row[index])
                for index, name in enumerate(cols):
                    if name.lower() in ("strname", "strteacher", "poname") and isinstance(row[index], str):
                        row[index] = html.escape(html.unescape(row[index]), quote=True)
                    if name.lower() in ("strurl", "strlink") and isinstance(row[index], str):
                        link = row[index].strip()
                        if urlsplit(link).scheme.lower() not in ("http", "https", ""):
                            link = ""
                        row[index] = html.escape(link, quote=True)
                connection.execute(f'INSERT INTO "{table}" VALUES ({placeholders})', row)
        connection.execute("CREATE TABLE rental_p (Classroom_PKey INTEGER, Rental_Date TEXT, Rental_Time TEXT)")
        return {
            table: {int(key): int(lang) for key, lang in connection.execute(
                f'SELECT PKey,intLang FROM "{table}"' + (
                    " WHERE Upload = 'Yes'" if table in ("course", "faq")
                    else " WHERE substr(OpenDate,1,10) <= date('now','+8 hours') AND substr(EndDate,1,10) >= date('now','+8 hours')"
                ))}
            for table in ("news", "course", "faq")
        }


def source_templates(work):
    for lang in LANGUAGES:
        (work / lang).mkdir()
        for original in (LEGACY / lang).glob("*.php"):
            shutil.copyfile(original, work / lang / original.name)
    (work / "include").mkdir()
    function = (LEGACY / "include/Function.php").read_text(encoding="utf-8-sig")
    start = function.index("class recordset")
    end = function.index("function alert", start)
    function = function[:start] + function[end:]
    function = function.replace("checkdate($mm,$dd,$yy)", "checkdate((int)$mm,(int)$dd,(int)$yy)")
    function = function.replace("if(is_file($PhotoUrl)){", "if(is_file('../' . $PhotoUrl)) $PhotoUrl = '../' . $PhotoUrl;\n\tif(is_file($PhotoUrl)){")
    start = re.search(r"(?im)^function authcode\(", function).start()
    end = re.search(r"(?im)^function \w+\(", function[start + 1:]).start() + start + 1
    function = function[:start] + function[end:]
    (work / "include/Function.php").write_text(function, encoding="utf-8")
    (work / "include/Conn.php").write_text("<?php\n", encoding="utf-8")
    # These local assets are used by the templates for getimagesize().
    for directory in ("images", "Upload"):
        shutil.copytree(LEGACY / directory, work / directory)


def output_name(page, params):
    stem = Path(page).stem
    suffix = "".join(f"--{key}-{value}" for key, value in params)
    return f"{stem}{suffix}.html"


def migrate_routes(text, lang, page, params, available, allowed, pending):
    text = PAGE_LINK.sub(lambda m: page + "?" + urlencode(dict(params, Page=m[1])), text)

    def rewrite(match):
        url = urlsplit(html.unescape(match["url"]))
        new_lang = Path(url.path).parent.name if url.path.startswith("../") else lang
        new_page = Path(url.path).name
        key = Path(new_page).stem
        prefix = "../" + new_lang + "/" if new_lang != lang else ""
        pairs = tuple(sorted((k, v) for k, v in parse_qsl(url.query)
                             if re.fullmatch(r"[a-zA-Z][a-zA-Z_0-9]*", k) and v.isdecimal() and len(v) < 10))
        if key in SERVICE:
            path = "../service.html" + SERVICE[key]
        elif (new_lang, new_page) not in available:
            return match[0]
        elif key.startswith(("p1_news_detail", "p3_course_detail", "p8_faq_detail")) and not key.endswith("2"):
            category = "news" if "news" in key else "course" if "course" in key else "faq"
            identity = int(dict(pairs).get("PKey", "0"))
            if allowed[category].get(identity) != LANGUAGES.index(new_lang) + 1:
                path = prefix + {"news":"p1_news.html", "course":"p3_course.html", "faq":"p8_faq.html"}[category]
            else:
                pending.append((new_lang, new_page, pairs))
                path = prefix + output_name(new_page, pairs)
        elif key in ("p5_classroom1", "p5_classroom_list"):
            path = "../service.html#rental"
        else:
            pending.append((new_lang, new_page, pairs))
            path = prefix + output_name(new_page, pairs)
        return match["quote"] + path + match["quote"]
    return PHP_URL.sub(rewrite, text)


def copy_media(text, output, copied, missing):
    for match in MEDIA.finditer(text):
        relative = unquote(posixpath.normpath(html.unescape(match[0]).removeprefix("../")))
        relative = relative.rstrip(";,")
        if relative in copied or Path(relative).suffix.lower() not in ASSET_TYPES:
            continue
        source = (LEGACY / relative).resolve()
        if not source.is_relative_to(LEGACY.resolve()):
            continue
        if not source.is_file():
            missing.add(relative)
            continue
        target = output / relative
        target.parent.mkdir(parents=True, exist_ok=True)
        shutil.copyfile(source, target)
        copied.add(relative)
        if source.suffix == ".css":
            css = source.read_text(encoding="utf-8-sig", errors="replace")
            target.write_text(css.replace("http://fonts.googleapis.com/", "https://fonts.googleapis.com/"), encoding="utf-8")
            css = re.sub(r"url\(\s*(['\"]?)([^)'\"]+)\1\s*\)",
                         lambda m: "url(" + posixpath.normpath(posixpath.join(posixpath.dirname(relative), m[2])) + ")"
                         if not re.match(r"(?:https?:|data:|/|#)", m[2]) else m[0], css)
            copy_media(css, output, copied, missing)


def remove_legacy_tracking(text):
    return re.sub(r"<!-- Global site tag \(gtag\.js\).*?</script>\s*<script>.*?</script>",
                  "", text, flags=re.S)


def fix_metadata(text):
    text = re.sub(r'(?i)([\w-]+\.php)?images/fb_img\.gif', '../images/all/logo.png', text)
    return text.replace('href="favicon.ico"', 'href="../images/all/logo.png"')


def build(php, output, local):
    output.mkdir(parents=True, exist_ok=True)
    copied, missing, done = set(), set(), set()
    available = {(lang, path.name) for lang in LANGUAGES for path in (LEGACY / lang).glob("*.php")
                 if LANG_PAGES.fullmatch(path.name) and path.stem not in ("p5_classroom1", "p5_classroom_list")}
    defaults = sorted((lang, page, ()) for lang, page in available
                      if "_detail" not in page or page.endswith("detail2.php"))
    pending = deque(defaults)
    with tempfile.TemporaryDirectory(prefix="cems-render-") as temporary:
        work = Path(temporary)
        source_templates(work)
        allowed = public_snapshot(work / "public.sqlite3", local)
        env = dict(os.environ, CEMS_SNAPSHOT=str(work / "public.sqlite3"))
        flags = ["-d", "short_open_tag=1", "-d", "display_errors=stderr",
                 "-d", "extension_dir=" + str(php.parent / "ext"), "-d", "extension=pdo_sqlite",
                 "-d", "extension=mbstring"]
        while pending:
            lang, page, params = key = pending.popleft()
            if key in done:
                continue
            path = work / lang / page
            result = subprocess.run([str(php), *flags, str(ROOT / "scripts/render-legacy.php"),
                                     str(path), urlencode(params)], env=env, capture_output=True, timeout=15)
            if result.returncode:
                raise RuntimeError(f"Render failed for {lang}/{page} {params}: {result.stderr.decode('utf-8', 'replace')[-2000:]}")
            text = fix_metadata(remove_legacy_tracking(result.stdout.decode("utf-8-sig")))
            text = migrate_routes(text, lang, page, params, available, allowed, pending)
            copy_media(text, output, copied, missing)
            dest = output / lang / output_name(page, params)
            dest.parent.mkdir(exist_ok=True)
            dest.write_text(text, encoding="utf-8")
            done.add(key)
    print(f"Generated {len(done)} pages and copied {len(copied)} referenced assets.")
    print(f"Missing asset references in the original backup: {len(missing)}.")


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--php", type=Path, required=True)
    parser.add_argument("--output", type=Path, required=True)
    parser.add_argument("--local", action="store_true", help="Read the local backup instead of Supabase")
    arguments = parser.parse_args()
    build(arguments.php.resolve(), arguments.output.resolve(), arguments.local)

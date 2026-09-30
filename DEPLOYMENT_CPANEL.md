# cPanel Git Deployment

This project is plain PHP. The site needs PHP 8.1+, `pdo_mysql`, `mbstring`, `fileinfo`, MySQL/MariaDB, Apache `mod_rewrite`, and the `.htaccess` overrides described in the README. It has no Composer dependencies, Node build, asset compilation, or Node runtime requirement.

## Layout

Keep the Git checkout outside the document root where possible:

```text
/home/CPANEL_USER/
  .env
  logs/saudivisit-php-error.log
  repositories/saudivisit/       # cPanel Git checkout
  public_html/                   # live document root for the domain
    .saudivisit-deploy-target    # explicit deployment safety marker
```

The live root receives only the PHP runtime, admin endpoints, templates, app/config PHP, `.htaccess`, and browser assets. `.htaccess` blocks HTTP access to private code/data paths. Keep the repository, `.env`, logs, database exports, and backups outside the document root. If the domain uses a different document root, use its real absolute path as `DEPLOYMENT_TARGET` and put the marker there. `robots.txt` is dynamically served through the same protected configuration so its sitemap URL uses the configured production domain.

`config/config.php` looks for `.env` at the parent of the document root before checking within the root. `APP_ENV_FILE` can name another absolute file if needed. Do not upload `.env.example` as `.env` or use placeholders as working credentials.

## Production values

Create `/home/CPANEL_USER/.env` with mode `600` if cPanel Terminal permits it. Substitute actual hosting values locally; do not commit this file:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_FORCE_HTTPS=true
APP_BASE_PATH=
APP_LOG_FILE=/home/CPANEL_USER/logs/saudivisit-php-error.log
SITE_URL=https://YOUR_DOMAIN.example
DB_HOST=CPANEL_DATABASE_HOST
DB_PORT=3306
DB_NAME=CPANEL_DATABASE_NAME
DB_USER=CPANEL_DATABASE_USER
DB_PASS=YOUR_UNIQUE_DATABASE_PASSWORD
DB_CHARSET=utf8mb4
```

For a subfolder install, set `APP_BASE_PATH=/your-subfolder`; for a domain rooted at `public_html`, leave it empty. cPanel commonly prefixes database/user names with the account name. Use the exact values shown in cPanel's MySQL Databases screen. Create the private `logs` directory if it does not exist and make it writable by the PHP account. Do not set `APP_DEBUG=true` in production.

## First deployment

1. In cPanel, select a PHP 8.1+ version for the domain and enable `pdo_mysql`, `mbstring`, and `fileinfo`. Confirm Apache `mod_rewrite` is available and `.htaccess` overrides are allowed.
2. In **MySQL Databases**, create an empty database and a unique database user; grant the user all required privileges on that database. Record the exact prefixed names and host.
3. Create the Git repository in a path outside the domain's document root, such as `/home/CPANEL_USER/repositories/saudivisit`, using cPanel **Git Version Control**. Connect it to the GitHub repository and check out the intended production branch. No SSH is required for cPanel-managed Git checkout; HTTPS authentication or a deploy key is configured in cPanel/GitHub.
4. In **Domains**, point the domain's document root to the intended live directory, typically `/home/CPANEL_USER/public_html`. Do not change DNS or the live root until the destination is ready.
5. In cPanel File Manager, create `.saudivisit-deploy-target` directly inside that existing document root. Its complete contents must be exactly `saudivisit-cpanel-public-root-v1` on one line. The script refuses to deploy without this marker.
6. Copy `.env.example` to `/home/CPANEL_USER/.env` using File Manager or Terminal. Replace every placeholder with real values, including `SITE_URL`, database name/user/password, and absolute log path. Never put these values in GitHub, `.cpanel.yml`, or the document root.
7. Edit `.cpanel.yml` in the checkout and replace `/home/CPANEL_USER/public_html` with the actual document-root path. This is a path-only deployment setting; do not put secrets in it. Configure the repository's deployment branch in cPanel.
8. Back up the current document root and database before the first live copy if either already contains data. Run the cPanel deployment from **Git Version Control > Manage > Deploy HEAD Commit**. The script copies an explicit runtime allowlist, merges directories, and never removes existing files, uploads, `.env`, logs, or the safety marker.
9. Open the HTTPS homepage, a destination and article route, `/sitemap.xml`, and `/admin/login.php`. Create the first admin user as described below. Confirm media upload works, then verify uploaded images load and PHP files in the upload directory cannot execute.

### Initial database and first administrator

The first import is only `database/schema.sql`, into the empty production database selected in phpMyAdmin. This schema file does not create or select a database; the cPanel database user does not need global database-creation privileges. **Do not import `database/seed.sql` in production.** It is demo content; production content must be created through the CMS or reviewed editorial imports.

Create a unique administrator password and hash it on a trusted PHP CLI (cPanel Terminal if PHP CLI is available):

```sh
php -r '$password = readline("New admin password: "); echo password_hash($password, PASSWORD_DEFAULT), PHP_EOL;'
```

Insert a user in phpMyAdmin, replacing the email, name, and `PASTE_GENERATED_HASH` with the administrator's own values/hash:

```sql
INSERT INTO users (email, password_hash, name, role)
VALUES ('admin@YOUR_DOMAIN.example', 'PASTE_GENERATED_HASH', 'Site Administrator', 'admin');
```

If PHP CLI is unavailable, generate the hash locally with PHP 8.1+ and transfer only the hash over an authenticated cPanel session. Do not use the local demo accounts.

## Later updates

1. Back up the live document root and export the database before every update, especially when schema/data changes are involved.
2. Commit reviewed changes and push them to the configured GitHub branch. Do not include `.env`, user uploads, logs, caches, backups, or local database dumps.
3. In cPanel **Git Version Control**, use **Update from Remote** to update the repository checkout. This changes the checkout only; it does **not** change the live document root.
4. Review the pulled commit and deploy it using **Deploy HEAD Commit**. This runs `.cpanel.yml` and copies the allowlisted runtime files to the live root. It does not run Composer, Node, SQL, migrations, or seed data.
5. Smoke-test the homepage, representative locale routes, admin sign-in, forms, uploads, and sitemap. Check cPanel/PHP logs if a request fails; browser errors are hidden in production.

If a change needs a database schema migration, prepare a separate versioned SQL migration first. Back up the database, test it on a staging copy, then run that migration manually against the intended database. Never rerun the initial schema or import seed data as an update. Deploy code only when it remains compatible with the currently installed schema; use expand-then-contract migrations when rollback code may still run against both schema versions.

## Backup and rollback

- Before deployment, use cPanel File Manager/Terminal to make a dated copy of the live document root outside the web root. Include hidden files and preserve uploads; do not copy `.env` into a public backup location.
- Export the full MySQL database with phpMyAdmin (or a supported `mysqldump`) to a private location outside the web root. Keep the database export encrypted and access-controlled.
- The deployment script never deletes files. To roll back PHP/assets, restore the dated files from the backup or deploy the previous known-good Git commit. Preserve the current `.env`, deployment marker, newly uploaded media, and hosting files while restoring.
- Roll back a database only if code/schema compatibility requires it and after considering writes made since the backup. Restoring a dump discards later content and user changes. Prefer a forward-fix migration when possible; never restore an older schema under newer code without checking compatibility.
- Verify the site and admin after rollback. Keep the failed release and logs outside the document root for diagnosis.

## cPanel-specific values to supply

- cPanel account name and absolute repository checkout path.
- Domain's actual document-root path and production branch name.
- PHP version and whether required extensions/Apache modules are enabled.
- cPanel-prefixed database name/user, database host/port, and a unique password.
- Canonical HTTPS domain (and optional subfolder base path).
- Private log path and PHP write permissions.
- The GitHub repository URL and cPanel-supported authentication method.

## GitHub commands

Review `git status` first. This workspace already contains substantial pre-existing deletions and edits; do not stage those unless they are intentional. Stage only the deployment changes you have reviewed:

```sh
git add -- .gitignore .env.example .cpanel.yml .htaccess README.md DEPLOYMENT_CPANEL.md config/config.php app/db.php app/auth.php app/helpers.php index.php sitemap.php robots.php robots.txt templates/destinations.php templates/guides.php templates/layout.php database/schema.sql database/seed.sql assets/favicon.ico assets/favicon-16x16.png assets/favicon-32x32.png assets/apple-touch-icon.png assets/images/.gitkeep assets/uploads/.gitkeep assets/uploads/.htaccess storage/cache/.gitkeep storage/logs/.gitkeep storage/uploads/.gitkeep scripts/deploy-cpanel.sh
git status --short
git commit -m "Prepare SaudiVisit for cPanel deployment"
git remote add origin https://github.com/USERNAME/REPOSITORY.git
git push -u origin YOUR_BRANCH
```

Use `git remote set-url origin https://github.com/USERNAME/REPOSITORY.git` instead of `git remote add` if an `origin` already exists. Replace repository and branch placeholders; never put a GitHub token in a command, file, or commit.

## বাংলা: cPanel-এ প্রথম সংযোগ ও ডিপ্লয়

1. cPanel-এর **Git Version Control** থেকে `/home/CPANEL_USER/repositories/saudivisit`-এর মতো document root-এর বাইরের ফোল্ডারে repository clone করুন। GitHub repository URL এবং cPanel-সমর্থিত HTTPS authentication বা deploy key ব্যবহার করুন। Git checkout নিজে live website নয়।
2. cPanel **Domains**-এ domain-এর document root ঠিক করুন; সাধারণত এটি `/home/CPANEL_USER/public_html`। আপনার প্রকৃত path আলাদা হলে সেটিই ব্যবহার করুন।
3. File Manager-এ ওই document root-এর ভেতর `.saudivisit-deploy-target` নামে ফাইল বানান। ফাইলে এক লাইনে হুবহু `saudivisit-cpanel-public-root-v1` লিখুন। এই marker না থাকলে deployment script কোনো ফাইল কপি করবে না।
4. cPanel **MultiPHP Manager/Select PHP Version** থেকে PHP 8.1 বা নতুন সংস্করণ নিন; `pdo_mysql`, `mbstring`, `fileinfo` extension চালু আছে নিশ্চিত করুন। Apache `mod_rewrite` ও `.htaccess` অনুমতি থাকতে হবে।
5. cPanel **MySQL Databases** থেকে database ও আলাদা user বানিয়ে সেই database-এ প্রয়োজনীয় privileges দিন। database/user-এর cPanel prefix-সহ সম্পূর্ণ নাম লিখে রাখুন।
6. `.env.example`-এর কপি document root-এর বাইরে `/home/CPANEL_USER/.env` নামে রাখুন। `SITE_URL`, database host/name/user/password, production mode এবং private log path-এ আসল মান দিন। `.env` GitHub-এ commit করবেন না; placeholder অপরিবর্তিত রাখবেন না।
7. checkout-এর `.cpanel.yml`-এ `/home/CPANEL_USER/public_html`-কে আপনার সঠিক document-root path দিয়ে বদলান। এটি কেবল path; কোনো password বা secret এখানে রাখবেন না।
8. প্রথমবার live deployment-এর আগে আগে থেকে থাকা website files ও database-এর private backup নিন। cPanel **Git Version Control > Manage > Deploy HEAD Commit** চালান। এতে checkout থেকে নির্বাচিত PHP/assets document root-এ কপি হবে; `.env`, upload, log বা hosting-এর অন্য file মুছবে না।
9. phpMyAdmin-এ সঠিক database নির্বাচন করে শুধু `database/schema.sql` একবার import করুন। production-এ `database/seed.sql` import করবেন না। PHP CLI দিয়ে administrator-এর নিজের password hash তৈরি করে `users` টেবিলে admin যোগ করুন।
10. HTTPS homepage, `/en/`, destination/article page, `/sitemap.xml`, `/admin/login.php` এবং media upload পরীক্ষা করুন। HTTPS/SSL certificate আগে সক্রিয় করুন।

### পরবর্তী update

1. পরিবর্তন review করে GitHub branch-এ commit/push করুন; `.env`, upload, log, backup বা database dump যোগ করবেন না।
2. cPanel-এর **Update from Remote** checkout-এ নতুন commit আনে; এতে live site বদলায় না।
3. এরপর **Deploy HEAD Commit** চালালে `.cpanel.yml` runtime file-গুলো live document root-এ কপি করে। এটিই live deployment ধাপ।
4. প্রতিটি update-এর আগে files ও database backup নিন। schema পরিবর্তন হলে আলাদা versioned migration staging-এ পরীক্ষা করে backup-এর পর হাতে চালান; initial schema বা demo seed আবার চালাবেন না।
5. deployment ব্যর্থ হলে আগের file backup বা আগের পরিচিত ভালো Git commit deploy করে code ফিরিয়ে নিন। database restore করলে backup-এর পরের content হারাতে পারে; compatibility যাচাই ছাড়া পুরোনো database নতুন code-এর সঙ্গে চালাবেন না।
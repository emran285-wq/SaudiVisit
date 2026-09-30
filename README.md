# SaudiVisit

SaudiVisit is a custom, plain-PHP editorial site and CMS. It uses PHP 8.1 or newer, MySQL/MariaDB through PDO, and Apache `mod_rewrite`. It has no framework, Composer packages, Node build, or production development server.

## Runtime requirements

- PHP 8.1+ with `pdo_mysql`, `mbstring`, and `fileinfo` enabled.
- MySQL 5.7+ or MariaDB 10.3+; InnoDB and `utf8mb4` support.
- Apache with `mod_rewrite`, `mod_headers`, and permission to use the included `.htaccess` directives.
- Writable `assets/uploads` for CMS media uploads and a private writable log path configured by `APP_LOG_FILE`.

## Local setup

1. Create a MySQL database and user, then grant the user access to that database.
2. Import `database/schema.sql` into the selected database. `database/seed.sql` contains demo content only; do not import it into production.
3. Copy `.env.example` to `.env` in the project root and set local database credentials. For local XAMPP, use `APP_ENV=local`, `APP_DEBUG=true`, and `APP_FORCE_HTTPS=false`. `.env` is ignored by Git.
4. Enable Apache `mod_rewrite` and `AllowOverride All` for the project directory.
5. Visit `http://localhost/saudivisit/`; the root redirects to `/en/`. Admin sign-in is at `/admin/login.php`.

If you import demo seed data locally, set a password hash before signing in. Generate a hash with PHP CLI, then update the demo user's `password_hash` in your local database. The checked-in demo accounts cannot authenticate until you replace the reset marker.

## Structure

| Path | Purpose |
|---|---|
| `index.php` | Public front controller and locale routes |
| `admin/` | CMS sign-in, content, media, pages, and redirects |
| `app/` | PDO queries, authentication, helpers, and SEO |
| `config/config.php` | Environment loading, app configuration, and bootstrap |
| `templates/` | Public page templates |
| `assets/css`, `assets/js`, `assets/images` | Browser assets; already production-ready, no build step |
| `assets/favicon.ico`, favicon PNGs, `assets/apple-touch-icon.png` | Multi-size browser icon and Apple touch icon |
| `assets/uploads/` | Writable user-upload directory; contents are not versioned |
| `database/schema.sql` | Initial database schema only |
| `database/seed.sql` | Optional local demo data, never production data |
| `sitemap.php`, `robots.php`, `robots.txt` | Internal sitemap/robots endpoints; public sitemap is `/sitemap.xml` |
| `scripts/deploy-cpanel.sh`, `.cpanel.yml` | Guarded allowlist deployment into a marked document root |

## Configuration

The app reads the process environment first, then an optional `.env` file. It checks `APP_ENV_FILE`, the parent of the project/document root, and finally the project root. On cPanel, keep `.env` outside `public_html`, normally at `/home/CPANEL_USER/.env`. `SITE_URL` must be the origin only, with no path. Production defaults to HTTPS redirects, secure session cookies, hidden browser errors, and a log outside the document root.

Configuration variables and deployment steps are documented in [DEPLOYMENT_CPANEL.md](DEPLOYMENT_CPANEL.md). Never commit `.env`, passwords, production exports, logs, or uploaded media.

## CMS workflow

Articles move through `draft`, `in_review`, `fact_review`, `approved`, `published`, and `archived`. Writers manage their drafts, reviewers fact-check, and editors/admins approve and publish. Saves create revisions and workflow actions are audit-logged; changing a published slug creates a redirect. Published-only filters protect public pages, search, and the sitemap.

## Routing and dependencies

Existing locale routes and admin PHP endpoints are preserved. Requests for existing assets and files are served directly; other public routes reach `index.php`. PHP handles requests in production; no Node server, Composer install, dependency lockfile, or asset compilation is required. cPanel Git updates the checkout; the separate deploy script copies only runtime files into the live document root.

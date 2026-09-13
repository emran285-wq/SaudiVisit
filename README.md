# SaudiVisit.net

SaudiVisit.net is a PHP travel platform for Saudi Arabia destinations, long-form travel guides, attractions and a rule-based trip planner. It uses PHP 8+, semantic HTML, responsive CSS and vanilla JavaScript with no runtime framework or database dependency.
## Features

- Destination guides for Riyadh, Jeddah, AlUla, Makkah, Madinah, Abha, Taif and Dammam.
## Requirements

- PHP 8.1 or newer.
- Apache with PHP; `mod_rewrite` is recommended.
- MySQL is not required for the current static-data release.
## Repository Layout

```text
app/                 Bootstrap boundary for future modules
data/                Current PHP content data
includes/            Runtime config, helpers and shared templates
public/              Production document-root wrappers and copied assets
assets/              Legacy XAMPP asset source, preserved for compatibility
database/             Sanitized future schema only
storage/              Runtime cache, logs and uploads; never commit contents
scripts/              Maintenance and validation scripts
.github/workflows/    PHP syntax CI
```
## Local Installation

```powershell
git clone YOUR_GITHUB_REPOSITORY_URL saudivisit
cd saudivisit
Copy-Item .env.example .env
```
## Configuration

Copy `.env.example` to `.env`. Never commit `.env`. Important variables are:

- `APP_ENV=local` or `production`.
- `APP_DEBUG=true` locally and `false` in production.
- `APP_URL` for the current browser origin.
- `APP_BASE_PATH` for a subdirectory, or blank when `public/` is the document root.
- `SITE_URL` for canonical production SEO URLs.
- `DB_*` placeholders for a future database migration only.
## Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md). The preferred setup points the hosting document root at `public/`, sets production environment variables, enables HTTPS and keeps `.env`, `storage/`, database files and source data outside the public root. A fallback section covers hosts that only provide `public_html`.
## GitHub Safety Checklist

Before the first push:

- [ ] `.env` is absent and `.env.example` contains no secrets.
- [ ] No passwords, API keys, private customer data or database backups are present.
- [ ] Runtime logs, cache and uploads are ignored.
- [ ] Local PHP syntax and page checks pass.
- [ ] Production `SITE_URL` and `APP_DEBUG=false` are documented in hosting settings.
## Maintenance

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
git pull origin main
git add .
git commit -m "content: expand Riyadh travel guide"
git push origin main
```

Travel information can change. Verify visa, pilgrimage, opening-hour, ticket, safety, weather and transport details through authoritative sources before publishing or travelling.

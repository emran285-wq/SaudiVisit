# Deployment Guide

## Method A: Hosting panel Git integration

1. Create or select a private GitHub repository.
2. Connect the hosting panel to the repository and choose the `main` branch.
3. Set the document root to the repository's `public/` directory.
4. Configure `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://saudivisit.net`, `APP_BASE_PATH=` and `SITE_URL=https://saudivisit.net` in the hosting environment.
5. Enable HTTPS and confirm Apache rewrite support.
6. Deploy, then test the homepage, an article, a destination, the planner, sitemap and 404 page.

## Method B: Pull over SSH

```bash
cd /path/to/site
git pull origin main
```

Configure environment variables outside Git. Do not run `git clean -fd` on production because it can delete uploads or runtime files. Keep `.env`, `storage/` and user uploads outside the release checkout where possible.

## Method C: GitHub Actions

The repository includes a syntax-check workflow at `.github/workflows/php-check.yml`. An actual deployment workflow is intentionally not enabled because hosting providers differ. If one is added, store `SSH_HOST`, `SSH_USER`, `SSH_KEY`, `FTP_HOST`, `FTP_USERNAME` and `FTP_PASSWORD` in GitHub Secrets; never put them in YAML or PHP.

## Hosts without a custom document root

If the host only supports `public_html`, copy the contents of `public/` into `public_html` and keep the application directories outside it. The wrapper pages in `public/` load the existing application files from the repository parent, so the repository should remain one level above `public_html` when the host supports that layout. If the host forces everything into `public_html`, deny access to `.env`, `app`, `data`, `includes`, `database` and `storage` using server rules and prefer a host with a configurable document root.

## Permissions and runtime data

The web process needs read access to application files and write access only to required runtime directories such as `storage/logs` and `storage/cache`. Use the hosting provider's normal user/group permissions; do not use `777`. Do not deploy production uploads or logs from Git.

## Post-deployment checklist

- HTTPS redirects and canonical URLs point to `https://saudivisit.net`.
- `robots.txt` allows public pages and references the production sitemap.
- `/sitemap.xml` contains production URLs.
- Homepage, destination, article, attractions, planner, contact and 404 routes work.
- PHP errors are logged but not displayed.
- `.env`, source data, SQL and storage paths are not browser-readable.
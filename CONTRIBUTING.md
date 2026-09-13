# Contributing

## Workflow

- `main` is the production-ready branch.
- Use short feature branches such as `feature/article-seo` or `fix/mobile-menu`.
- Keep runtime data, `.env`, uploads and logs outside commits.

## Local checks

Run PHP syntax validation before opening a pull request:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

## Commit examples

```text
feat: add AlUla destination guide
fix: repair mobile navigation
seo: improve Riyadh article metadata
content: expand Saudi Arabia travel guide
refactor: move URL logic to helper
chore: update gitignore
```

## Content changes

Preserve existing slugs and write useful, source-conscious content. Do not add credentials, private data, generated logs or production backups.

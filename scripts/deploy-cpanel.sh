#!/usr/bin/env bash
set -Eeuo pipefail

fail() {
    printf 'Deployment stopped: %s\n' "$1" >&2
    exit 1
}

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"
repo_root="$(cd -- "$script_dir/.." && pwd -P)"
target_input="${DEPLOYMENT_TARGET:-}"

[[ -n "$target_input" ]] || fail 'set DEPLOYMENT_TARGET to the existing live document root.'
[[ "$target_input" = /* ]] || fail 'DEPLOYMENT_TARGET must be an absolute path.'
[[ -d "$target_input" ]] || fail 'DEPLOYMENT_TARGET does not exist or is not a directory.'
[[ ! -L "$target_input" ]] || fail 'DEPLOYMENT_TARGET must not be a symlink; use its resolved directory path.'

target_root="$(cd -- "$target_input" && pwd -P)"
[[ "$target_root" != "$repo_root" && "$target_root" != "$repo_root/"* ]] || fail 'the live document root cannot be the repository checkout or a child of it.'
[[ -f "$target_root/.saudivisit-deploy-target" ]] || fail 'create the deployment marker in the intended document root first.'
[[ ! -L "$target_root/.saudivisit-deploy-target" ]] || fail 'the deployment marker must be a regular file.'
[[ "$(<"$target_root/.saudivisit-deploy-target")" == 'saudivisit-cpanel-public-root-v1' ]] || fail 'the deployment marker content does not match.'

for required in .htaccess index.php sitemap.php robots.php admin app config/config.php templates assets/css assets/js assets/images assets/uploads/.htaccess assets/favicon.ico assets/favicon-16x16.png assets/favicon-32x32.png assets/apple-touch-icon.png; do
    [[ -e "$repo_root/$required" ]] || fail "required repository path is missing: $required"
done

# Copy only runtime paths. cp merges directories and never removes server files.
for item in .htaccess index.php sitemap.php robots.php robots.txt admin app templates; do
    cp -a -- "$repo_root/$item" "$target_root/"
done
mkdir -p -- "$target_root/assets"
for item in css js images; do
    cp -a -- "$repo_root/assets/$item" "$target_root/assets/"
done
for item in favicon.ico favicon-16x16.png favicon-32x32.png apple-touch-icon.png; do
    cp -a -- "$repo_root/assets/$item" "$target_root/assets/"
done
mkdir -p -- "$target_root/assets/uploads"
cp -a -- "$repo_root/assets/uploads/.htaccess" "$target_root/assets/uploads/"
mkdir -p -- "$target_root/config"
cp -a -- "$repo_root/config/config.php" "$target_root/config/"

printf 'Deployment files copied to %s\n' "$target_root"
printf 'Existing uploads, environment files, logs, database files, and hosting files were not removed.\n'
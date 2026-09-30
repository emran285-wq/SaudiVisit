<?php
/**
 * SaudiVisit.net — configuration
 * Environment configuration for local and shared-hosting deployments.
 */

declare(strict_types=1);

function load_application_environment(): void
{
    $explicitFile = getenv('APP_ENV_FILE');
    $envFiles = [];
    if ($explicitFile !== false && $explicitFile !== '') {
        $envFiles[] = $explicitFile;
    }
    $envFiles[] = dirname(__DIR__, 2) . '/.env';
    $envFiles[] = dirname(__DIR__) . '/.env';

    foreach (array_unique($envFiles) as $envFile) {
        if (!is_file($envFile) || !is_readable($envFile)) {
            continue;
        }
        foreach (file($envFile, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (str_starts_with($line, 'export ')) {
                $line = substr($line, 7);
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            if (!preg_match('/^[A-Z_][A-Z0-9_]*$/', $name) || getenv($name) !== false) {
                continue;
            }
            $value = trim($value);
            if (strlen($value) >= 2 && (($value[0] === '"' && str_ends_with($value, '"')) || ($value[0] === "'" && str_ends_with($value, "'")))) {
                $value = substr($value, 1, -1);
            }
            putenv($name . '=' . $value);
            $_ENV[$name] = $value;
        }
    }
}

function application_env(string $name, ?string $default = null): ?string
{
    $value = getenv($name);
    return $value === false ? $default : $value;
}

function application_env_bool(string $name, bool $default): bool
{
    $value = application_env($name);
    if ($value === null || $value === '') {
        return $default;
    }
    $parsed = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    return $parsed ?? $default;
}

load_application_environment();

$appEnvironment = application_env('APP_ENV', 'local') ?: 'local';
if (!in_array($appEnvironment, ['local', 'staging', 'production'], true)) {
    throw new RuntimeException('APP_ENV must be local, staging, or production.');
}
define('APP_ENV', $appEnvironment);
define('APP_DEBUG', APP_ENV === 'production' ? false : application_env_bool('APP_DEBUG', true));
define('APP_FORCE_HTTPS', application_env_bool('APP_FORCE_HTTPS', APP_ENV === 'production'));

// Base URL path is inferred for local subfolder installs or explicitly configured.
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$detectedBasePath = preg_replace('~/(?:admin/[^/]+|[^/]+\.php)$~i', '', $scriptName) ?? '';
$configuredBasePath = application_env('APP_BASE_PATH', $detectedBasePath) ?? '';
$basePath = '/' . trim(str_replace('\\', '/', $configuredBasePath), '/');
define('BASE_PATH', $basePath === '/' ? '' : $basePath);
define('SITE_NAME', 'SaudiVisit');
define('SITE_TAGLINE', 'Plan Saudi with confidence.');
define('DEFAULT_LOCALE', 'en');
define('SUPPORTED_LOCALES', ['en']); // future: 'bn', 'ar'

// Database credentials are required from the process environment or an untracked .env.
define('DB_HOST', application_env('DB_HOST', '') ?? '');
define('DB_PORT', application_env('DB_PORT', '3306') ?? '3306');
define('DB_NAME', application_env('DB_NAME', '') ?? '');
define('DB_USER', application_env('DB_USER', '') ?? '');
define('DB_PASS', application_env('DB_PASS', '') ?? '');
define('DB_CHARSET', application_env('DB_CHARSET', 'utf8mb4') ?? 'utf8mb4');
if (!ctype_digit(DB_PORT) || (int)DB_PORT < 1 || (int)DB_PORT > 65535) {
    throw new RuntimeException('DB_PORT must be a valid TCP port.');
}

// SITE_URL is the origin only; BASE_PATH is appended separately by URL helpers.
$requestIsHttps = (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') || (int)($_SERVER['SERVER_PORT'] ?? 0) === 443;
$requestScheme = $requestIsHttps ? 'https' : 'http';
$requestHost = (string)($_SERVER['HTTP_HOST'] ?? '');
$detectedSiteUrl = $requestHost !== '' ? (APP_FORCE_HTTPS ? 'https' : $requestScheme) . '://' . $requestHost : 'https://example.invalid';
if (APP_ENV === 'production' && application_env('SITE_URL') === null) {
    throw new RuntimeException('SITE_URL must be set to the production HTTPS origin.');
}
$siteUrl = rtrim(application_env('SITE_URL', $detectedSiteUrl) ?? $detectedSiteUrl, '/');
$siteUrlParts = parse_url($siteUrl);
if (!filter_var($siteUrl, FILTER_VALIDATE_URL) || !in_array($siteUrlParts['scheme'] ?? '', ['http', 'https'], true) || !empty($siteUrlParts['user']) || !empty($siteUrlParts['pass']) || !in_array($siteUrlParts['path'] ?? '', ['', '/'], true) || isset($siteUrlParts['query']) || isset($siteUrlParts['fragment'])) {
    throw new RuntimeException('SITE_URL must be an absolute HTTP or HTTPS origin without credentials, path, query, or fragment.');
}
if (APP_ENV === 'production' && APP_FORCE_HTTPS && ($siteUrlParts['scheme'] ?? '') !== 'https') {
    throw new RuntimeException('SITE_URL must use HTTPS when APP_FORCE_HTTPS is enabled in production.');
}
define('SITE_URL', $siteUrl);

if (APP_FORCE_HTTPS && !$requestIsHttps) {
    $requestUri = (string)($_SERVER['REQUEST_URI'] ?? '/');
    if (!str_starts_with($requestUri, '/') || str_starts_with($requestUri, '//')) {
        $requestUri = '/';
    }
    header('Location: ' . SITE_URL . $requestUri, true, 301);
    exit;
}

// Editorial review SLAs (days) per PRD section 7
define('REVIEW_SLA_POLICY', 30);
define('REVIEW_SLA_TRANSPORT', 60);
define('REVIEW_SLA_EVERGREEN', 180);

error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
$errorLog = application_env('APP_LOG_FILE', dirname(__DIR__, 2) . '/logs/saudivisit-php-error.log') ?? '';
if ($errorLog !== '') {
    $errorLogDirectory = dirname($errorLog);
    if (!is_dir($errorLogDirectory)) {
        @mkdir($errorLogDirectory, 0700, true);
    }
    ini_set('error_log', $errorLog);
}

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/seo.php';

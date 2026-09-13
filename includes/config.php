<?php
/** SaudiVisit.net runtime configuration. */

declare(strict_types=1);

$rootPath = dirname(__DIR__);
$envFile = $rootPath . DIRECTORY_SEPARATOR . '.env';

if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if ($value !== '' && (($value[0] ?? '') === '"' || ($value[0] ?? '') === "'")) {
            $value = trim($value, "\"'");
        }
        if ($name !== '' && getenv($name) === false) {
            putenv($name . '=' . $value);
        }
    }
}

$environment = getenv('APP_ENV') ?: 'local';
$appUrl = rtrim((string) (getenv('APP_URL') ?: 'http://localhost/saudivisit'), '/');
$siteUrl = rtrim((string) (getenv('SITE_URL') ?: 'https://saudivisit.net'), '/');
$basePath = rtrim((string) (getenv('APP_BASE_PATH') ?: '/saudivisit'), '/');
$debug = filter_var(getenv('APP_DEBUG') ?: ($environment === 'local' ? 'true' : 'false'), FILTER_VALIDATE_BOOLEAN);

define('ROOT_PATH', $rootPath);
define('APP_ENV', $environment);
define('APP_DEBUG', $debug);
define('BASE_URL', $appUrl);
define('SITE_URL', $siteUrl);
define('BASE_PATH', $basePath);
define('SITE_NAME', 'SaudiVisit.net');
define('SITE_DESCRIPTION', 'Independent Saudi Arabia travel guide and trip planning platform');
define('SITE_YEAR', date('Y'));
define('ASSETS_PATH', BASE_PATH . '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');
define('SOCIAL_TWITTER', '@saudivisit');
define('SOCIAL_FACEBOOK', 'saudivisit.net');
define('DEFAULT_TITLE', SITE_NAME . ' – Saudi Arabia Travel Guide 2026');
define('DEFAULT_DESCRIPTION', 'Plan your Saudi Arabia trip with destination guides, itineraries, attractions, cultural tips and travel advice.');
define('CANONICAL_DOMAIN', SITE_URL);

define('ORGANIZATION_JSON', [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => SITE_NAME,
    'url' => SITE_URL,
    'logo' => SITE_URL . '/assets/images/logo.png',
    'description' => SITE_DESCRIPTION,
    'sameAs' => [
        'https://twitter.com/saudivisit',
        'https://www.facebook.com/saudivisit.net',
    ],
]);

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', ROOT_PATH . '/storage/logs/php-error.log');
}

date_default_timezone_set('Asia/Riyadh');

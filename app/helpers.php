<?php
/** General helpers: escaping, URLs, rendering, redirects, slugs. */

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Build a locale-aware path, e.g. url('en', 'destinations/riyadh') → /saudivisit/en/destinations/riyadh/ */
function url(string $locale, string $route = ''): string
{
    $route = trim($route, '/');
    return BASE_PATH . '/' . $locale . '/' . ($route !== '' ? $route . '/' : '');
}

/** Absolute canonical URL for the current request path. */
function absolute_url(string $path): string
{
    return SITE_URL . $path;
}

function redirect(string $to, int $status = 302): never
{
    // Single-hop, same-site guard
    if (str_starts_with($to, '/')) {
        $to = $to;
    }
    header('Location: ' . $to, true, $status);
    exit;
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text) ?? '';
    return trim($text, '-') ?: 'item';
}

/** Render a view inside the layout and exit. */
function render_page(string $view, array $params = [], string $locale = DEFAULT_LOCALE): never
{
    $params['locale'] = $locale;
    $params['view'] = $view;
    extract($params, EXTR_SKIP);

    $viewFile = __DIR__ . '/../templates/' . basename($view) . '.php';
    if (!is_file($viewFile)) {
        http_response_code(500);
        echo 'Missing template: ' . e($view);
        exit;
    }
    require __DIR__ . '/../templates/layout.php';
    exit;
}

/** Format a UTC datetime for display, e.g. "24 September 2026". */
function fmt_date(?string $datetime): string
{
    if (!$datetime) {
        return '';
    }
    return (new DateTimeImmutable($datetime, new DateTimeZone('UTC')))->format('j F Y');
}

/** CSRF token helpers (session-based). */
function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        function_exists('auth_start') ? auth_start() : session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_verify(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        function_exists('auth_start') ? auth_start() : session_start();
    }
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Invalid CSRF token. Go back and retry.');
    }
}

/** Minimal HTML allowlist sanitizer for article bodies (defense-in-depth; write clean HTML in CMS). */
function sanitize_html(string $html): string
{
    $allowed = '<h2><h3><h4><p><ul><ol><li><strong><em><a><blockquote><table><thead><tbody><tr><th><td><figure><figcaption><img><br><hr>';
    $clean = strip_tags($html, $allowed);
    // Strip dangerous attributes (onclick, style, javascript: hrefs)
    $clean = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $clean) ?? $clean;
    $clean = preg_replace("/\\son\\w+\\s*=\\s*'[^']*'/i", '', $clean) ?? $clean;
    $clean = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1=$2#$2', $clean) ?? $clean;
    return $clean;
}

function audit(?int $actorId, string $action, string $entity, ?int $entityId, array $meta = []): void
{
    q('INSERT INTO audit_logs (actor_id, action, entity, entity_id, meta) VALUES (?,?,?,?,?)',
      [$actorId, $action, $entity, $entityId, $meta ? json_encode($meta) : null]);
}

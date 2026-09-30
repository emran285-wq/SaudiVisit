<?php
/**
 * SaudiVisit.net — public front controller
 * Routes: /{locale}/... per PRD section 4. Root / redirects to /en/.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$requestMethod = strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET'));
$relativePath = substr($uri, strlen(BASE_PATH));
$legacyPath = trim($relativePath, '/');

if (in_array($requestMethod, ['GET', 'HEAD'], true)) {
    $preserveQuery = static function (array $consumed = []): string {
        $queryString = (string)($_SERVER['QUERY_STRING'] ?? '');
        if ($queryString === '') {
            return '';
        }

        $pairs = [];
        foreach (explode('&', $queryString) as $pair) {
            $name = urldecode(explode('=', $pair, 2)[0]);
            if (!in_array($name, $consumed, true)) {
                $pairs[] = $pair;
            }
        }
        return $pairs === [] ? '' : '?' . implode('&', $pairs);
    };

    if (in_array($legacyPath, ['sitemap.php', 'sitemap.xml.php'], true)) {
        redirect(BASE_PATH . '/sitemap.xml' . $preserveQuery(), 301);
    }
    if ($legacyPath === 'robots.php') {
        redirect(BASE_PATH . '/robots.txt' . $preserveQuery(), 301);
    }

    $legacyPages = [
        'about.php' => 'pages/about',
        'contact.php' => 'pages/contact',
        'privacy.php' => 'pages/privacy',
        'destinations.php' => 'destinations',
    ];
    if (isset($legacyPages[$legacyPath])) {
        redirect(url(DEFAULT_LOCALE, $legacyPages[$legacyPath]) . $preserveQuery(), 301);
    }

    if ($legacyPath === 'articles.php') {
        $category = $_GET['category'] ?? '';
        if (!is_string($category) || trim($category) === '') {
            redirect(url(DEFAULT_LOCALE, 'guides') . $preserveQuery(), 301);
        }
        $categorySlug = slugify($category);
        if ($categorySlug === 'destinations') {
            redirect(url(DEFAULT_LOCALE, 'destinations') . $preserveQuery(['category']), 301);
        }
        $categorySlug = $categorySlug === 'culture' ? 'food-culture' : $categorySlug;
        $topic = get_topic(DEFAULT_LOCALE, $categorySlug);
        if ($topic) {
            redirect(url(DEFAULT_LOCALE, 'topics/' . $topic['slug']) . $preserveQuery(['category']), 301);
        }
    }

    if ($legacyPath === 'article.php') {
        $legacySlug = $_GET['slug'] ?? '';
        if (is_string($legacySlug) && preg_match('/^[a-z0-9-]+$/', $legacySlug)) {
            $article = get_article(DEFAULT_LOCALE, $legacySlug);
            if ($article) {
                redirect(url(DEFAULT_LOCALE, 'guides/' . $article['slug']) . $preserveQuery(['slug']), 301);
            }
            $target = redirect_lookup(DEFAULT_LOCALE, 'guides/' . $legacySlug);
            if ($target !== null) {
                redirect($target['new_path'] . $preserveQuery(['slug']), (int)$target['http_status']);
            }
        }
    }

    if ($legacyPath === 'destination.php') {
        $legacySlug = $_GET['slug'] ?? '';
        if (is_string($legacySlug) && preg_match('/^[a-z0-9-]+$/', $legacySlug)) {
            $destination = get_destination(DEFAULT_LOCALE, $legacySlug);
            if ($destination) {
                redirect(url(DEFAULT_LOCALE, 'destinations/' . $destination['slug']) . $preserveQuery(['slug']), 301);
            }
        }
    }
}

$path = '/' . trim(substr($uri, strlen(BASE_PATH)), '/');
if ($path !== '/' && str_ends_with($path, '/')) {
    $path = rtrim($path, '/');
}

// Root → default locale (301)
if ($path === '/' || $path === '') {
    redirect(BASE_PATH . '/' . DEFAULT_LOCALE . '/', 301);
}

// Match locale prefix
$segments = array_values(array_filter(explode('/', $path)));
$locale = $segments[0] ?? '';
if (!in_array($locale, SUPPORTED_LOCALES, true)) {
    // Unknown/missing locale → 404 (no forced IP redirects per PRD)
    http_response_code(404);
    render_page('404', ['title' => 'Page not found']);
    exit;
}

$route = implode('/', array_slice($segments, 1));
$params = [];

switch (true) {
    case $route === '':
        $view = 'home';
        break;

    case $route === 'destinations':
        $view = 'destinations';
        $params['q'] = trim((string)($_GET['q'] ?? ''));
        break;

    case $route === 'guides':
        $view = 'guides';
        $params['page'] = max(1, (int)($_GET['page'] ?? 1));
        break;

    case preg_match('#^destinations/([a-z0-9-]+)$#', $route, $m) === 1:
        $view = 'hub';
        $params['slug'] = $m[1];
        $params['page'] = max(1, (int)($_GET['page'] ?? 1));
        break;

    case preg_match('#^topics/([a-z0-9-]+)$#', $route, $m) === 1:
        $view = 'topic';
        $params['slug'] = $m[1];
        $params['page'] = max(1, (int)($_GET['page'] ?? 1));
        break;

    case preg_match('#^guides/([a-z0-9-]+)$#', $route, $m) === 1:
        $view = 'article';
        $params['slug'] = $m[1];
        $target = redirect_lookup($locale, $route);
        if ($target !== null) {
            $query = (string)($_SERVER['QUERY_STRING'] ?? '');
            redirect($target['new_path'] . ($query !== '' ? '?' . $query : ''), (int)$target['http_status']);
        }
        break;

    case preg_match('#^authors/([a-z0-9-]+)$#', $route, $m) === 1:
        $view = 'author';
        $params['slug'] = $m[1];
        break;

    case $route === 'search':
        $view = 'search';
        $params['q'] = trim((string)($_GET['q'] ?? ''));
        $params['page'] = max(1, (int)($_GET['page'] ?? 1));
        break;

    case preg_match('#^pages/([a-z0-9-]+)$#', $route, $m) === 1:
        $view = 'page'; // trust pages: about, editorial-policy, corrections, contact, privacy, terms, disclosure
        $params['slug'] = $m[1];
        break;

    default:
        // Check redirect table before 404
        $target = null;
        try {
            $target = redirect_lookup($locale, $route);
        } catch (Throwable $error) {
            error_log('Could not check the redirect table for an unknown route (' . get_class($error) . ').');
        }
        if ($target !== null) {
            redirect($target['new_path'], (int)$target['http_status']);
        }
        http_response_code(404);
        $view = '404';
        $params['title'] = 'Page not found';
}

if ($view !== '404' && in_array($requestMethod, ['GET', 'HEAD'], true)) {
    $canonicalPath = url($locale, $route);
    if ($uri !== $canonicalPath) {
        $query = (string)($_SERVER['QUERY_STRING'] ?? '');
        redirect($canonicalPath . ($query !== '' ? '?' . $query : ''), 301);
    }
}

render_page($view, $params, $locale);

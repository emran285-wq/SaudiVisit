<?php
/** SEO helpers: canonical, meta, JSON-LD structured data. */

declare(strict_types=1);

/** Emit canonical + robots meta. Search/preview pages pass noindex. */
function seo_meta(string $canonicalPath, bool $noindex = false): string
{
    $out = '<link rel="canonical" href="' . e(absolute_url($canonicalPath)) . '">' . "\n";
    if ($noindex) {
        $out .= '    <meta name="robots" content="noindex, follow">' . "\n";
    }
    return $out;
}

/** BlogPosting JSON-LD for article pages (matches visible content). */
function jsonld_article(array $article, string $locale): string
{
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article['title'],
        'description' => $article['meta_description'] ?? $article['excerpt'] ?? '',
        'inLanguage' => $locale,
        'datePublished' => $article['published_at'] ? date(DATE_ATOM, strtotime($article['published_at'])) : null,
        'dateModified' => $article['substantive_updated_at']
            ? date(DATE_ATOM, strtotime($article['substantive_updated_at']))
            : ($article['published_at'] ? date(DATE_ATOM, strtotime($article['published_at'])) : null),
        'author' => [
            '@type' => 'Person',
            'name' => $article['author_name'] ?? SITE_NAME,
            'url' => !empty($article['author_slug']) ? absolute_url(url($locale, 'authors/' . $article['author_slug'])) : null,
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => SITE_NAME,
            'url' => SITE_URL . BASE_PATH . '/',
        ],
        'mainEntityOfPage' => absolute_url(url($locale, 'guides/' . $article['slug'])),
    ];
    return '<script type="application/ld+json">' . json_encode(array_filter($data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** BreadcrumbList JSON-LD. */
function jsonld_breadcrumbs(array $items): string
{
    $list = [];
    foreach ($items as $i => $item) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => absolute_url($item['path']),
        ];
    }
    return '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** Open Graph / Twitter tags. */
function social_meta(string $title, string $description, string $canonicalPath): string
{
    $abs = absolute_url($canonicalPath);
    return implode("\n    ", [
        '<meta property="og:type" content="article">',
        '<meta property="og:site_name" content="' . e(SITE_NAME) . '">',
        '<meta property="og:title" content="' . e($title) . '">',
        '<meta property="og:description" content="' . e($description) . '">',
        '<meta property="og:url" content="' . e($abs) . '">',
        '<meta name="twitter:card" content="summary_large_image">',
    ]) . "\n";
}

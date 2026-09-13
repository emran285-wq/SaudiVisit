<?php
/**
 * SaudiVisit.net SEO & Utility Functions
 * Reusable functions for SEO optimization, structured data, and site helpers
 */

/**
 * Safely escape HTML
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate canonical URL
 */
function canonical(string $path = ''): string
{
    $url = SITE_URL;
    if ($path) {
        $url .= '/' . ltrim($path, '/');
    }
    return $url;
}

/** Generate a local URL using the configured document-root path. */
function site_url(string $path = ''): string
{
    $url = BASE_URL;
    return $path === '' ? $url : $url . '/' . ltrim($path, '/');
}

/** Generate a URL for a public asset. */
function asset_url(string $path): string
{
    return BASE_PATH . '/' . ltrim($path, '/');
}

/**
 * Generate breadcrumb JSON-LD schema
 */
function breadcrumbSchema(array $breadcrumbs): string
{
    $items = [];
    foreach ($breadcrumbs as $index => $crumb) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $crumb['name'],
            'item' => canonical($crumb['url'] ?? ''),
        ];
    }
    
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Generate article schema
 */
function articleSchema(array $article): string
{
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article['title'] ?? '',
        'description' => $article['excerpt'] ?? '',
        'author' => [
            '@type' => 'Organization',
            'name' => 'SaudiVisit.net',
        ],
        'datePublished' => $article['published_date'] ?? date('Y-m-d'),
        'dateModified' => $article['updated_date'] ?? date('Y-m-d'),
        'image' => $article['featured_image'] ?? canonical('/assets/images/default-article.jpg'),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Generate destination/tourist attraction schema
 */
function attractionSchema(array $attraction): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'TouristAttraction',
        'name' => $attraction['name'] ?? '',
        'description' => $attraction['description'] ?? '',
        'url' => $attraction['url'] ?? '',
    ];
    
    if (!empty($attraction['image'])) {
        $schema['image'] = $attraction['image'];
    }
    
    if (!empty($attraction['address'])) {
        $schema['address'] = [
            '@type' => 'PostalAddress',
            'streetAddress' => $attraction['address'],
            'addressCountry' => 'SA',
        ];
    }
    
    if (!empty($attraction['coordinates'])) {
        $schema['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => $attraction['coordinates']['lat'] ?? '',
            'longitude' => $attraction['coordinates']['lng'] ?? '',
        ];
    }
    
    return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Generate FAQ schema
 */
function faqSchema(array $faqs): string
{
    $mainEntity = [];
    foreach ($faqs as $faq) {
        $mainEntity[] = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ];
    }
    
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $mainEntity,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Open Graph meta tags
 */
function ogMeta(array $data): string
{
    $defaults = [
        'title' => DEFAULT_TITLE,
        'description' => DEFAULT_DESCRIPTION,
        'type' => 'website',
        'image' => canonical('/assets/images/og-default.jpg'),
    ];
    
    $data = array_merge($defaults, $data);
    $output = '';
    
    foreach ($data as $key => $value) {
        if ($value) {
            $output .= sprintf('    <meta property="og:%s" content="%s">' . "\n", e($key), e((string)$value));
        }
    }
    
    return $output;
}

/**
 * Twitter card meta tags
 */
function twitterMeta(array $data): string
{
    $defaults = [
        'card' => 'summary_large_image',
        'title' => DEFAULT_TITLE,
        'description' => DEFAULT_DESCRIPTION,
        'image' => canonical('/assets/images/og-default.jpg'),
    ];
    
    $data = array_merge($defaults, $data);
    $output = '';
    
    foreach ($data as $key => $value) {
        if ($value) {
            $output .= sprintf('    <meta name="twitter:%s" content="%s">' . "\n", e($key), e((string)$value));
        }
    }
    
    return $output;
}

/**
 * Find article by slug
 */
function findArticle(string $slug, array $articles): ?array
{
    foreach ($articles as $article) {
        if ($article['slug'] === $slug) {
            return $article;
        }
    }
    return null;
}

/**
 * Find destination by slug
 */
function findDestination(string $slug, array $destinations): ?array
{
    return $destinations[$slug] ?? null;
}

/**
 * Format reading time
 */
function readingTime(int $words): string
{
    $minutes = ceil($words / 200);
    return $minutes === 1 ? '1 min read' : $minutes . ' min read';
}

/**
 * Generate breadcrumb HTML
 */
function breadcrumbHtml(array $breadcrumbs): string
{
    $html = '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    $html .= '<ol>';
    
    foreach ($breadcrumbs as $index => $crumb) {
        if (isset($crumb['url'])) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                e($crumb['url']),
                e($crumb['name'])
            );
        } else {
            $html .= sprintf('<li aria-current="page">%s</li>', e($crumb['name']));
        }
    }
    
    $html .= '</ol></nav>';
    return $html;
}

/**
 * Generate schema.org WebSite schema
 */
function websiteSchema(): string
{
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => SITE_NAME,
        'url' => SITE_URL,
        'description' => SITE_DESCRIPTION,
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => SITE_URL . '/destinations.php?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Check if current page is active
 */
function isActive(string $page): string
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page ? 'active' : '';
}

/**
 * Get article categories
 */
function getArticleCategories(array $articles): array
{
    return array_values(array_unique(array_column($articles, 'category')));
}

/**
 * Filter articles by category
 */
function filterArticlesByCategory(array $articles, string $category): array
{
    if ($category === '') {
        return $articles;
    }
    return array_values(array_filter($articles, static fn($a) => $a['category'] === $category));
}

/**
 * Search articles
 */
function searchArticles(array $articles, string $query): array
{
    $q = strtolower($query);
    return array_filter($articles, static function ($article) use ($q) {
        $haystack = strtolower(
            ($article['title'] ?? '') . ' ' .
            ($article['excerpt'] ?? '') . ' ' .
            ($article['slug'] ?? '')
        );
        return str_contains($haystack, $q);
    });
}

/**
 * Get featured articles
 */
function getFeaturedArticles(array $articles, int $limit = 3): array
{
    $featured = array_filter($articles, static fn($a) => $a['featured'] ?? false);
    return array_slice($featured, 0, $limit, true);
}

/**
 * Format date for display
 */
function formatDate(string $date): string
{
    return date('F j, Y', strtotime($date));
}

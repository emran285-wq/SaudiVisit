<?php
/**
 * IMPLEMENTATION PATTERNS
 * 
 * These patterns show exactly how to update the remaining page files
 * to use the new BASE_PATH, config, and function infrastructure.
 * Copy/paste and adapt for each file.
 */
?>

<!-- ============================================
     PATTERN 1: Main Listing Pages
     (articles.php, destinations.php, attractions.php)
     ============================================ -->

<?php
/*
BEFORE:
```php
<?php
$page_title = "Articles";
?>
<link rel="stylesheet" href="assets/css/style.css">
<nav>
  <a href="index.php">Home</a>
  <a href="articles.php?category=travel-planning">Travel Planning</a>
</nav>
<img src="assets/images/article-banner.svg" alt="...">
<a href="article.php?slug=<?= $article['slug'] ?>">Read More</a>
```

AFTER:
```php
<?php
require __DIR__ . '/data/site-data.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Travel Guides & Articles';
$metaDescription = 'Comprehensive travel guides for Saudi Arabia covering planning, destinations, culture, and more.';
$ogData = [
    'title' => $pageTitle,
    'description' => $metaDescription,
    'type' => 'website',
];

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <!-- IMPORTANT: Use BASE_PATH for all links! -->
        <a href="<?= BASE_PATH ?>/index.php">Home</a>
        
        <!-- IMPORTANT: Use BASE_PATH for all images! -->
        <img src="<?= BASE_PATH ?>/assets/images/article-banner.svg" alt="Banner" loading="lazy">
        
        <!-- IMPORTANT: Use BASE_PATH for query parameters! -->
        <a href="<?= BASE_PATH ?>/article.php?slug=<?= urlencode($article['slug']) ?>">
            Read More
        </a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
```
*/
?>

<!-- ============================================
     PATTERN 2: Dynamic Detail Pages
     (destination.php, article.php)
     ============================================ -->

<?php
/*
EXAMPLE: destination.php

```php
<?php
require __DIR__ . '/data/site-data.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Get destination slug from URL
$slug = $_GET['slug'] ?? '';
$destination = $destinations[$slug] ?? null;

// If destination not found, show 404
if (!$destination) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

// Set page metadata
$pageTitle = $destination['name'] . ' Travel Guide';
$metaDescription = substr($destination['summary'], 0, 155) . '...';
$ogData = [
    'title' => $pageTitle,
    'description' => $metaDescription,
    'image' => BASE_PATH . '/' . $destination['image'],
];

// Create breadcrumbs
$breadcrumbs = [
    ['name' => 'Home', 'url' => BASE_PATH . '/index.php'],
    ['name' => 'Destinations', 'url' => BASE_PATH . '/destinations.php'],
    ['name' => $destination['name']],
];

// Create schema
$schema = attractionSchema([
    'name' => $destination['name'],
    'description' => $destination['summary'],
    'url' => canonical('/destination/' . $slug),
    'image' => CANONICAL_DOMAIN . '/' . $destination['image'],
]);

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <!-- Use breadcrumbHtml() function for navigation -->
        <?= breadcrumbHtml($breadcrumbs) ?>
        
        <h1><?= e($destination['name']) ?></h1>
        <p><?= e($destination['tagline']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Content goes here -->
        <?= e($destination['description']) ?>
    </div>
</section>

<!-- Add schema to page -->
<script type="application/ld+json">
<?= $schema ?>
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
```
*/
?>

<!-- ============================================
     PATTERN 3: Form Pages
     (contact.php - already done, shown for reference)
     ============================================ -->

<?php
/*
Forms that submit to themselves:

```php
<?php
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email.';
    } elseif (strlen($message) < 10) {
        $error = 'Message must be at least 10 characters.';
    } else {
        // In production, send email or save to database
        $successMessage = 'Thank you! We\'ll be in touch soon.';
        
        // Clear form
        $email = $name = $message = '';
    }
}
?>

<?php if ($successMessage): ?>
    <div class="alert alert-success">
        <?= e($successMessage) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= BASE_PATH ?>/contact.php">
    <input type="text" name="name" required>
    <input type="email" name="email" required>
    <textarea name="message" required></textarea>
    <button type="submit">Send</button>
</form>
```
*/
?>

<!-- ============================================
     PATTERN 4: Content Arrays (site-data.php)
     ============================================ -->

<?php
/*
All data is stored in /data/site-data.php as associative arrays:

Array Structure:
- $destinations['slug'] = ['name', 'tagline', 'summary', 'description', ...]
- $articles[] = ['slug', 'title', 'category', 'excerpt', 'content', ...]
- $attractions[] = ['name', 'destination', 'category', 'price', ...]

Access Examples:
```php
// Access destination by slug
$destination = $destinations['riyadh'];
echo $destination['name'];  // "Riyadh"

// Loop through all articles
foreach ($articles as $article) {
    echo $article['title'];
    echo $article['excerpt'];
}

// Filter attractions by destination
$riyadh_attractions = array_filter(
    $attractions,
    fn($a) => $a['destination'] === 'riyadh'
);

// Search/filter using helper functions from functions.php
$featured = getFeaturedArticles($articles, 5);
$results = searchArticles($articles, 'visa');
$category = filterArticlesByCategory($articles, 'Travel Planning');
```
*/
?>

<!-- ============================================
     KEY FUNCTIONS REFERENCE
     (All in /includes/functions.php)
     ============================================ -->

<?php
/*
Security & HTML:
  e($value) - HTML escape with htmlspecialchars()

URLs & Canonical:
  canonical($path) - Generate production domain URL
  
Schema.org JSON-LD Generators:
  breadcrumbSchema($breadcrumbs) - Navigation breadcrumbs
  articleSchema($article) - Article metadata
  attractionSchema($attraction) - Place/attraction metadata
  faqSchema($faqs) - FAQ page schema
  websiteSchema() - Site-wide schema
  
Meta Tags:
  ogMeta($data) - Open Graph tags (social sharing)
  twitterMeta($data) - Twitter Card tags
  
HTML Helpers:
  breadcrumbHtml($breadcrumbs) - Renders <nav><ol> breadcrumbs
  
Search & Filter:
  filterArticlesByCategory($articles, $category)
  searchArticles($articles, $query)
  getFeaturedArticles($articles, $limit)
  findArticle($slug, $articles)
*/
?>

<!-- ============================================
     CONSTANTS & CONFIGURATION
     (All in /includes/config.php)
     ============================================ -->

<?php
/*
Available Constants:

BASE_PATH         = '/saudivisit' (subfolder path for localhost)
BASE_URL          = 'http://localhost/saudivisit' (full localhost URL)
CANONICAL_DOMAIN  = 'https://saudivisit.net' (production domain)
SITE_NAME         = 'SaudiVisit.net'
DEFAULT_TITLE     = 'SaudiVisit.net – Saudi Arabia Travel Guide 2026'
DEFAULT_DESCRIPTION = 'Plan your Saudi Arabia adventure...'
ORGANIZATION_JSON = Full schema.org Organization structure

Usage:
- Always use BASE_PATH . '/path/to/page.php' for links
- Use BASE_PATH . '/assets/images/file.svg' for images
- Use CANONICAL_DOMAIN for sitemaps and production URLs
- Use SITE_NAME for footer/header branding
*/
?>

<!-- ============================================
     COMMON TASKS
     ============================================ -->

<?php
/*
Task 1: Create New Article Listing Page

In articles.php:
```php
<?php
require __DIR__ . '/data/site-data.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$category = $_GET['category'] ?? '';
$query = $_GET['q'] ?? '';

// Filter articles
$filtered = $articles;
if ($category) {
    $filtered = filterArticlesByCategory($filtered, $category);
}
if ($query) {
    $filtered = searchArticles($filtered, $query);
}

$pageTitle = 'Travel Guides & Articles';
$metaDescription = 'Browse our collection of travel guides...';

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="article-grid">
            <?php foreach ($filtered as $article): ?>
            <div class="article-card">
                <h3><?= e($article['title']) ?></h3>
                <p><?= e($article['excerpt']) ?></p>
                <div class="article-meta">
                    <span><?= e($article['read_time']) ?></span>
                    <a href="<?= BASE_PATH ?>/article.php?slug=<?= urlencode($article['slug']) ?>">
                        Read More
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
```

Task 2: Show 404 Page

```php
<?php
http_response_code(404);
include __DIR__ . '/404.php';
exit;
```

Task 3: Add Breadcrumb Navigation

```php
<?php
$breadcrumbs = [
    ['name' => 'Home', 'url' => BASE_PATH . '/index.php'],
    ['name' => 'Current Page Name'], // No URL = current page
];

require __DIR__ . '/includes/header.php';
?>

<!-- In your page HTML: -->
<?= breadcrumbHtml($breadcrumbs) ?>
```

Task 4: Add Open Graph Tags

```php
<?php
$ogData = [
    'title' => 'Page Title',
    'description' => 'Page description for social media',
    'image' => BASE_PATH . '/assets/images/og-image.jpg',
    'url' => canonical('/current-page'),
];

// Pass $ogData to header.php (it uses it automatically)
require __DIR__ . '/includes/header.php';
```

Task 5: Add JSON-LD Schema

```php
<?php
$schema = articleSchema([
    'headline' => 'Article Title',
    'description' => 'Article summary',
    'image' => CANONICAL_DOMAIN . '/assets/images/article-image.jpg',
    'datePublished' => '2026-01-15',
    'dateModified' => '2026-09-13',
    'author' => 'SaudiVisit.net',
]);
?>

<!-- In page HTML, before closing </body>: -->
<script type="application/ld+json">
<?= $schema ?>
</script>
```
*/
?>

<!-- ============================================
     TESTING CHECKLIST FOR EACH PAGE
     ============================================ -->

After updating each page:

1. ☐ HTTP 200 response (curl http://localhost:8000/page.php -I)
2. ☐ No PHP errors (check browser console)
3. ☐ Images load (view page in browser)
4. ☐ Links work (click several links, no 404s)
5. ☐ Mobile responsive (resize browser to 375px width)
6. ☐ BASE_PATH works (all paths have <?= BASE_PATH ?>)
7. ☐ Meta tags present (view page source, check <meta>, <link rel="canonical">)
8. ☐ Schema.org valid (check with Google's Structured Data Tool)

<!-- ============================================
     QUICK REFERENCE: FIND & REPLACE
     ============================================ -->

When updating old pages, search for and replace:

OLD CODE                              → NEW CODE
─────────────────────────────────────────────────────────────────
assets/images/                        → <?= BASE_PATH ?>/assets/images/
href="index.php"                      → href="<?= BASE_PATH ?>/index.php"
href="destination.php?slug=           → href="<?= BASE_PATH ?>/destination.php?slug=
href="article.php?slug=               → href="<?= BASE_PATH ?>/article.php?slug=
src="assets/css/style.css"           → (keep as is, loaded via header.php)
$page_title =                         → $pageTitle = (and set before header include)
require 'includes/header.php'         → require __DIR__ . '/includes/header.php'

<!-- ============================================
     FILE DEPENDENCIES DIAGRAM
     ============================================ -->

All Page Files (index.php, about.php, etc.)
    ↓ require
    ├── /data/site-data.php (content arrays)
    ├── /includes/config.php (constants & paths)
    ├── /includes/functions.php (utilities)
    └── /includes/header.php
            ├── uses config.php
            ├── uses functions.php
            └── outputs HTML5 head
    
    And at bottom:
    └── /includes/footer.php (closes HTML)

<!-- ============================================
     PRIORITY ORDER FOR UPDATES
     ============================================ -->

1. index.php          - Homepage (highest traffic)
2. destination.php    - Destination detail (critical for SEO)
3. article.php        - Article detail (critical for SEO)
4. articles.php       - Article listing
5. destinations.php   - Destination listing
6. attractions.php    - Attractions browser
7. planner.php        - Trip planner (bonus features)

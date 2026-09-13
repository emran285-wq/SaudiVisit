<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/data/site-data.php';

$slug = (string) ($_GET['slug'] ?? 'saudi-arabia-travel-guide-2026');
$article = findArticle($slug, $articles);

if (!$article) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$pageTitle = $article['seo_title'] ?? $article['title'] . ' | SaudiVisit.net';
$metaDescription = $article['meta_description'] ?? $article['excerpt'];
$canonical = canonical('/article.php?slug=' . rawurlencode($article['slug']));
$ogData = [
    'title' => $pageTitle,
    'description' => $metaDescription,
    'type' => 'article',
    'url' => $canonical,
    'image' => canonical('/' . ltrim($article['featured_image'] ?? 'assets/images/riyadh.svg', '/')),
];
$breadcrumbs = [
    ['name' => 'Home', 'url' => BASE_PATH . '/index.php'],
    ['name' => 'Travel Guides', 'url' => BASE_PATH . '/articles.php'],
    ['name' => $article['title']],
];
$articleSchema = articleSchema([
    'title' => $article['title'],
    'excerpt' => $metaDescription,
    'published_date' => $article['published_date'],
    'updated_date' => $article['updated_date'],
    'featured_image' => $ogData['image'],
]);
$faqSchema = !empty($article['faq']) ? faqSchema($article['faq']) : '';
$relatedArticles = [];
foreach (($article['related_articles'] ?? []) as $relatedSlug) {
    $related = findArticle($relatedSlug, $articles);
    if ($related) {
        $relatedArticles[] = $related;
    }
}

require __DIR__ . '/includes/header.php';
?>
<section class="article-hero">
    <div class="container narrow">
        <span class="pill"><?= e($article['category']) ?></span>
        <h1><?= e($article['title']) ?></h1>
        <p><?= e($article['intro'] ?? $article['excerpt']) ?></p>
        <div class="article-byline">
            <span>By <?= e($article['author'] ?? 'SaudiVisit Editorial Team') ?></span>
            <span>Published <?= e(formatDate($article['published_date'])) ?></span>
            <span>Updated <?= e(formatDate($article['updated_date'])) ?></span>
            <span><?= e($article['read_time']) ?></span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container content-layout article-layout">
        <article class="prose article-prose">
            <figure class="article-featured-image">
                <img src="<?= BASE_PATH ?>/<?= e($article['featured_image'] ?? 'assets/images/riyadh.svg') ?>" alt="<?= e($article['title']) ?>" loading="eager">
            </figure>

            <?php if (!empty($article['sections'])): ?>
                <nav class="article-toc" aria-label="Table of contents">
                    <h2>In this guide</h2>
                    <ol>
                        <?php foreach ($article['sections'] as $sectionIndex => $section): ?>
                            <?php $sectionId = 'section-' . ($sectionIndex + 1); ?>
                            <li><a href="#<?= e($sectionId) ?>"><?= e($section['heading']) ?></a></li>
                        <?php endforeach; ?>
                        <?php if (!empty($article['faq'])): ?><li><a href="#frequently-asked-questions">Frequently asked questions</a></li><?php endif; ?>
                    </ol>
                </nav>
            <?php endif; ?>

            <?php foreach (($article['sections'] ?? []) as $sectionIndex => $section): ?>
                <?php $sectionId = 'section-' . ($sectionIndex + 1); ?>
                <section id="<?= e($sectionId) ?>">
                    <h2><?= e($section['heading']) ?></h2>
                    <?php foreach ($section['paragraphs'] as $paragraph): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endforeach; ?>
                    <?php if (!empty($section['bullets'])): ?>
                        <ul>
                            <?php foreach ($section['bullets'] as $bullet): ?><li><?= e($bullet) ?></li><?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>

            <?php if (!empty($article['faq'])): ?>
                <section id="frequently-asked-questions">
                    <h2>Frequently asked questions</h2>
                    <?php foreach ($article['faq'] as $faq): ?>
                        <h3><?= e($faq['question']) ?></h3>
                        <p><?= e($faq['answer']) ?></p>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <div class="callout">
                <strong>Planning note:</strong> Visa rules, opening hours, ticketing, prices, transport schedules and access requirements can change. Confirm time-sensitive details through official sources before travel.
            </div>
            <p class="editorial-note">Reviewed for structure and travel-planning usefulness on <?= e(formatDate($article['updated_date'])) ?>. See our <a href="<?= BASE_PATH ?>/about.php">editorial standards</a> for how we handle changing information.</p>
        </article>

        <aside class="sidebar-card sticky-card">
            <h3>Keep planning</h3>
            <a class="sidebar-link" href="<?= BASE_PATH ?>/destinations.php">Explore destinations <span>→</span></a>
            <a class="sidebar-link" href="<?= BASE_PATH ?>/attractions.php">Browse attractions <span>→</span></a>
            <a class="sidebar-link" href="<?= BASE_PATH ?>/planner.php">Build an itinerary <span>→</span></a>
            <a class="sidebar-link" href="<?= BASE_PATH ?>/contact.php">Send a correction <span>→</span></a>
        </aside>
    </div>
</section>

<?php if ($relatedArticles): ?>
    <section class="section section-tinted related-articles">
        <div class="container">
            <div class="section-head"><div><span class="eyebrow">Continue planning</span><h2>Related Saudi Arabia guides</h2></div></div>
            <div class="article-grid article-grid-2">
                <?php foreach ($relatedArticles as $related): ?>
                    <article class="article-card">
                        <span class="pill pill-light"><?= e($related['category']) ?></span>
                        <h3><?= e($related['title']) ?></h3>
                        <p><?= e($related['excerpt']) ?></p>
                        <div class="article-meta"><span><?= e($related['read_time']) ?></span><a href="<?= BASE_PATH ?>/article.php?slug=<?= e($related['slug']) ?>">Read guide →</a></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script type="application/ld+json"><?= $articleSchema ?></script>
<?php if ($faqSchema): ?><script type="application/ld+json"><?= $faqSchema ?></script><?php endif; ?>
<script type="application/ld+json"><?= breadcrumbSchema($breadcrumbs) ?></script>
<?php require __DIR__ . '/includes/footer.php'; ?>

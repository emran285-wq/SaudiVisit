<?php
require __DIR__ . '/data/site-data.php';
$pageTitle = 'Saudi Arabia Travel Guides & Articles | SaudiVisit.net';
$metaDescription = 'Browse Saudi Arabia travel planning guides, destination articles, itineraries and cultural stories.';
$category = trim((string)($_GET['category'] ?? ''));
$categories = array_values(array_unique(array_column($articles, 'category')));
$filtered = $category === '' ? $articles : array_values(array_filter($articles, static fn($a) => $a['category'] === $category));
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact-hero">
    <div class="container narrow"><span class="eyebrow eyebrow-light">Travel guides</span><h1>Plan with practical, search-friendly guides</h1><p>Starter content structure for destination pages, itineraries, travel planning and Saudi culture.</p></div>
</section>
<section class="section">
    <div class="container">
        <div class="chip-row">
            <a class="chip <?= $category === '' ? 'selected' : '' ?>" href="articles.php">All</a>
            <?php foreach ($categories as $item): ?><a class="chip <?= $category === $item ? 'selected' : '' ?>" href="articles.php?category=<?= urlencode($item) ?>"><?= e($item) ?></a><?php endforeach; ?>
        </div>
        <div class="article-grid article-grid-2">
            <?php foreach ($filtered as $article): ?>
                <article class="article-card large-article-card">
                    <span class="pill pill-light"><?= e($article['category']) ?></span>
                    <h2><a href="article.php?slug=<?= e($article['slug']) ?>"><?= e($article['title']) ?></a></h2>
                    <p><?= e($article['excerpt']) ?></p>
                    <div class="article-meta"><span><?= e($article['read_time']) ?></span><a href="article.php?slug=<?= e($article['slug']) ?>">Read guide →</a></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

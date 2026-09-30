<?php
$perPage = 10;
$total = count_published_articles($locale);
$totalPages = max(1, (int)ceil($total / $perPage));
if ($page > $totalPages) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Page not found</h1></div>';
    return;
}

$articles = get_articles_page($locale, $page, $perPage);
$title = 'Travel Guides — ' . SITE_NAME;
$metaDescription = 'Browse practical Saudi Arabia travel guides, destination advice and itineraries.';
$canonicalPath = url($locale, 'guides') . ($page > 1 ? '?page=' . $page : '');
?>
<div class="container page-narrow">
    <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?= url($locale) ?>">Home</a> / <span>Travel guides</span></nav>
    <h1>Travel Guides</h1>
    <?php if (!$articles): ?>
        <p>No published guides yet.</p>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($articles as $article): ?>
                <article class="card">
                    <h2><a href="<?= url($locale, 'guides/' . $article['slug']) ?>"><?= e($article['title']) ?></a></h2>
                    <p><?= e($article['excerpt'] ?? '') ?></p>
                    <p class="fine-print">Updated <?= e(fmt_date($article['substantive_updated_at'] ?? $article['published_at'])) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Pagination">
                <?php for ($currentPage = 1; $currentPage <= $totalPages; $currentPage++): ?>
                    <?php if ($currentPage === $page): ?>
                        <span aria-current="page"><?= $currentPage ?></span>
                    <?php else: ?>
                        <a href="<?= url($locale, 'guides') ?>?page=<?= $currentPage ?>"><?= $currentPage ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
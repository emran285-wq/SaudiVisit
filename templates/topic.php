<?php
/** Topic hub (Plan Your Trip, Itineraries, Transport, Food & Culture). */
$topic = get_topic($locale, $slug);
if (!$topic) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Topic not found</h1></div>';
    return;
}
$perPage = 10;
$articles = get_articles_by_topic((int)$topic['id'], $locale, $page, $perPage);

$title = $topic['title'] . ' — ' . SITE_NAME;
$metaDescription = mb_strimwidth((string)($topic['intro'] ?? ''), 0, 155, '…');
$canonicalPath = url($locale, 'topics/' . $topic['slug']) . ($page > 1 ? '?page=' . $page : '');
$noindex = !$topic['is_indexable'];
?>
<div class="container page-narrow">
    <h1><?= e($topic['title']) ?></h1>
    <p class="lede"><?= e($topic['intro'] ?? '') ?></p>
    <?php if (!$articles): ?>
        <p>Guides for this topic are in editorial review. Check back soon.</p>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($articles as $a): ?>
                <article class="card">
                    <h3><a href="<?= url($locale, 'guides/' . $a['slug']) ?>"><?= e($a['title']) ?></a></h3>
                    <p><?= e($a['excerpt'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

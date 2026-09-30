<?php
/** Author page — indexable only with meaningful bio + contributions. */
$author = get_author($slug);
if (!$author) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Author not found</h1></div>';
    return;
}
$articles = q(
    "SELECT al.* FROM article_localizations al
     JOIN articles a ON a.id = al.article_id
     WHERE a.primary_author_id = ? AND al.locale = ? AND al.state = 'published'
     ORDER BY al.published_at DESC",
    [(int)$author['id'], $locale]
)->fetchAll();

$title = $author['name'] . ' — ' . SITE_NAME;
$metaDescription = mb_strimwidth((string)($author['bio'] ?? ''), 0, 155, '…');
$canonicalPath = url($locale, 'authors/' . $author['slug']);
$noindex = !$articles && empty($author['bio']);
?>
<div class="container page-narrow">
    <h1><?= e($author['name']) ?></h1>
    <?php if ($author['bio']): ?><p class="lede"><?= e($author['bio']) ?></p><?php endif; ?>
    <?php if ($articles): ?>
        <h2>Guides by <?= e($author['name']) ?></h2>
        <ul class="search-results">
            <?php foreach ($articles as $a): ?>
                <li><a href="<?= url($locale, 'guides/' . $a['slug']) ?>"><?= e($a['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

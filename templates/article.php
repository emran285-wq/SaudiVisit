<?php
/** Article page — ordered layout per PRD 5: breadcrumb → H1 → summary → meta → TOC → body → sources → author → related. */
$article = get_article($locale, $slug);
if (!$article) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Guide not found</h1><p><a href="' . url($locale) . '">Back to homepage</a>.</p></div>';
    return;
}

$articleDests = get_article_destinations((int)$article['article_id'], $locale);
$sources = get_article_sources((int)$article['id']);
$related = get_related_articles((int)$article['article_id'], $locale, 3);

// Build TOC from h2 headings in the (sanitized) body
$toc = [];
if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', (string)$article['body'], $m)) {
    foreach ($m[1] as $i => $headingText) {
        $toc[] = ['id' => 'section-' . ($i + 1), 'text' => strip_tags($headingText)];
    }
    // Inject ids into the body
    $i = 0;
    $article['body'] = preg_replace_callback('/<h2([^>]*)>/is', function ($mm) use (&$i) {
        $i++;
        return '<h2 id="section-' . $i . '"' . $mm[1] . '>';
    }, (string)$article['body']);
}

$primaryDest = $articleDests[0] ?? null;
$title = $article['seo_title'] ?: $article['title'] . ' — ' . SITE_NAME;
$metaDescription = $article['meta_description'] ?: mb_strimwidth((string)$article['excerpt'], 0, 155, '…');
$canonicalPath = url($locale, 'guides/' . $article['slug']);

$crumbs = [['name' => 'Home', 'path' => url($locale)]];
if ($primaryDest) {
    $crumbs[] = ['name' => 'Destinations', 'path' => url($locale, 'destinations')];
    $crumbs[] = ['name' => $primaryDest['title'], 'path' => url($locale, 'destinations/' . $primaryDest['slug'])];
}
$crumbs[] = ['name' => $article['title'], 'path' => $canonicalPath];
$headExtra = jsonld_article($article, $locale) . "\n    " . jsonld_breadcrumbs($crumbs);
?>
<div class="container article-layout">
    <article class="article-body">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <?php foreach ($crumbs as $i => $c): ?>
                <?php if ($i > 0): ?> / <?php endif; ?>
                <?php if ($i < count($crumbs) - 1): ?>
                    <a href="<?= $c['path'] ?>"><?= e($c['name']) ?></a>
                <?php else: ?>
                    <span><?= e($c['name']) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <?php if ($primaryDest): ?>
            <p class="category-label"><a href="<?= url($locale, 'destinations/' . $primaryDest['slug']) ?>"><?= e($primaryDest['title']) ?></a></p>
        <?php endif; ?>

        <h1><?= e($article['title']) ?></h1>
        <p class="lede"><?= e($article['excerpt'] ?? '') ?></p>

        <p class="byline">
            <?php if ($article['author_name']): ?>
                By <a href="<?= url($locale, 'authors/' . $article['author_slug']) ?>"><?= e($article['author_name']) ?></a> ·
            <?php endif; ?>
            Published <?= e(fmt_date($article['published_at'])) ?>
            <?php if ($article['substantive_updated_at'] && $article['substantive_updated_at'] !== $article['published_at']): ?>
                · Updated <?= e(fmt_date($article['substantive_updated_at'])) ?>
            <?php endif; ?>
            <?php if ($article['reviewed_at']): ?>
                · Fact-checked <?= e(fmt_date($article['reviewed_at'])) ?>
            <?php endif; ?>
        </p>

        <?php if ($toc): ?>
            <details class="toc toc-mobile">
                <summary>On this page</summary>
                <ol>
                    <?php foreach ($toc as $t): ?>
                        <li><a href="#<?= e($t['id']) ?>"><?= e($t['text']) ?></a></li>
                    <?php endforeach; ?>
                </ol>
            </details>
        <?php endif; ?>

        <?= sanitize_html((string)$article['body']) ?>

        <?php if ($sources): ?>
            <section class="sources" aria-labelledby="sources-heading">
                <h2 id="sources-heading">Sources</h2>
                <ul>
                    <?php foreach ($sources as $s): ?>
                        <li>
                            <a href="<?= e($s['source_url']) ?>" rel="nofollow noopener" target="_blank"><?= e($s['publisher'] ?: $s['source_url']) ?></a>
                            <?php if ($s['claim_section']): ?> — <?= e($s['claim_section']) ?><?php endif; ?>
                            <?php if ($s['checked_at']): ?> <span class="fine-print">(checked <?= e(fmt_date($s['checked_at'])) ?>)</span><?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <p class="fine-print"><a href="<?= url($locale, 'pages/corrections') ?>">Suggest a correction</a></p>

        <?php if ($related): ?>
            <section aria-labelledby="related-heading">
                <h2 id="related-heading">Related guides</h2>
                <div class="card-grid">
                    <?php foreach ($related as $r): ?>
                        <article class="card">
                            <h3><a href="<?= url($locale, 'guides/' . $r['slug']) ?>"><?= e($r['title']) ?></a></h3>
                            <p><?= e($r['excerpt'] ?? '') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </article>

    <?php if ($toc): ?>
        <aside class="toc-sidebar">
            <nav class="toc" aria-label="Table of contents">
                <h2>On this page</h2>
                <ol>
                    <?php foreach ($toc as $t): ?>
                        <li><a href="#<?= e($t['id']) ?>"><?= e($t['text']) ?></a></li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </aside>
    <?php endif; ?>
</div>

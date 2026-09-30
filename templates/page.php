<?php
/** Trust/static page (About, Editorial Policy, Corrections, Contact, Privacy, Terms, Disclosure). */
$page = get_page($locale, $slug);
if (!$page) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Page not found</h1></div>';
    return;
}
$title = $page['title'] . ' — ' . SITE_NAME;
$metaDescription = mb_strimwidth(strip_tags((string)$page['body']), 0, 155, '…');
$canonicalPath = url($locale, 'pages/' . $page['slug']);
$noindex = !$page['is_indexable'];
?>
<div class="container page-narrow">
    <h1><?= e($page['title']) ?></h1>
    <?= sanitize_html((string)$page['body']) ?>
</div>

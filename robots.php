<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

header('Content-Type: text/plain; charset=utf-8');

$privatePaths = ['/admin/', '/app/', '/config/'];
echo "User-agent: *\n";
foreach ($privatePaths as $path) {
    echo 'Disallow: ' . BASE_PATH . $path . "\n";
}
echo "\nSitemap: " . SITE_URL . BASE_PATH . "/sitemap.xml\n";
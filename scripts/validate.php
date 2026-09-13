<?php
/** Lightweight repository validation for local and CI use. */

$root = dirname(__DIR__);
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$failed = false;

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php' || str_contains($file->getPathname(), DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)) {
        continue;
    }

    $command = escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($file->getPathname());
    exec($command, $output, $status);
    if ($status !== 0) {
        $failed = true;
        echo implode(PHP_EOL, $output) . PHP_EOL;
    }
}

exit($failed ? 1 : 0);

<?php
require_once('pclzip.lib.php');

$sourceDir = realpath('../'); // absolute path to the folder
$zipFile = 'voucher.zip';

$archive = new PclZip($zipFile);

// Get all files inside ../ recursively
$files = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $files[] = $file->getPathname();
    }
}

if (empty($files)) {
    die("❌ No files found in $sourceDir");
}

// Create zip archive
$list = $archive->create($files, PCLZIP_OPT_REMOVE_PATH, $sourceDir);

if ($list == 0) {
    die("❌ Error : " . $archive->errorInfo(true));
}

echo "✅ success saved to $zipFile";
?>

<?php
require_once 'pclzip.lib.php';

$zipFile = 'voucher.zip';
$sourceDir = realpath('.'); // absolute path to current directory

$files = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filePath = $file->getPathname();

        // Skip the zip file itself
        if (basename($filePath) === $zipFile) {
            continue;
        }

        $files[] = $filePath;
        echo "Adding file: $filePath<br>";
    }
}

if (empty($files)) {
    die("❌ No files found to add. Check your directory and permissions.");
}

// Create archive
$archive = new PclZip($zipFile);
$result = $archive->create($files, PCLZIP_OPT_REMOVE_PATH, $sourceDir);

if ($result == 0) {
    die("<br>❌ ZIP creation failed: " . $archive->errorInfo(true));
}

echo "<br>✅ ZIP file created: $zipFile with " . count($files) . " files.";
?>

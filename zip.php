<?php
require_once 'pclzip.lib.php';

$zipFile = 'voucher.zip';
$sourceDir = '.';

$files = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filePath = $file->getPathname();
        $files[] = $filePath;
        echo "Adding file: $filePath<br>";
    }
}

if (empty($files)) {
    die("❌ No files found to add. Check your directory and permissions.");
}

// Create archive
$archive = new PclZip($zipFile);
if ($archive->create($files, PCLZIP_OPT_REMOVE_PATH, getcwd())) {
    echo "<br>✅ ZIP file created: $zipFile";
} else {
    echo "<br>❌ ZIP creation failed: " . $archive->errorInfo(true);
}
?>

<?php
require_once 'pclzip.lib.php';

$zipFile = 'test0.zip';
$sourceDir = realpath('../'); // absolute path to current folder

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

        if (!is_readable($filePath)) {
            echo "❌ Cannot read: $filePath<br>";
        } else {
            $files[] = $filePath;
            echo "✅ Adding: $filePath<br>";
        }
    }
}

if (empty($files)) {
    die("❌ No readable files found.");
}

// ✅ Do NOT use PCLZIP_OPT_REMOVE_PATH for now
$archive = new PclZip($zipFile);
$result = $archive->create($files);

if ($result == 0) {
    die("❌ ZIP failed: " . $archive->errorInfo(true));
}

echo "<br>✅ ZIP created: $zipFile with " . count($files) . " files.";

// Optional: list contents
echo "<pre>";
print_r($archive->listContent());
echo "</pre>";
?>

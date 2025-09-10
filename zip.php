<?php
require_once 'pclzip.lib.php';

$archive = new PclZip('test.zip');
$result = $archive->create('index.php');

if ($result == 0) {
    die("❌ " . $archive->errorInfo(true));
}

echo "✅ test.zip created with index.php";
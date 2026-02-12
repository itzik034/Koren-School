<?php

$folderPath = '/img/slider';
$files = glob($folderPath . '/*');
$fileCount = count($files);

echo json_encode(['fileCount' => $fileCount]);

?>
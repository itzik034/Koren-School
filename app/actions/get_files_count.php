<?php

$folderPath = '/ks/img/slider';
$files = glob($folderPath . '/*');
$fileCount = count($files);

echo json_encode(['fileCount' => $fileCount]);

?>
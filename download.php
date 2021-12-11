<?php 

if (!$_GET['filepath']) {
    header("Location: index.php?error=You can't access the page without upload image");
}

$file_path = $_GET['filepath'];
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\""); 
readfile($file_path); 

?>
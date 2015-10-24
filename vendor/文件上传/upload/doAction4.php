<?php 
header('content-type:text/html;charset=utf-8');
include_once 'upload.func.php';
//print_r($_FILES);
foreach($_FILES as $fileInfo){
	$files[]=uploadFile($fileInfo);
}
print_r($files);
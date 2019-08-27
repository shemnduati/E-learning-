<?php
	$known_mime_types=array(
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "jpg" => "image/jpg",
        "php" => "text/plain",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html"=> "text/html",
        "png" => "image/png",
        "jpeg"=> "image/jpg"
    );
	
	if(isset($_GET['file']) && !empty($_GET['file']) && isset($_GET['name']) && !empty($_GET['name'])){
		$original = $_GET['file'];
		$filename = $_GET['name'];
		
		$info = new SplFileInfo($original);
		$ext = $info->getExtension();
		
		$path = 'uploads/' . $original;
		if(file_exists($path)){
			
			header('Content-Transfer-Encoding: binary');
			header('Content-Description: File Transfer');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
			header('Accept-Ranges: bytes');
			header('Content-Length: '. filesize($path));
			header('Content-Encoding: none');
			header('Content-Type: ' . $known_mime_types[$ext]);
			header('Content-Disposition: attachment; filename="' . $filename . '.' . $ext . '"');
			readfile($path);
			exit;
		}
		
		else{
			die('File not found');
		}
	}
	else{
		die('Invalid URI');
	}
?>
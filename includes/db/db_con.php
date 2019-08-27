<?php
	define('SERVER','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','project');
	
	$conn = new mysqli(SERVER, USER, PASSWORD, DATABASE);
	
	if($conn->connect_errno){
		die($conn->connect_error);
	}
?>
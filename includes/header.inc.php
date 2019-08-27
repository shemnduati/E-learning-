<?php
	if(isset($_SESSION['studentDetails']) && !empty($_SESSION['studentDetails'])){
		$studentDetails = $_SESSION['studentDetails'];
		require_once 'studentHeader.inc.php';
	}
	
	elseif(isset($_SESSION['teacherDetails']) && !empty($_SESSION['teacherDetails'])){
		$teacherDetails = $_SESSION['teacherDetails'];
		require_once 'teacherHeader.inc.php';
	}
	
	else{
		require_once 'default_header.inc.php';
	}
?>
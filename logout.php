<?php
	require_once 'includes/core.inc.php';
	
	$_SESSION['studentDetails'] = '';
	unset($_SESSION['studentDetails']);
	
	$_SESSION['teacherDetails'] = '';
	unset($_SESSION['teacherDetails']);
	
	$_SESSION['adminDetails'] = '';
	unset($_SESSION['adminDetails']);
	
	redirectTo('index.php');
?>
<?php
	if(isset($_SESSION['teacherDetails']) && !empty($_SESSION['teacherDetails'])){
		$teacherDetails = $_SESSION['teacherDetails'];
	}
	
	else{
		redirectTo('logout.php');
	}
?>
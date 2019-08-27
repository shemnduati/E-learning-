<?php
	if(isset($_SESSION['studentDetails']) && !empty($_SESSION['studentDetails'])){
		$studentDetails = $_SESSION['studentDetails'];
	}
	
	else{
		redirectTo('logout.php');
	}
?>
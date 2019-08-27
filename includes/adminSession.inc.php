<?php
	if(isset($_SESSION['adminDetails']) && !empty($_SESSION['adminDetails'])){
		$adminDetails = $_SESSION['adminDetails'];
	}
	
	else{
		redirectTo('../logout.php');
	}
?>
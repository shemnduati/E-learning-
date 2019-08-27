<?php
	$query = 'SELECT * FROM messages WHERE recepient = ? AND readStatus = 0';
	$statement = $conn->prepare($query);
	$statement->bind_param('s', $studentDetails['id']);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$rows = $statement->num_rows;
	}else{
		$rows = '0';
	}
?>


<div class = "col-lg-3 no-print">
	<div class = "thumbnail">
		<img src = "<?php echo file_exists($studentDetails['image']) ? $studentDetails['image']  : 'images/default.png'; ?>" class = "img-responsive" alt = "">
		
		<?php
			if(isset($_POST['profilePic'])){
				
				$page = $_POST['page'];
				
				if($handle = uploadPicture('pic')){
					$query = "UPDATE students SET image = '$handle' WHERE id = '" . $studentDetails['id'] . "'";
					$statement = $conn->prepare($query);
					$statement->execute();
					$statement->store_result();
					if($statement->affected_rows > 0){
						$_SESSION['studentDetails']['image'] = 'images/uploads/' . $handle;
						redirectTo($page);
					}
				}
			}
		?>
		
		<form action = "" method = "post" id = "profilePic" enctype = "multipart/form-data">
			<input type = "file" name = "pic" id = "file" accept = "image/png, image/jpeg" />
			<input type = "hidden" value = "upload" name = "profilePic" />
			<input type = "hidden" value = "<?php echo $_SERVER['PHP_SELF']; ?>" name = "page" />
		</form>
		<h3 style = "text-align:center"><?php echo strtoupper($studentDetails['fullName']) ?></h3>
	</div><br />
	<div class="list-group">
		<a href="studentHome.php" class="list-group-item <?php echo $pageName == 'studentHome' ? makeActive() : '' ;?>">MY PROGRESS</a>
		<a href="studentMaterials.php" class="list-group-item <?php echo $pageName == 'studentMaterials' ? makeActive() : '' ;?>">DOWNLOADABLE MATERIALS</a>
		<a href="studentAssignments.php" class="list-group-item <?php echo $pageName == 'studentAssignments' ? makeActive() : '' ;?>">ASSIGNMENTS</a>
		<a href="quiz.php" class="list-group-item <?php echo $pageName == 'studentquiz' ? makeActive() : '' ;?>">QUIZ</a>
		<a href="studentMessages.php" class="list-group-item <?php echo $pageName == 'studentMessages' ? makeActive() : '' ;?>">MESSAGES <span class="badge"><?php echo $rows;?></span></a>
		<a href="logout.php" class="list-group-item">LOGOUT</a>
	</div>
</div>

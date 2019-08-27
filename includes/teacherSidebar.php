<div class = "col-lg-3 no-print">
	<div class = "thumbnail">
		<img src = "<?php echo file_exists($teacherDetails['image']) ? $teacherDetails['image']  : 'images/default.png'; ?>" class = "img-responsive" alt = "">
		
		<?php
			if(isset($_POST['profilePic'])){
				$page = $_POST['page'];
				
				if($handle = uploadPicture('pic')){
					$query = "UPDATE teachers SET image = '$handle' WHERE id = '" . $teacherDetails['id'] . "'";
					$statement = $conn->prepare($query);
					$statement->execute();
					$statement->store_result();
					if($statement->affected_rows > 0){
						$_SESSION['teacherDetails']['image'] = 'images/uploads/' . $handle;
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
		
		<h3 style = "text-align:center"><?php echo strtoupper($teacherDetails['fullName'])?></h3>
	</div><br />
	<div class="list-group">
		<a href="addMaterial.php" class="list-group-item <?php echo $pageName == 'addMaterial' ? makeActive() : '' ;?>">ADD MATERIAL</a>
		<a href="addAssignment.php" class="list-group-item <?php echo $pageName == 'addAssignment' ? makeActive() : '' ;?>">ADD ASSIGNMENT</a>
		<a href="addquiz.php" class="list-group-item <?php echo $pageName == 'addquiz' ? makeActive() : '' ;?>">ADD QUIZ</a>
		<a href="teacherHome.php" class="list-group-item <?php echo $pageName == 'teacherHome' ? makeActive() : '' ;?>">UNMARKED ASSIGNMENTS</a>
		<a href="unmarkedQuiz.php" class="list-group-item <?php echo $pageName == 'unmarkedQuiz' ? makeActive() : '' ;?>">UNMARKED QUIZ</a>
		<a href="markedAssignments.php" class="list-group-item <?php echo $pageName == 'markedAssignments' ? makeActive() : '' ;?>">MARKED ASSIGNMENTS</a>
		<a href="markedQuiz.php" class="list-group-item <?php echo $pageName == 'markedQuiz' ? makeActive() : '' ;?>">MARKED QUIZ</a>
		<a href="myAssignments.php" class="list-group-item <?php echo $pageName == 'myAssignments' ? makeActive() : '' ;?>">MY ASSIGNMENTS</a>
		<a href="myQuiz.php" class="list-group-item <?php echo $pageName == 'myQuiz' ? makeActive() : '' ;?>">MY QUIZ</a>
		<a href="logout.php" class="list-group-item">LOGOUT</a>
	</div>
</div>

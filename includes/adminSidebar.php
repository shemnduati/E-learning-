<div class = "col-lg-3 no-print">
	<div class = "thumbnail">
		<img src = "<?php echo file_exists($adminDetails['image']) ? $adminDetails['image']  : '../images/default.png'; ?>" class = "img-responsive" alt = "">
		
		<?php
			if(isset($_POST['profilePic'])){
				if($handle = uploadPictureAdmin('pic')){
					
					$page = $_POST['page'];
					
					$query = "UPDATE admin SET image = '$handle' WHERE id = '" . $adminDetails['id'] . "'";
					$statement = $conn->prepare($query);
					$statement->execute();
					$statement->store_result();
					if($statement->affected_rows > 0){
						$_SESSION['adminDetails']['image'] = '../images/uploads/' . $handle;
						redirectTo($page);
					}else{
						echo mysqli_error($conn);
					}
				}
			}
		?>
		
		<form action = "" method = "post" id = "profilePic" enctype = "multipart/form-data">
			<input type = "file" name = "pic" id = "file" accept = "image/png, image/jpeg" />
			<input type = "hidden" value = "upload" name = "profilePic" />
			<input type = "hidden" value = "<?php echo $_SERVER['PHP_SELF']; ?>" name = "page" />
		</form>
		
		<h3 style = "text-align:center"><?php echo strtoupper($adminDetails['name'])?></h3>
	</div><br />
	<div class="list-group">
		<a href="adminHome.php" class="list-group-item <?php echo $pageName == 'adminHome' ? makeActive() : '' ;?>">VERIFY TEACHERS</a>
		<a href="addUnit.php" class="list-group-item <?php echo $pageName == 'addUnit' ? makeActive() : '' ;?>">ADD UNIT / COURSE</a>
		<a href="viewTeachers.php" class="list-group-item <?php echo $pageName == 'viewTeachers' ? makeActive() : '' ;?>">VIEW TEACHERS</a>
		<a href="viewStudents.php" class="list-group-item <?php echo $pageName == 'viewStudents' ? makeActive() : '' ;?>">VIEW STUDENTS</a>
		<a href="../logout.php" class="list-group-item">LOGOUT</a>
	</div>
</div>

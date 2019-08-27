<?php require_once 'includes/core.inc.php';?>

<?php
	$msg = '';
	$username = '';

	if(isset($_POST['loginStudent'])){
		$required_fields = ['password' => 'Password','username' => 'Username'];
		$errors = array();

		foreach($required_fields as $field => $description){
			if(empty($_POST[$field]) || !isset($_POST[$field])){
				$errors[] = $description;
			}
		}

		foreach($_POST as $key => $value){
			if(isset($_POST[$key])){
				${$key} = htmlentities($value);
			}else{
				${$key} = '';
			}
		}


		if(empty($errors)){

			$query = 'SELECT id, fname,lname,username,course, image FROM students WHERE username = ? AND password = ? LIMIT 1';
			$statement = $conn->prepare($query);
			$statement->bind_param('ss', $username, $password);

			if($statement->execute()){
				$statement->store_result();

				if($statement->num_rows === 1){
					$statement->bind_result($id, $fname, $lname, $username, $course, $image);

					while($statement->fetch()){
						$id = $id;
						$fname = $fname;
						$lname = $lname;
						$username = $username;
						$course = $course;
						$image = $image;
					}

					$_SESSION['studentDetails'] = array(
						'id' => $id,
						'fname' => $fname,
						'lname' => $lname,
						'fullName' => $fname . ' ' . $lname,
						'username' => $username,
						'course' => (int)$course,
						'image' => 'images/uploads/' . $image
					);

					redirectTo('studentHome.php');
				}

				else{
					$msg = 'Incorrect username/password combination';
				}
			}

			else{
				$msg = mysqli_error();
			}
		}

		else{
			$msg = 'Please fill in the following field(s) : ' . implode(', ' , $errors);
		}
	}

	if(isset($_POST['loginTeacher'])){
		$required_fields = ['password' => 'Password','username' => 'Username'];
		$errors = array();

		foreach($required_fields as $field => $description){
			if(empty($_POST[$field]) || !isset($_POST[$field])){
				$errors[] = $description;
			}
		}

		foreach($_POST as $key => $value){
			if(isset($_POST[$key])){
				${$key} = htmlentities($value);
			}else{
				${$key} = '';
			}
		}

		if(empty($errors)){

			$query = 'SELECT id, fname,lname,username,courseToTeach,status,image FROM teachers WHERE username = ? AND password = ? LIMIT 1';
			$statement = $conn->prepare($query);
			$statement->bind_param('ss', $username, $password);

			if($statement->execute()){
				$statement->store_result();

				if($statement->num_rows === 1){
					$statement->bind_result($id, $fname, $lname, $username, $course, $status, $image);

					while($statement->fetch()){
						$id = $id;
						$fname = $fname;
						$lname = $lname;
						$username = $username;
						$course = $course;
						$status = $status;
						$image = $image;
					}
					if($status === 'VERIFIED'){
						$_SESSION['teacherDetails'] = array(
							'id' => $id,
							'fname' => $fname,
							'lname' => $lname,
							'fullName' => $fname . ' ' . $lname,
							'username' => $username,
							'course' => (int)$course,
							'image' => 'images/uploads/' . $image

						);

						redirectTo('teacherHome.php');
					}else{
						$msg = 'Your account has not yet been verified by the admin';
					}

				}

				else{
					$msg = 'Incorrect username/password combination';
				}
			}

			else{
				$msg = mysqli_error();
			}
		}

		else{
			$msg = 'Please fill in the following field(s) : ' . implode(', ' , $errors);
		}
	}
?>

<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class "row" style = "margin-top:60px;">
		<div class = "col-lg-8"></div>
		<div class = "col-lg-4">
			<h3>Please Log in to continue </h3>

			<p> <?php echo $msg; ?> &nbsp;</p>
			<form action = "" method = "post">
				<div class = "form-group">
					<label for = "username">USERNAME</label>
					<input type = "text" name = "username" id = "username" value = "<?php echo $username?>" class = "form-control" />
				</div>

				<div class = "form-group">
					<label for = "password">PASSWORD</label>
					<input type = "password" name = "password" id = "password" class = "form-control" />
				</div>

				<div class = "form-group">
					<input type = "submit" name = "loginStudent" class = "btn btn-info" value = "Login as student" />
					<input type = "submit" name = "loginTeacher" class = "btn btn-warning pull-right" value = "Login as teacher" />
				</div>

			</form>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>

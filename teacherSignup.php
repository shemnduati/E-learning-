<?php require_once 'includes/core.inc.php';?>

<?php
	$msg = '';

	if(isset($_POST['signupStudent'])){
		$required_fields = ['fname' => 'First name' ,'lname'=>'Last name' ,'gender'=>'Gender' ,
		                    'title'=>'Title','cPassword'=>'Confirm password' ,'course'=>'Course',
							'password' => 'Password','username' => 'Username'];
		$errors = array();

		foreach($required_fields as $field => $description){
			if(empty($_POST[$field]) || !isset($_POST[$field])){
				$errors[] = $description;
			}
		}

		if(empty($errors)){
			foreach($_POST as $key => $value){
				${$key} = htmlentities($value);
			}

			if($password === $cPassword){
				if($image = uploadPicture('image')){
					$query = "INSERT INTO teachers(fname,lname,gender,password,username,courseToTeach, title, image) VALUES(?,?,?,?,?,?,?,?)";
					$statement = $conn->prepare($query);
					$statement->bind_param('ssssssss', $fname, $lname, $gender, $password, $username, $course, $title, $image);
					if($statement->execute()){
						$statement->store_result();
						if($statement->affected_rows > 0){
							$msg = 'Successful signup, click <a href = "login.php">here to login</a>';
						}
						else{
							$msg = "Teacher not added, please try again";
						}
					}
					else{
						$msg = mysqli_error($conn);
					}
				}else{
					$msg = 'Upload failed, please choose a picture below 2MB';
				}

			}

			else{
				$msg = "sorry, password and confirm password do not match";
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
		<div class = "col-lg-2"></div>
		<div class = "col-lg-8">
			<h3 style = "text-align:center">PLEASE FILL IN THE TEACHER DETAILS TO SIGNUP</h3>

			<div class = "col-lg-12"><p> <?php echo $msg; ?> &nbsp;</p></div>
			<form action = "" enctype = "multipart/form-data" method = "post">
				<div class = "col-lg-12">
					<div class = "form-group">
						<label for = "image">PICTURE</label>
						<input type = "file" accept = "image/png, image/jpeg" name = "image" id = "image" />
					</div>
				</div>

				<div class = "col-lg-2">
					<div class = "form-group">
						<label for = "title">TITLE</label>
						<input type = "text" name = "title" id = "title" class = "form-control" />
					</div>
				</div>

				<div class = "col-lg-5">
					<div class = "form-group">
						<label for = "fname">FNAME</label>
						<input type = "text" name = "fname" id = "fname" class = "form-control" />
					</div>
				</div>

				<div class = "col-lg-5">
					<div class = "form-group">
						<label for = "lname">LNAME</label>
						<input type = "text" name = "lname" id = "lname" class = "form-control" />
					</div>
				</div>

				<div class = "col-lg-6">
					<div class = "form-group">
						<label>GENDER</label>
						<div class = "radio-group">
							<input type = "radio" checked = "checked" name = "gender" value = "MALE" id = "male" />
							<label for = "male">MALE</label>

							<input type = "radio" name = "gender" value = "FEMALE" id = "female" />
							<label for = "female">FEMALE</label>
						</div>
					</div>
				</div>

				<div class = "col-lg-6">
					<div class = "form-group">
						<label for = "course">COURSE TO TEACH</label>
						<select name = "course" id = "course" class = "form-control">
							<option value = "" selected>--SELECT COURSE--</option>
							<?php
								$query = 'SELECT id, courseCode, courseName FROM courses';
								$statement = $conn->prepare($query);

								if($statement->execute()){
									$statement->store_result();

									if($statement->num_rows){
										$statement->bind_result($id, $courseCode,$courseName);
										while($statement->fetch()){
											echo '<option value = "' . $id . '">' . $courseName . '</option>';
										}
									}
								}
							?>
						</select>
					</div>
				</div>

				<div class = "col-lg-12">
					<div class = "form-group">
						<label for = "username">USERNAME</label>
						<input type = "text" name = "username" id = "username" class = "form-control" />
					</div>
				</div>

				<div class = "col-lg-6">
					<div class = "form-group">
						<label for = "password">PASSWORD</label>
						<input type = "password" name = "password" id = "password" class = "form-control" />
					</div>
				</div>

				<div class = "col-lg-6">
					<div class = "form-group">
						<label for = "cPassword">CONFIRM PASSWORD</label>
						<input type = "password" name = "cPassword" id = "cPassword" class = "form-control" />
					</div>

					<div class = "form-group">
						<input type = "submit" name = "signupStudent" class = "btn btn-warning pull-right" value = "SIGNUP" />
					</div>
				</div>

			</form>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>

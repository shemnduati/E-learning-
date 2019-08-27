<?php
	$pageName = "adminHome";
	$output = '';
	$username = '';
	$msg = '';
	require_once '../includes/core.inc.php';

	if(isset($_SESSION['adminDetails']) && !empty($_SESSION['adminDetails'])){
		redirectTo('adminHome.php');
	}

	if(isset($_POST['signupAdmin'])){
		$required_fields = ['password' => 'Password','cPassword' => 'Confirm Password', 'name' => 'Names','username' => 'Username'];
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
			if($cPassword === $password){
				if($image = uploadPictureAdmin('image')){
					$query = 'INSERT INTO admin(name,username,password,image) VALUES(?,?,?,?)';
					$statement = $conn->prepare($query);
					$statement->bind_param('ssss', $name, $username, $password, $image);

					if($statement->execute()){
						$statement->store_result();

						if($statement->affected_rows === 1){

							$id = mysqli_insert_id($conn);

							$_SESSION['adminDetails'] = array(
								'id' => $id,
								'name' => $name,
								'username' => $username,
								'image' => '../images/uploads/' . $image
							);

							redirectTo('adminHome.php');
						}

						else{
							$msg = 'Error signing up admin';
						}
					}

					else{
						$msg = mysqli_error();
					}
				}else{
					$msg = "Picture upload failed, please choose an image below 2MB";
				}

			}else{
				$msg = 'Password and confirm password must match';
			}
		}

		else{
			$msg = 'Please fill in the following field(s) : ' . implode(', ' , $errors);
		}
	}

?>



<?php require_once '../includes/default_header_admin.inc.php';?>

<div class = "container">
	<div class "row" style = "margin-top:60px;">
		<div class = "col-lg-4"></div>
		<div class = "col-lg-4">
			<h3>SIGNUP admin</h3>

			<p> <?php echo $msg; ?> &nbsp;</p>
			<form action = "" enctype = "multipart/form-data" method = "post">

					<div class = "form-group">
						<label for = "image">PICTURE</label>
						<input type = "file" accept = "image/png, image/jpeg" name = "image" id = "image" />
					</div>
			

				<div class = "form-group">
					<label for = "name">NAMES</label>
					<input type = "text" name = "name" id = "name" class = "form-control" />
				</div>

				<div class = "form-group">
					<label for = "username">USERNAME</label>
					<input type = "text" name = "username" id = "username" value = "<?php echo $username?>" class = "form-control" />
				</div>

				<div class = "form-group">
					<label for = "password">PASSWORD</label>
					<input type = "password" name = "password" id = "password" class = "form-control" />
				</div>

				<div class = "form-group">
					<label for = "cPassword">CONFIRM PASSWORD</label>
					<input type = "password" name = "cPassword" id = "cPassword" class = "form-control" />
				</div>

				<div class = "form-group">
					<input type = "submit" name = "signupAdmin" class = "btn btn-warning" value = "SIGNUP" />
					<a href = "index.php" class = "pull-right">Already have an account? Log in now</a>
				</div>

			</form>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

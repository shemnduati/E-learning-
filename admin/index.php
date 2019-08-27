<?php
	$pageName = "adminHome";
	$output = '';
	$username = '';
	$msg = '';
	require_once '../includes/core.inc.php';

	if(isset($_SESSION['adminDetails']) && !empty($_SESSION['adminDetails'])){
		redirectTo('adminHome.php');
	}

	if(isset($_POST['loginAdmin'])){
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

			$query = 'SELECT id, name,username,image FROM admin WHERE username = ? AND password = ? LIMIT 1';
			$statement = $conn->prepare($query);
			$statement->bind_param('ss', $username, $password);

			if($statement->execute()){
				$statement->store_result();

				if($statement->num_rows === 1){
					$statement->bind_result($id, $name, $username, $image);

					while($statement->fetch()){
						$id = $id;
						$name = $name;
						$username = $username;
						$image = $image;
					}

					$_SESSION['adminDetails'] = array(
						'id' => $id,
						'name' => $name,
						'username' => $username,
						'image' => '../images/uploads/' . $image
					);

					redirectTo('adminHome.php');
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



<?php require_once '../includes/default_header_admin.inc.php';?>

<div class = "container">
	<div class "row" style = "margin-top:60px;">
		<div class = "col-lg-4"></div>
		<div class = "col-lg-4">
			<h3>Please Log in to continue </h3>

			<p><?php echo $msg; ?> &nbsp;</p>
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
					<input type = "submit" name = "loginAdmin" class = "btn btn-warning" value = "Login" />
					<a href = "addAdmin.php" class = "pull-right">Don't' have an account? Signup now</a>
				</div>

			</form>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

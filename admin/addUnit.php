<?php
	$pageName = "addUnit";
	$output = '';
	$msg = '';

	require_once '../includes/core.inc.php';
	require_once '../includes/adminSession.inc.php';

	if(isset($_POST['submitCourse'])){
		foreach($_POST as $key=>$value){
			${$key} = strtoupper(htmlentities($value));
		}

		$query = 'INSERT INTO courses(courseCode,courseName) VALUES(?,?)';
		$statement = $conn->prepare($query);
		$statement->bind_param('ss', $courseCode, $courseName);
		$statement->execute();
		$statement->store_result();
		if($statement->affected_rows){
			$msg = "Course added :)";
		}	else{
			$msg = 'Course not added, please try again';
		}
	}

	if(isset($_POST['submitUnit'])){
		foreach($_POST as $key=>$value){
			${$key} = strtoupper(htmlentities($value));
		}

		$query = 'INSERT INTO units(unitCode,unitName,courseId) VALUES(?,?,?)';
		$statement = $conn->prepare($query);
		$statement->bind_param('sss', $unitCode, $unitName, $course);
		$statement->execute();
		$statement->store_result();
		if($statement->affected_rows){
			$msg = "Unit added :)";
		}	else{
			$msg = 'Unit not added, please try again';
		}
	}


?>



<?php require_once '../includes/adminHeader.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once '../includes/adminSidebar.php';?>
		<div class = "col-lg-9">
			<h3>VERIFY TEACHERS</h3>
			<p><?php echo $msg;?> &nbsp;</p>
			<div class = "row">
				<div class = "col-lg-6">
					<h2>ADD COURSE</h2>
					<form action = "" method = "POST">
						<div class = "form-group">
							<label for = "courseCode">COURSE CODE</label>
							<input type = "text" name = "courseCode" id = "courseCode" placeholder = "course code" class = "form-control text-upper" required />
						</div>

						<div class = "form-group">
							<label for = "courseName">COURSE NAME</label>
							<input type = "text" name = "courseName" id = "courseName" placeholder = "course name" class = "form-control text-upper" required />
						</div>

						<button type = "submit" name = "submitCourse" class = "btn btn-success">ADD COURSE</button>

					</form>
				</div>

				<div class = "col-lg-6">
					<h2>ADD UNIT</h2>
					<form action = "" method = "POST">
						<div class = "form-group">
							<label for = "course">COURSE</label>
							<select name = "course" id = "course" class = "form-control text-upper" required>
								<option value = "">-- SELECT COURSE --</option>
								<?php
									$query = "SELECT id, courseCode, courseName FROM courses ORDER BY courseCode ASC";
									$statement = $conn->prepare($query);
									$statement->execute();
									$statement->store_result();
									if($statement->num_rows){
										$statement->bind_result($id, $courseCode, $courseName);
										while($statement->fetch()){
											echo '<option value = "' . $id . '">' . '('.$courseCode . ') ' . $courseName . '</option>';
										}
									}else{
										echo '<option value = "">-- NO COURSES, PLEASE ADD A COURSE FIRST &lt;-- --</option>';
									}
								?>
							</select>

						</div>

						<div class = "form-group">
							<label for = "unitCode">UNIT CODE</label>
							<input type = "text" name = "unitCode" id = "unitCode" placeholder = "unit code" class = "form-control text-upper" required />
						</div>

						<div class = "form-group">
							<label for = "unitName">UNIT NAME</label>
							<input type = "text" name = "unitName" id = "unitName" placeholder = "unit name" class = "form-control text-upper" required />
						</div>

						<button type = "submit" name = "submitUnit" class = "btn btn-success pull-right">ADD UNIT</button>

					</form>
				</div>

			</div>

			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

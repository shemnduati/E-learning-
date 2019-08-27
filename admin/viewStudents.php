<?php
	$pageName = "viewStudents";
	$output = '';
	$msg = '';

	require_once '../includes/core.inc.php';
	require_once '../includes/adminSession.inc.php';

	if(isset($_GET['action']) && $_GET['action'] == 'REMOVE'){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = $_GET['id'];

			$query = "DELETE FROM students WHERE id = ?";
			$statement = $conn->prepare($query);
			$statement->bind_param('s', $id);
			$statement->execute();
			$statement->store_result();
			if($statement->affected_rows){
				$msg = 'Student removed ;(';
			}
		}
	}

	$query = "SELECT students.id, students.fname, students.lname, students.gender, students.username,students.location, students.dateRegistered,students.coursePeriod, courses.courseName
						FROM students
	          LEFT JOIN courses
						ON courses.id = students.course
						ORDER BY fname ASC";

	$statement = $conn->prepare($query);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$statement->bind_result($id,$fname,$lname,$gender,$username,$location,$dateRegistered,$coursePeriod, $course);
		$output .= '<table class = "table table-bordered">
									<tr>
										<th>FNAME</th>
										<th>LNAME</th>
										<th>GENDER</th>
										<th>USERNAME</th>
										<th>COURSE</th>
										<th>COURSE PERIOD</th>
										<th>LOCATION</th>
										<th>DATE REGISTERED</th>
										<th></th>
									</tr>';
		while($statement->fetch()){
			$output .= '<tr>
										<td>' . $fname . '</td>
										<td>' . $lname . '</td>
										<td>' . $gender . '</td>
										<td>' . $username . '</td>
										<td>' . $course . '</td>
										<td>' . $coursePeriod . ' SEM</td>
										<td>' . $location . '</td>
										<td>' . date('d-m-Y', strtotime($dateRegistered)) . '</td>
										<td><a class = "btn btn-danger pull-right no-print" href = "viewStudents.php?action=REMOVE&id=' . $id . '">REMOVE STUDENT</a></td>
									</tr>';
		}

		$output .= '</table>';
		$output .= '<button type = "button" id = "print" class = "btn btn-info pull-right no-print">PRINT</button>';
	}else{
		$output = '<p>There are no teachers :)</p>';
	}
?>



<?php require_once '../includes/adminHeader.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once '../includes/adminSidebar.php';?>
		<div class = "col-lg-9">
			<h3>ALL STUDENTS (<?php echo $statement->num_rows; ?>)</h3>
			<p class = "no-print"><?php echo $msg;?> &nbsp;</p>
			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

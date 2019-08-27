<?php
	$pageName = "viewTeachers";
	$output = '';
	$msg = '';

	require_once '../includes/core.inc.php';
	require_once '../includes/adminSession.inc.php';

	if(isset($_GET['action']) && $_GET['action'] == 'REMOVE'){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = $_GET['id'];

			$query = "DELETE FROM teachers WHERE id = ?";
			$statement = $conn->prepare($query);
			$statement->bind_param('s', $id);
			$statement->execute();
			$statement->store_result();
			if($statement->affected_rows){
				$msg = 'Teacher removed ;(';
			}
		}
	}

	$query = "SELECT teachers.id, teachers.title, teachers.fname, teachers.lname, teachers.gender, teachers.username, teachers.status, courses.courseName
						FROM teachers
	          LEFT JOIN courses
						ON courses.id = teachers.courseToTeach
						ORDER BY status ASC";

	$statement = $conn->prepare($query);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$statement->bind_result($id,$title,$fname,$lname,$gender,$username,$status, $course);
		$output .= '<table class = "table table-bordered">
									<tr>
										<th>TITLE</th>
										<th>FNAME</th>
										<th>LNAME</th>
										<th>GENDER</th>
										<th>USERNAME</th>
										<th>COURSE</th>
										<th>STATUS</th>
										<th></th>
									</tr>';
		while($statement->fetch()){
			$output .= '<tr>
										<td>' . $title . '</td>
										<td>' . $fname . '</td>
										<td>' . $lname . '</td>
										<td>' . $gender . '</td>
										<td>' . $username . '</td>
										<td>' . $course . '</td>
										<td>' . $status . '</td>
										<td><a class = "btn btn-danger pull-right no-print" href = "viewTeachers.php?action=REMOVE&id=' . $id . '">REMOVE TEACHER</a></td>
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
			<h3>AVALIABLE TEACHERS (<?php echo $statement->num_rows; ?>)</h3>
			<p><?php echo $msg;?> &nbsp;</p>
			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

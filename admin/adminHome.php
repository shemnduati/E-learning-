<?php
	$pageName = "adminHome";
	$output = '';
	$msg = '';

	require_once '../includes/core.inc.php';
	require_once '../includes/adminSession.inc.php';

	if(isset($_GET['action']) && $_GET['action'] == 'VERIFY'){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = $_GET['id'];

			$query = "UPDATE teachers SET status = 'VERIFIED' WHERE id = ?";
			$statement = $conn->prepare($query);
			$statement->bind_param('s', $id);
			$statement->execute();
			$statement->store_result();
			if($statement->affected_rows){
				$msg = 'Teacher verified :)';
			}
		}
	}

	$query = "SELECT teachers.id, teachers.title, teachers.fname, teachers.lname, teachers.gender, teachers.username, courses.courseName
						FROM teachers
	          LEFT JOIN courses
						ON courses.id = teachers.courseToTeach
						WHERE teachers.status = 'UNVERIFIED'";

	$statement = $conn->prepare($query);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$statement->bind_result($id,$title,$fname,$lname,$gender,$username,$course);
		$output .= '<table class = "table table-bordered">
									<tr>
										<th>TITLE</th>
										<th>FNAME</th>
										<th>LNAME</th>
										<th>GENDER</th>
										<th>USERNAME</th>
										<th>COURSE</th>
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
										<td><a class = "btn btn-success pull-right" href = "adminHome.php?action=VERIFY&id=' . $id . '">VERIFY TEACHER</a></td>
									</tr>';
		}

		$output .= '</table>';
	}else{
		$output = '<p>There are no unverified teachers :)</p>';
	}
?>



<?php require_once '../includes/adminHeader.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once '../includes/adminSidebar.php';?>
		<div class = "col-lg-9">
			<h3>VERIFY TEACHERS</h3>
			<p><?php echo $msg;?> &nbsp;</p>
			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once '../includes/admin_footer.inc.php';?>

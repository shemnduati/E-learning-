<?php 
	$pageName = "teacherHome";
	$output = '';
	$msg = '';
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['updateMarks'])){
		$assignmentId = $_POST['assignmentId'];
		$marks = $_POST['marks'];
		
		$query = "UPDATE submittedAssignments SET marks = ?, status = 'MARKED' WHERE id = ?";
		$statement = $conn->prepare($query);
		$statement->bind_param('ss', $marks, $assignmentId);
		$statement->execute();
		
		$statement->store_result();
		if($statement->affected_rows){
			$msg = 'Marks awarded successfully';
		}else{
			$msg = 'The same marks awarded, no changes made';
		}
		
	}
	
	$query = "SELECT submittedAssignments.id, submittedAssignments.name, submittedAssignments.dateSubmitted, submittedAssignments.fileUrl, students.fname, students.lname 
	          FROM submittedAssignments 
			  LEFT JOIN students 
			  ON submittedAssignments.studentId = students.id 
			  WHERE submittedAssignments.teacherId = ? AND submittedAssignments.status = 'UNMARKED' AND submittedAssignments.courseId = ? 
			  ORDER by submittedAssignments.dateSubmitted DESC";
	$statement = $conn->prepare($query);
	$statement->bind_param('ss', $teacherDetails['id'], $teacherDetails['course']);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$statement->bind_result($assignmentId, $assignmentName, $dateSubmitted, $fileUrl, $fname, $lname);
		
		$output .= '<table class = "table table-bordered">
						<tr class = "active">
							<th>STUDENT NAME</th>
							<th>ASSIGNMENT</th>
							<th>DATE SUBMITTED</th>
							<th>FILE</th>
							<th>MARKS (MIN:0, MAX:30)</th>
						</tr>';
		while($statement->fetch()){
			$output .= '<tr>
							<td>' . strtoupper($fname . ' ' . $lname) . '</td>
							<td>' . strtoupper($assignmentName) . '</td>
							<td>' . $dateSubmitted . '</td>
							<td><a href = "download.php?file=' . $fileUrl . '&name=<' . strtoupper($fname . ' ' . $lname . '> ' . $assignmentName) . ' ASSIGNMENT" class = "btn btn-success">DOWNLOAD</a></td>
							<td>
								<form class = "form-inline" action = "" method = "POST">
									<input type = "hidden" name = "assignmentId" value = "' . $assignmentId . '">
									<div class="input-group">
										<input type = "number" min = "0" max = "30" placeholder = "marks" class = "form-control" name = "marks" required />
										<span class="input-group-btn">
											<button type = "submit" name = "updateMarks" class = "btn btn-info">ASSIGN MARKS</button>
										</span>
										
									</div>
								</form>
							</td>
						</tr>';
		}
		$output .= '</table>';
		
	}else{
		$output = '<p>There are no unmarked assignments :)</p>';
	}
	
	
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/teacherSidebar.php';?>
		<div class = "col-lg-9">
			<h3>UNMARKED ASSIGNMENTS (<?php echo $statement->num_rows;?>)</h3> 
			<p><?php echo $msg;?> &nbsp;</p>
			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
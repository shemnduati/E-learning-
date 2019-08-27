<?php
	$pageName = "markedQuiz";
	$output = '';
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';

	$query = "SELECT submittedQuiz.id, submittedQuiz.name, submittedQuiz.dateSubmitted, submittedQuiz.marks, submittedQuiz.fileUrl, students.fname, students.lname
	          FROM submittedQuiz
			  LEFT JOIN students
			  ON submittedQuiz.studentId = students.id
			  WHERE submittedQuiz.teacherId = ? AND submittedQuiz.status = 'MARKED' AND submittedQuiz.courseId = ?
			  ORDER by submittedQuiz.dateSubmitted DESC";
	$statement = $conn->prepare($query);
	$statement->bind_param('ss', $teacherDetails['id'], $teacherDetails['course']);
	$statement->execute();
	$statement->store_result();
	if($statement->num_rows){
		$statement->bind_result($assignmentId, $assignmentName, $dateSubmitted, $marks, $fileUrl, $fname, $lname);

		$output .= '<table class = "table table-bordered">
						<tr class = "active">
							<th>STUDENT NAME</th>
							<th>QUIZ</th>
							<th>DATE SUBMITTED</th>
							<th>FILE</th>
							<th>MARKS</th>
						</tr>';
		while($statement->fetch()){
			$output .= '<tr>
							<td>' . strtoupper($fname . ' ' . $lname) . '</td>
							<td>' . strtoupper($assignmentName) . '</td>
							<td>' . $dateSubmitted . '</td>
							<td><a href = "download.php?file=' . $fileUrl . '&name=<' . strtoupper($fname . ' ' . $lname . '> ' . $assignmentName) . ' ASSIGNMENT" class = "btn no-print btn-success">DOWNLOAD</a></td>
							<td>' . $marks . ' MARKS</td>
						</tr>';
		}
		$output .= '</table>';
		$output .= '<button type = "button" id = "print" class = "btn btn-info pull-right no-print">PRINT</button>';

	}else{
		$output = '<p>There are no marked quiz :(</p>';
	}


?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/teacherSidebar.php';?>
		<div class = "col-lg-9">
			<h3>MARKED QUIZ (<?php echo $statement->num_rows;?>)</h3>
			<p><?php echo $msg; ?>&nbsp;</p>
			<?php echo $output?>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>

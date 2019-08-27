<?php 
	$pageName = "myQuiz";
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['deleteAssignment'])){
		
		
		foreach($_POST as $key => $value){
			${$key} = $value;
		}

		$query = "DELETE FROM quiz WHERE id = ?";
		$statement = $conn->prepare($query);
		$statement->bind_param('s', $assignmentId);
		$statement->execute();
		$statement->store_result();
		if($statement->affected_rows){
			$msg = "Quiz deleted :)";
		}else{
			$msg = 'Quiz not deleted, please try again';
		}
	}
	
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/teacherSidebar.php';?>
		<div class = "col-lg-9"> 
			<h3>MY QUIZ</h3>
			<p><?php echo $msg; ?>&nbsp;</p>
			<div class = "row">
				<div class = "col-lg-12">
				<?php
					$query = 'SELECT quiz.id, quiz.quizName, quiz.unitCode, quiz.dateSubmitted, quiz.dateDue, quiz.filePath, quiz.teacherId, 
					                 units.unitName, teachers.fname, teachers.lname 
							  FROM quiz 
							  LEFT JOIN units 
							  ON quiz.unitCode = units.unitCode 
							  LEFT join teachers 
							  ON quiz.teacherId = teachers.id 
							  WHERE quiz.teacherId = ? 
							  ORDER BY quiz.dateSubmitted DESC';
					$statement = $conn->prepare($query);
					$statement->bind_param('s', $teacherDetails['id']);
					
					if($statement->execute()){
						$statement->store_result();
						
						if($statement->num_rows > 0){
							$statement->bind_result($assignmentId, $assignmentName, $unitCode, $dateSubmitted, $dateDue, $filePath, $teacherId, $unitName, $fname, $lname);
							$data = '<table class = "table table-bordered">
										<tr class = "active">
											<th>QUIZ</th>
											<th>DATE SUBMITTED</th>
											<th>DATE DUE</th>
											<th></th>
											<th></th>
										</tr>';
							
							while($statement->fetch()){
								$heading = '(' . $unitCode . ') ' . $assignmentName;
								
								$data .= '<tr>
											<td>' . $heading . '</td>
											<td>' . date('d-m-Y', strtotime($dateSubmitted)) . '</td>
											<td>' . date('d-m-Y', strtotime($dateDue)) . '</td>
											<td>
												<form action = "" method = "POST" enctype = "multipart/form-data">
													
													<input type = "hidden" name = "assignmentId" value = "' . $assignmentId . '" />
													<button type = "submit" name = "deleteAssignment" class = "btn btn-danger btn-block">DELETE QUIZ</button>
												</form>
											</td>
											<td>
												<a href = "download.php?file=' . $filePath . '&name=' . $heading . ' ASSIGNMENT" class = "btn btn-success btn-block">DOWNLOAD QUIZ</a>
											</td>
										 </tr>';
							}
							
							$data .= '</table>';
							
							echo $data;
						}
						
						else{
							echo '<h4>No quiz found</h4>';
						}
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
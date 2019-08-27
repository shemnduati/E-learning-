<?php 
	$pageName = "studentQuiz";
	require_once 'includes/core.inc.php';
	require_once 'includes/studentSession.inc.php';
	
	if(isset($_POST['submitQuiz'])){
		$result = uploadFile('quiz');
		
		foreach($_POST as $key => $value){
			${$key} = $value;
		}
		
		if($result['url']){
			$url = $result['url'];
			
			$query = "INSERT into submittedquiz(studentId, courseId, teacherId, name, fileUrl) VALUES(?,?,?,?,?)";
			$statement = $conn->prepare($query);
			$statement->bind_param('sssss', $studentId, $courseId, $teacherId, $quizName, $url);
			$statement->execute();
			$statement->store_result();
			if($statement->affected_rows){
				$msg = "Quiz submitted :)";
			}else{
				$msg = 'Quiz not submitted, please try again';
			}
		}else{
			die($result['error']);
		}
	}
	
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/studentSidebar.php';?>
		<div class = "col-lg-9"> 
			<h3>QUIZ</h3>
			<p><?php echo $msg; ?>&nbsp;</p>
			<div class = "row">
				<?php
					$query = 'SELECT quiz.quizName, quiz.unitCode, quiz.dateSubmitted, quiz.dateDue, quiz.filePath, quiz.teacherId, 
					                 units.unitName, teachers.fname, teachers.lname 
							  FROM quiz 
							  LEFT JOIN units 
							  ON quiz.unitCode = units.unitCode 
							  LEFT join teachers 
							  ON quiz.teacherId = teachers.id 
							  WHERE quiz.courseId = ? 
							  ORDER BY quiz.dateSubmitted DESC';
					$statement = $conn->prepare($query);
					$statement->bind_param('s', $studentDetails['course']);
					
					if($statement->execute()){
						$statement->store_result();
						
						if($statement->num_rows > 0){
							$statement->bind_result($quizName, $unitCode, $dateSubmitted, $dateDue, $filePath, $teacherId, $unitName, $fname, $lname);
							$data = '';
							
							while($statement->fetch()){
								$heading = '(' . $unitCode . ') ' . $quizName;
								$data .= '<div class = "col-lg-4">
											<div class = "panel panel-info">
												<div class = "panel-heading">' . $heading . ' </div>
												<div class = "panel-body">
													<p>LECTURER : ' . strtoupper($fname . ' ' . $lname) . '</p>
													<p>DATE SUBMITTED : ' . date('d-m-Y', strtotime($dateSubmitted)) . '</p>
													<p>DATE DUE : ' . date('d-m-Y', strtotime($dateDue)) . '</p>
													<p>
														<a href = "download.php?file=' . $filePath . '&name=' . $heading . ' QUIZ" class = "btn btn-success btn-block quiz">DOWNLOAD ASSIGNMENT</a>
													</p>
													<form action = "" method = "POST" enctype = "multipart/form-data">
														
														<div class = "form-group">
															<label>Submit Quiz</label>
															<input type = "file" required name = "quiz" accept = "application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document.docx" />
															<input type = "hidden" name = "studentId" value = "' . $studentDetails['id'] . '" />
															<input type = "hidden" name = "courseId" value = "' . $studentDetails['course'] . '" />
															<input type = "hidden" name = "teacherId" value = "' . $teacherId . '" />
															<input type = "hidden" name = "quizName" value = "' . $heading . '" />
															
														</div>
														<button type = "submit" name = "submitQuiz" class = "btn btn-info btn-block submitQuiz">SUBMIT QUIZ</button>
														
													</form>
													
												</div>
											</div>
										</div>';
							}
							
							echo $data;
						}
						
						else{
							echo '<div class = "col-lg-12"><h4>No quiz yet</h4>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
<?php 
	$pageName = "studentAssignments";
	require_once 'includes/core.inc.php';
	require_once 'includes/studentSession.inc.php';
	
	if(isset($_POST['submitAssignment'])){
		$result = uploadFile('assignment');
		
		foreach($_POST as $key => $value){
			${$key} = $value;
		}
		
		if($result['url']){
			$url = $result['url'];
			
			$query = "INSERT into submittedAssignments(studentId, courseId, teacherId, name, fileUrl) VALUES(?,?,?,?,?)";
			$statement = $conn->prepare($query);
			$statement->bind_param('sssss', $studentId, $courseId, $teacherId, $assignmentName, $url);
			$statement->execute();
			$statement->store_result();
			if($statement->affected_rows){
				$msg = "Assignment submitted :)";
			}else{
				$msg = 'Assignment not submitted, please try again';
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
			<h3>ASSIGNMENTS</h3>
			<p><?php echo $msg; ?>&nbsp;</p>
			<div class = "row">
				<?php
					$query = 'SELECT assignments.assignmentName, assignments.unitCode, assignments.dateSubmitted, assignments.dateDue, assignments.filePath, assignments.teacherId, 
					                 units.unitName, teachers.fname, teachers.lname 
							  FROM assignments 
							  LEFT JOIN units 
							  ON assignments.unitCode = units.unitCode 
							  LEFT join teachers 
							  ON assignments.teacherId = teachers.id 
							  WHERE assignments.courseId = ? 
							  ORDER BY assignments.dateSubmitted DESC';
					$statement = $conn->prepare($query);
					$statement->bind_param('s', $studentDetails['course']);
					
					if($statement->execute()){
						$statement->store_result();
						
						if($statement->num_rows > 0){
							$statement->bind_result($assignmentName, $unitCode, $dateSubmitted, $dateDue, $filePath, $teacherId, $unitName, $fname, $lname);
							$data = '';
							
							while($statement->fetch()){
								$heading = '(' . $unitCode . ') ' . $assignmentName;
								$data .= '<div class = "col-lg-4">
											<div class = "panel panel-info">
												<div class = "panel-heading">' . $heading . ' </div>
												<div class = "panel-body">
													
													<p>LECTURER : ' . strtoupper($fname . ' ' . $lname) . '</p>
													<p>DATE SUBMITTED : ' . date('d-m-Y', strtotime($dateSubmitted)) . '</p>
													<p>DATE DUE : ' . date('d-m-Y', strtotime($dateDue)) . '</p>
													<p>
														<a href = "download.php?file=' . $filePath . '&name=' . $heading . ' ASSIGNMENT" class = "btn btn-success btn-block">DOWNLOAD ASSIGNMENT</a>
													</p>
													<form action = "" method = "POST" enctype = "multipart/form-data">
														
														<div class = "form-group">
															<label>Submit Assignment</label>
															<input type = "file" required name = "assignment" accept = "application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document.docx" />
															<input type = "hidden" name = "studentId" value = "' . $studentDetails['id'] . '" />
															<input type = "hidden" name = "courseId" value = "' . $studentDetails['course'] . '" />
															<input type = "hidden" name = "teacherId" value = "' . $teacherId . '" />
															<input type = "hidden" name = "assignmentName" value = "' . $heading . '" />
															
														</div>
														<button type = "submit" name = "submitAssignment" class = "btn btn-info btn-block">SUBMIT ASSIGNMENT</button>
														
													</form>
													
												</div>
											</div>
										</div>';
							}
							
							echo $data;
						}
						
						else{
							echo '<div class = "col-lg-12"><h4>No assignments yet</h4>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>

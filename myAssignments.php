<?php 
	$pageName = "myAssignments";
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['deleteAssignment'])){
		
		
		foreach($_POST as $key => $value){
			${$key} = $value;
		}

		$query = "DELETE FROM assignments WHERE id = ?";
		$statement = $conn->prepare($query);
		$statement->bind_param('s', $assignmentId);
		$statement->execute();
		$statement->store_result();
		if($statement->affected_rows){
			$msg = "Assignment deleted :)";
		}else{
			$msg = 'Assignment not deleted, please try again';
		}
	}
	
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/teacherSidebar.php';?>
		<div class = "col-lg-9"> 
			<h3>MY ASSIGNMENTS</h3>
			<p><?php echo $msg; ?>&nbsp;</p>
			<div class = "row">
				<div class = "col-lg-12">
				<?php
					$query = 'SELECT assignments.id, assignments.assignmentName, assignments.unitCode, assignments.dateSubmitted, assignments.dateDue, assignments.filePath, assignments.teacherId, 
					                 units.unitName, teachers.fname, teachers.lname 
							  FROM assignments 
							  LEFT JOIN units 
							  ON assignments.unitCode = units.unitCode 
							  LEFT join teachers 
							  ON assignments.teacherId = teachers.id 
							  WHERE assignments.teacherId = ? 
							  ORDER BY assignments.dateSubmitted DESC';
					$statement = $conn->prepare($query);
					$statement->bind_param('s', $teacherDetails['id']);
					
					if($statement->execute()){
						$statement->store_result();
						
						if($statement->num_rows > 0){
							$statement->bind_result($assignmentId, $assignmentName, $unitCode, $dateSubmitted, $dateDue, $filePath, $teacherId, $unitName, $fname, $lname);
							$data = '<table class = "table table-bordered">
										<tr class = "active">
											<th>ASSIGNMENT</th>
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
													<button type = "submit" name = "deleteAssignment" class = "btn btn-danger btn-block">DELETE ASSIGNMENT</button>
												</form>
											</td>
											<td>
												<a href = "download.php?file=' . $filePath . '&name=' . $heading . ' ASSIGNMENT" class = "btn btn-success btn-block">DOWNLOAD ASSIGNMENT</a>
											</td>
										 </tr>';
							}
							
							$data .= '</table>';
							
							echo $data;
						}
						
						else{
							echo '<h4>No assignments found</h4>';
						}
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
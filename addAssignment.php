<?php 
	$pageName = "addAssignment";
	$output = '';
	$msg = '';
	
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['addAssignment'])){
		foreach($_POST as $key => $value){
			${$key} = $value;
		}
		
		$result = uploadFile('file');
		
		if($result['url']){
			$filePath = $result['url'];
			$query = "INSERT INTO assignments(assignmentName, courseId, unitCode,teacherId, filePath, dateDue) VALUES(?,?,?,?,?,?)";
		
			$statement = $conn->prepare($query);
			$statement->bind_param('ssssss', $assignmentName, $teacherDetails['course'], $unitCode, $teacherDetails['id'], $filePath, $dateDue);
			$statement->execute();
			$statement->store_result();
			
			if($statement->affected_rows){
				$msg = 'Assignment posted :)';
			}else{
				$msg = 'Assignment not posted, please try again';
			}
		
		}else{
			$msg = $result['error'];
		}
		
		
	}
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/teacherSidebar.php';?>
		<div class = "col-lg-9">
			<h3>ADD ASSIGNMENT</h3> 
			<p><?php echo $msg;?> &nbsp;</p>
			<form action = "" method = "POST" enctype = "multipart/form-data">
				<div class = "form-group">
					<span for = "">FILE</span>
					<input type = "file" name = "file" required />
				</div>
				
				<div class = "form-group">
					<span for = "">UNIT</span>
					<select class = "form-control" name = "unitCode">
					<?php 
						$query = "SELECT id, unitCode, unitName FROM units WHERE courseId = '" . $teacherDetails['course'] . "'";
						$statement = $conn->prepare($query);
						$statement->execute();
						$statement->store_result();
						if($statement->num_rows){
							$statement->bind_result($id, $unitCode, $unitName);
							while($statement->fetch()){
								echo '<option value = "' . $unitCode . '">' . strtoupper('(' . $unitCode . ') ' . $unitName) . '</option>';
							}
						}else{
							echo '<option value = ""> -- NO UNITS FOUND FOR THIS COURSE -- </option>';
						}
						
					?>
					</select>
				</div>
				
				<div class = "form-group">
					<span for = "">ASSIGNMENT NAME</span>
					<input type = "text" class = "form-control" name = "assignmentName" value = "" required />
				</div>
				
				<div class = "form-group">
					<span for = "">DATE DUE</span>
					<input type = "text" class = "form-control" name = "dateDue" id = "dateDue" required />
				</div>
				
				<button name = "addAssignment" class = "btn btn-info" type = "submit">ADD ASSIGNMENT</button>
			</form>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
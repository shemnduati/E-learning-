<?php 
	$pageName = "addquiz";
	$output = '';
	$msg = '';
	
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['addQuiz'])){
		foreach($_POST as $key => $value){
			${$key} = $value;
		}
		
		$result = uploadFile('file');
		
		if($result['url']){
			$filePath = $result['url'];
			$query = "INSERT INTO quiz(quizName, courseId, unitCode,teacherId, filePath, dateSubmitted, dateDue) VALUES(?,?,?,?,?,NOW(),?)";
		
			$statement = $conn->prepare($query);
			$statement->bind_param('ssssss', $quizName, $teacherDetails['course'], $unitCode, $teacherDetails['id'], $filePath, $dateSubmitted);
			$statement->execute();
			$statement->store_result();
			
			if($statement->affected_rows > 0){
				$msg = 'quiz posted :)';
			}else{
				$msg = 'quiz not posted, please try again ' . mysqli_error($conn);
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
			<h3>ADD QUIZ</h3> 
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
					<span for = "">QUIZ NAME</span>
					<input type = "text" class = "form-control" name = "quizName" value = "" required />
				</div>
				
				<div class = "form-group">
					<span for = "">DATE DUE</span>
					<input type = "text" class = "form-control" name = "dateSubmitted" id = "dateDue" required />
				</div>
				
				<button name = "addQuiz" class = "btn btn-info" type = "submit">ADD QUIZ</button>
			</form>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
<?php 
	$pageName = "addMaterial";
	$output = '';
	$msg = '';
	
	require_once 'includes/core.inc.php';
	require_once 'includes/teacherSession.inc.php';
	
	if(isset($_POST['addMaterial'])){
		foreach($_POST as $key => $value){
			${$key} = $value;
		}
		
		$result = uploadFile('file');
		
		if($result['url']){
			$filePath = $result['url'];
			$query = "INSERT INTO materials(name, url, courseId) VALUES(?,?,?)";
		
			$statement = $conn->prepare($query);
			$statement->bind_param('sss', $materialName, $filePath, $teacherDetails['course']);
			$statement->execute();
			$statement->store_result();
			
			if($statement->affected_rows){
				$msg = 'Material added :)';
			}else{
				$msg = 'Material not added, please try again';
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
			<h3>ADD MATERIAL</h3> 
			<p><?php echo $msg;?> &nbsp;</p>
			<form action = "" method = "POST" enctype = "multipart/form-data">
				<div class = "form-group">
					<span for = "">FILE</span>
					<input type = "file" name = "file" required />
				</div>
				
				<div class = "form-group">
					<span for = "">MATERIAL NAME</span>
					<input type = "text" class = "form-control" name = "materialName" value = "" required />
				</div>
				
				<button name = "addMaterial" class = "btn btn-info" type = "submit">ADD MATERIAL</button>
			</form>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
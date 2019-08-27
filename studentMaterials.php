<?php 
	$pageName = "studentMaterials";
	$materialRows = '0';
	require_once 'includes/core.inc.php';
	require_once 'includes/studentSession.inc.php';
	
	$query = "SELECT id,name,url,date FROM materials WHERE courseId = ?";
	$statement = $conn->prepare($query);
	$statement->bind_param('s', $studentDetails['course']);
		
	if($statement->execute()){
		$statement->store_result();
		$output = '';
		
		if($statement->num_rows){
			$materialRows = $statement->num_rows;
			$statement->bind_result($id, $name, $url, $date);
			
			while($statement->fetch()){
				$output .= '<div class = "col-lg-3">
								<div class = "panel panel-info text-center">
									<div class = "panel-heading">' . strtoupper($name) . '</div>
									<div class = "panel-body">
										<p>DATE: ' . $date . '</p>
										<p><a href = "download.php?file=' . $url . '&name=' . strtoupper($name) . '" class = "btn btn-default">DOWNLOAD</a></p>
									</div>
								</div>
							</div>';
			}
		}else{
			$output = '<div class = "col-lg-12"><h3>No materials available</h3></div>';
		}
	}
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/studentSidebar.php';?>
		<div class = "col-lg-9"> 
			<h3>DOWNLOADABLE MATERIALS (<?php echo $materialRows;?>)</h3> 
			<div class = "row">
				<?php echo $output;?>
			</div>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
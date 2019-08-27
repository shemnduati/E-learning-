<!doctype html>
<html>
	<head>
		<title>ELEARNING</title>
		<meta charset = "utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel = "Shortcut Icon" type = "Image/X-icon" href = "favicon.ico" />
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/jquery-ui.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/jquery-ui.structure.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/custom-styles.css" />
		
		<script language = "Javascript" type = "text/javascript" src = "js/jquery-2.1.4.min.js"></script>
	</head>
	<body>
		<div class = "container">
			<nav class = "navbar navbar-default navbar-fixed-top">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					</div>
				<div class="collapse navbar-collapse" id="collapse1">
					<ul class="nav navbar-nav">
									
						
					</ul>
					
					<ul class="nav navbar-nav navbar-right" style = "padding-right:20px;" >
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<?php echo strtoupper($teacherDetails['fullName']);?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="addMaterial.php">ADD MATERIAL</a></li>
								<li><a href="addAssignment.php">ADD ASSIGNMENT</a></li>
								<li><a href="teacherHome.php">UNMARKED ASSIGNMENTS</a></li>
								<li><a href="addquiz.php">QUIZ</a></li>
								<li><a href="markedAssignments.php">MARKED ASSIGNMENTS</a></li>
								<li><a href="myAssignments.php">MY ASSIGNMENTS</a></li>
								<li><a href="logout.php">LOGOUT</a></li>
							</ul>
						</li>
						
					</ul>
				</div>
			</nav>
		</div>
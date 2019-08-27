<?php 
	$pageName = "studentMessages";
	require_once 'includes/core.inc.php';
	require_once 'includes/studentSession.inc.php';
	
	$msg = '';
	
	$sender = $studentDetails['id'];
	
	if(isset($_POST['createMessage'])){
		
		$required_fields = ['recepient' => 'Recepient','message' => 'Message'];
		$errors = array();
		
		foreach($required_fields as $field => $description){
			if(empty($_POST[$field]) || !isset($_POST[$field])){
				$errors[] = $description;
			}
		}
		
		if(empty($errors)){		
			$recepient = htmlentities($_POST['recepient']);
			$message = htmlentities($_POST['message']);
			
			$query = "INSERT INTO messages(sender, recepient, message)  VALUES(?,?,?)";
			$statement = $conn->prepare($query);
			$statement->bind_param('sss', $sender, $recepient, $message);
			
			if($statement->execute()){
					$statement->store_result();
					
					if($statement->affected_rows > 0){
						$msg = "Message sent";
					}
					
					else{
						$msg = "Message not sent";
					}
				
			}
			else{
				die(mysqli_error());
			}
			
		}
		
		else{
			$msg = 'Please fill in the following field(s) : ' . implode(', ' , $errors);
		}
		
	}
	
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'DELETE' && !empty($_GET['id']) && isset($_GET['id'])){
		$msgId = $_GET['id'];
		
		$query = "DELETE FROM messages WHERE id = ?";
		
		$statement = $conn->prepare($query);
		$statement->bind_param('s', $msgId);
		if($statement->execute()){
			$statement->store_result();
			
			if($statement->affected_rows > 0){
				$msg = "Message deleted";
			}
			
			else{
				$msg = "Message not deleted";
			}
		}
		
		else{
			$msg = mysqli_error($conn);
		}
	}
	
?>



<?php require_once 'includes/header.inc.php';?>

<div class = "container">
	<div class = "row" style = "margin-top:60px;">
		<?php require_once 'includes/studentSidebar.php';?>
		<div class = "col-lg-9"> 
			<h3>MESSAGES</h3> 
			<?php
				if(isset($_GET['action']) && $_GET['action'] == 'READ' && isset($_GET['id']) && !empty($_GET['id'])){
					require_once 'includes/messages/replyMessage.php';
				}
				
				elseif(isset($_GET['action']) && $_GET['action'] == 'CREATE'){
					require_once 'includes/messages/createMessage.php';
				}
				
				elseif(isset($_GET['action']) && $_GET['action'] == 'OUTBOX' || isset($_GET['page']) && $_GET['page'] == 'OUTBOX'){
					require_once 'includes/messages/outbox.php';
				}
				
				else{
					require_once 'includes/messages/inbox.php';
				}
			?>
		</div>
	</div>
</div>

<?php require_once 'includes/default_footer.inc.php';?>
<p><a href = "studentMessages.php" class = "btn btn-info">GO BACK</a></p>
<?php

	if(!empty($_GET['id']) && isset($_GET['id'])){
		$id = $_GET['id'];
		$msg = '';
	}

	else{
		redirectTo('studentMessages.php');
	}

	if(isset($_POST['replyMessage'])){
		$required_fields = ['recepient' => 'Recepient','message' => 'Message', 'sender' => 'Sender'];
		$errors = array();

		foreach($required_fields as $field => $description){
			if(empty($_POST[$field]) || !isset($_POST[$field])){
				$errors[] = $description;
			}
		}

		if(empty($errors)){
			$sender = htmlentities($_POST['sender']);
			$recepient = htmlentities($_POST['recepient']);
			$message = htmlentities($_POST['message']);

			$query = "INSERT INTO messages(sender, recepient, message)  VALUES(?,?,?)";
			$statement = $conn->prepare($query);
			$statement->bind_param('sss', $sender, $recepient, $message);

			if($statement->execute()){
					$statement->store_result();

					if($statement->affected_rows > 0){
						redirectTo('studentMessages.php');
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

	$query = "SELECT messages.id, messages.sender, messages.recepient ,messages.message, messages.dateCreated, messages.readStatus, students.fname, students.lname
			  FROM messages
			  LEFT JOIN students
			  ON messages.sender = students.id
			  WHERE (messages.id = ?)
			  ORDER BY messages.dateCreated DESC";

	$statement = $conn->prepare($query);
	$statement->bind_param('s', $id);

	if($statement->execute()){
		$statement->store_result();

		if($statement->num_rows > 0){
			$statement->bind_result($messageId, $messageSenderId, $messageRecepientId, $message, $dateCreated, $readStatus, $senderFname, $senderLname);

			while($statement->fetch()){
				$messageId = $messageId;
				$messageSenderId = $messageSenderId;
				$messageRecepientId = $messageRecepientId;
				$message = $message;
				$dateCreated = $dateCreated;
				$readStatus = $readStatus;
				$senderFname = $senderFname;
				$senderLname = $senderLname;

				$senderFullname = $senderFname . ' ' . $senderLname;
			}

			if($readStatus === 0){
				$q = "UPDATE messages SET readStatus = '1' WHERE id = ?";
				$stat = $conn->prepare($q);
				$stat->bind_param('s', $id);
				$stat->execute();
			}
		}
	}

?>


<div class = "thumbnail">
	<div class = "caption">
		<h4><?php echo $senderFullname?></h4>
		<p><?php echo $message?></p>
	</div>
</div>
<form action = "" method = "post">
	<p><?php echo $msg;?> &nbsp;</p>
	<div class = "form-group">
		<label for="message">Reply</label>

		<input name = "sender" type = "hidden" value = "<?php echo $messageRecepientId;?>" />
		<input name = "recepient" type = "hidden" value = "<?php echo $messageSenderId;?>" />
		<textarea name = "message" id = "message" class = "form-control" rows = 3></textarea>
	</div>

	<p style = "text-align:right"><button class = "btn btn-warning" name = "replyMessage">SEND</button></p>
</form>

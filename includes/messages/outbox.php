<p> <a href = "studentMessages.php" class = "btn btn-success">INBOX</a> <a href = "studentMessages.php?action=OUTBOX" class = "btn btn-success active">OUTBOX</a> <a href = "studentMessages.php?action=CREATE" class = "btn btn-info"> CREATE MESSAGE </a></p>
<p><?php echo $msg;?> &nbsp;</p>
<table class = "table table-bordered">
	<tr class = "active">
		<th>RECEPIENT</th>
		<th colspan = "2">MESSAGE</th>
		<th>DATE</th>
		<th></th>
	</tr>
	
	<?php
		$query = "SELECT messages.id, messages.sender ,messages.message, messages.dateCreated, students.fname, students.lname
				  FROM messages 
				  LEFT JOIN students 
				  ON messages.sender = students.id
				  WHERE (messages.sender = ?)
				  ORDER BY messages.dateCreated DESC";
		
		$statement = $conn->prepare($query);
		$statement->bind_param('s', $sender);
		
		if($statement->execute()){
			$statement->store_result();
			
			if($statement->num_rows > 0){
				$statement->bind_result($messageId, $messageSenderId, $message, $dateCreated, $senderFname, $senderLname);
				
				while($statement->fetch()){
					echo '<tr>
							<td>' . $senderFname . ' ' . $senderLname . '</td>
							<td colspan = "2">' . $message . '</td>
							<td>' . date('d-m-Y, h:i A', strtotime($dateCreated)) . '</td>
							<td style = "text-align:center;"><a title = "DELETE MESSAGE" href = "studentMessages.php?action=DELETE&page=OUTBOX&id=' . $messageId . '" class = "btn btn-sm btn-danger"> X </a></td>
						 </tr>';
				}
			}
			
			else{
				echo '<tr><td colspan = "5"> No messages yet</td></tr>';
			}
		}
		
		else{
			die(mysqli_error($conn));
		}
		
	?>
					
</table>
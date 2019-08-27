<p> <a href = "studentMessages.php" class = "btn btn-success active">INBOX</a> <a href = "studentMessages.php?action=OUTBOX" class = "btn btn-success">OUTBOX</a> <a href = "studentMessages.php?action=CREATE" class = "btn btn-info"> CREATE MESSAGE </a></p>
<p><?php echo $msg;?> &nbsp;</p>
<table class = "table table-bordered">
	<tr class = "active">
		<th>SENDER</th>
		<th colspan = "2">MESSAGE</th>
		<th>DATE</th>
		<th></th>
	</tr>


	<?php
		$query = "SELECT messages.id, messages.sender ,messages.message, messages.dateCreated, messages.readStatus, students.fname, students.lname
				  FROM messages
				  LEFT JOIN students
				  ON messages.sender = students.id
				  WHERE (messages.recepient = ?)
				  ORDER BY messages.dateCreated DESC";

		$statement = $conn->prepare($query);
		$statement->bind_param('s', $sender);

		if($statement->execute()){
			$statement->store_result();

			if($statement->num_rows > 0){
				$statement->bind_result($messageId, $messageSenderId, $message, $dateCreated, $readStatus, $senderFname, $senderLname);

				while($statement->fetch()){
					if($readStatus === 0){
							echo '<tr class = "info">';
					}else{
							echo '<tr>';
					}

						echo	'<td><a href = "studentMessages.php?action=READ&id=' . $messageId . '">' . $senderFname . ' ' . $senderLname . '</a></td>
									<td colspan = "2"><a href = "studentMessages.php?action=READ&id=' . $messageId . '">' . $message . '</a></td>
									<td><a href = "studentMessages.php?action=READ&id=' . $messageId . '">' . date('d-m-Y, h:i A', strtotime($dateCreated)) . '</a></td>
									<td style = "text-align:center;"><a title = "DELETE MESSAGE" href = "studentMessages.php?action=DELETE&id=' . $messageId . '" class = "btn btn-sm btn-danger"> X </a></td>
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

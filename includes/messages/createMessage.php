<form action = "" method = "post">
	<p> <a href = "studentMessages.php" class = "btn btn-success">INBOX</a> <a href = "studentMessages.php?action=OUTBOX" class = "btn btn-success">OUTBOX</a> <a href = "studentMessages.php?action=CREATE" class = "btn btn-info active"> CREATE MESSAGE </a></p>
	<p><?php echo $msg;?> &nbsp;</p>
	<div class = "form-group">
		<label for = "recepient">TO</label>
		<select name = "recepient" class = "form-control" id = "recepient">
			<option value = ""> - SELECT - </option>
			<?php
				$query = "SELECT id, fname, lname FROM students WHERE id != $sender";
				
				$statement = $conn->prepare($query);
				
				if($statement->execute()){
					$statement->store_result();
					
					if($statement->num_rows > 0){
						$statement->bind_result($id, $fname, $lname);
						
						while($statement->fetch()){
							echo '<option value = "' . $id . '">' . $fname . ' ' . $lname . '</option>';
						}
					}
				}
				
				else{
					die(mysqli_error($conn));
				}
			?>
		</select>
	</div>
	
	<div class = "form-group">
		<label for = "">MESSAGE</label>
		<textarea name = "message" class = "form-control" rows = "3" required></textarea>
	</div>
	<button type = "submit" class = "btn btn-warning" name = "createMessage"> SEND </button>
</form>
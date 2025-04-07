<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];
	$input_value = mysqli_real_escape_string($connection,$_POST['input_value']);

	$update_query = "UPDATE `transfer_property` SET  `status` = 'Disapproved', `comment` = ?, `disapproved_by_id` = ? WHERE id = ?";
	
	// Prepare the SQL query
	$stmt = mysqli_prepare($connection, $update_query);
	
	// Bind parameters: 'i' = integer, 's' = string
	mysqli_stmt_bind_param($stmt, 'sii', $input_value, $session_id, $id);
	
	// Execute the prepared statement
	mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
	
	// Close the prepared statement
	mysqli_stmt_close($stmt);
	
	echo 'success';
	
?>

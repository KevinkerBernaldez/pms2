<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	$update_query = "";

	if ($role == 'Property Custodian') {
		$update_query = "UPDATE `property_disposal` SET `checked_by_id` = ?, `checked_by` = ?, `checked_by_date` = NOW(), `status` = 'FOR PMO' WHERE id = ?";
	} 
	else if ($role == 'PMO Head') {
		$update_query = "UPDATE `property_disposal` SET `noted_by_id` = ?, `noted_by` = ?, `noted_by_date` = NOW(), `status` = 'FOR VP' WHERE id = ?";
	} 
	else if ($role == 'VP') {
		$update_query = "UPDATE `property_disposal` SET `approved_by_id` = ?, `approved_by` = ?, `approved_by_date` = NOW(), `status` = 'APPROVED' WHERE id = ?";
	} 
	
	// Prepare the SQL query
	$stmt = mysqli_prepare($connection, $update_query);
	
	// Bind parameters: 'i' = integer, 's' = string
	mysqli_stmt_bind_param($stmt, 'isi', $session_id, $name, $id);
	
	// Execute the prepared statement
	mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
	
	// Close the prepared statement
	mysqli_stmt_close($stmt);
	
	echo 'success';
	
?>

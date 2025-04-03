<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	$update_query = "";
	
	if ($role == 'PMO Head') {
		$update_query = "UPDATE `inspection` SET `verified_by_id` = ?, `verified_by` = ?, `verified_by_date` = NOW(), `status` = 'FOR VP' WHERE request_no = ?";
	} 
	else if ($role == 'VP') {
		$update_query = "UPDATE `inspection` SET `approved_by_id` = ?, `approved_by` = ?, `approved_by_date` = NOW(), `status` = 'APPROVED' WHERE request_no = ?";
	} 
	else {
		$update_query = "UPDATE `inspection` SET `conformed_by_id` = ?, `conformed_by` = ?, `conformed_by_date` = NOW(), `status` = 'FOR PMO' WHERE request_no = ?";
	}
	
	// Prepare the SQL query
	$stmt = mysqli_prepare($connection, $update_query);
	
	// Bind parameters: 'i' = integer, 's' = string
	mysqli_stmt_bind_param($stmt, 'iss', $session_id, $name, $id);
	
	// Execute the prepared statement
	mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
	
	// Close the prepared statement
	mysqli_stmt_close($stmt);
	
	echo 'success';
	
?>

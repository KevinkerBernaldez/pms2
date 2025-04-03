<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	$update_query = "";
	
	if ($role == 'Property Custodian') {
		$update_query = "UPDATE `property_inventory` SET `conformed_by_id` = ?, `conformed_by` = ?, `conformed_by_date` = NOW(), `status` = 'APPROVED' WHERE id = ?";
	}
	else {
		$update_query = "UPDATE `property_inventory` SET `in_charge_id` = ?, `in_charge` = ?, `in_charge_date` = NOW(), `status` = 'FOR PROPERTY CUSTODIAN' WHERE id = ?";
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

<?php
	require_once('../config.php');
	session_start();

	// Sanitize and retrieve inputs
	$id = isset($_POST['id']) ? mysqli_real_escape_string($connection, $_POST['id']) : null;
	$requestNo = isset($_POST['requestNo']) ? mysqli_real_escape_string($connection, $_POST['requestNo']) : null;
	$dateAction = isset($_POST['dateAction']) ? mysqli_real_escape_string($connection, $_POST['dateAction']) : null;

	// Get session variables
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	// Initialize query variable
	$update_query = "";

	// Prepare the query for Property Custodian
	if ($role == 'Property Custodian') {
		$update_query = "UPDATE `request_form` SET `request_no` = ?, `date_action` = ?, `endorsed_by_id` = ?, `endorsed_by` = ?, `endorsed_by_date` = NOW(), `status` = 'FOR PMO' WHERE id = ?";
		// Bind parameters for Property Custodian (request_no, date_action, endorsed_by_id, endorsed_by, id)
		$stmt = mysqli_prepare($connection, $update_query);
		mysqli_stmt_bind_param($stmt, 'ssiss', $requestNo, $dateAction, $session_id, $name, $id);
	} 
	else {
		// For PMO Head and VP
		if ($role == 'PMO Head') {
			$update_query = "UPDATE `request_form` SET `recommend_by_id` = ?, `recommend_by` = ?, `recommend_by_date` = NOW(), `status` = 'FOR VP' WHERE id = ?";
		} 
		else if ($role == 'VP') {
			$update_query = "UPDATE `request_form` SET `approved_by_id` = ?, `approved_by` = ?, `approved_by_date` = NOW(), `status` = 'APPROVED' WHERE id = ?";
		}

		// Prepare and bind for PMO Head and VP (recommend_by_id/approved_by_id, recommend_by/approved_by, id)
		$stmt = mysqli_prepare($connection, $update_query);
		mysqli_stmt_bind_param($stmt, 'iss', $session_id, $name, $id);
	}

	// Execute the prepared statement
	mysqli_stmt_execute($stmt) or die(mysqli_error($connection));

	// Close the prepared statement
	mysqli_stmt_close($stmt);

	// Output success message
	echo 'success';
?>

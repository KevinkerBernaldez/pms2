<?php
	require_once('../config.php');  
	session_start();

	// Sanitize inputs
	$status = mysqli_real_escape_string($connection, $_GET['status']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];
    $department_id = $_SESSION["department_id"];

	$query = "";

	// Prepare the query based on status and role
	if ($status == 'Pending') {
        // Role-specific queries for 'Pending' status
        if ($role == 'General Services') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id 
                        WHERE tp.`status` = 'FOR GENERAL SERVICES' ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'Property Custodian') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`status` = 'FOR PROPERTY CUSTODIAN' ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'PMO Head') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`status` = 'FOR PMO' ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'VP') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`status` = 'FOR VP' ORDER BY date_entry DESC; ";
        }
        else {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id 
                        WHERE tp.`status` = 'FOR USER' AND tp.move_to_id = '$department_id' ORDER BY date_entry DESC; ";
        }
    } 
    else {
        // Role-specific queries for statuses other than 'Pending'
        if ($role == 'General Services') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id 
                        WHERE tp.`checked_by_id` = ? ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'Property Custodian') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`endorsed_by_id` = ? ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'PMO Head') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`recommending_by_id` = ? ORDER BY date_entry DESC; ";
        } 
        else if ($role == 'VP') {
            $query = "SELECT tp.*, d.department FROM `transfer_property` tp 
                        JOIN departments d ON tp.move_to_id = d.id
                        WHERE tp.`approved_by_id` = ? ORDER BY date_entry DESC; ";
        }
    }
	
	// Prepare the SQL query
	$stmt = mysqli_prepare($connection, $query);

	if ($status != 'Pending') {
		// Bind the session_id parameter if the status is not 'Pending'
		mysqli_stmt_bind_param($stmt, 'i', $session_id);
	}

	// Execute the query
	mysqli_stmt_execute($stmt);

	// Get the result
	$result = mysqli_stmt_get_result($stmt);

	// Fetch all rows as an associative array
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Encode the result into a JSON string
	echo json_encode($rows);

	// Close the statement
	mysqli_stmt_close($stmt);

?>

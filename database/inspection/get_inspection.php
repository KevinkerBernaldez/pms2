<?php

    require_once('../config.php');  
    session_start();

	$status = mysqli_real_escape_string($connection, $_GET['status']);
    $session_id = $_SESSION["id"];
    $role = $_SESSION["role"];

    $query = "";

    if ($status == 'Pending') {
        if ($role == 'General Services') {
            $query = "SELECT rf.*, d.department FROM `request_form` rf
                        JOIN departments d ON rf.department = d.id  
                        WHERE rf.status = 'APPROVED' AND rf.is_inspected = 'No' ORDER BY date_entry DESC ";
        }
        else if ($role == 'PMO Head') {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.`status` = 'FOR PMO'; ";
        }
        else if ($role == 'VP') {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.`status` = 'FOR VP'; ";
        }
        else {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details, rf.requested_by_id FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.`status` = 'FOR USER' AND rf.`requested_by_id` = '$session_id'; ";
        }
    } 
    else {
        if ($role == 'General Services') {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.requested_by_id, rf.details as request_details FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.inspected_by_id = '$session_id'; ";
        }
        else if ($role == 'PMO Head') {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.verified_by_id = '$session_id'; ";
        }
        else if ($role == 'VP') {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.approved_by_id = '$session_id'; ";
        }
        else {
            $query = "SELECT i.*, request_type, d.department, date_requested, `location`, rf.details as request_details, rf.requested_by_id FROM `inspection` i
                        JOIN request_form rf ON i.request_no = rf.request_no
                        JOIN departments d ON rf.department = d.id
                        WHERE i.`conformed_by_id` = '$session_id'; ";
        }
    }

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    // mysqli_stmt_bind_param($stmt, 'i', $logsheet_id);

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
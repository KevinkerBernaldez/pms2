<?php

    require_once('../config.php');  
    session_start();

    $session_id = $_SESSION["id"];
    $role = $_SESSION["role"];

    $query = "";

    if ($role == 'General Services') {
        $query = "SELECT i.*, request_type, d.department, date_requested, location, rf.details as request_details, rf.is_feedback FROM `inspection` i
                    JOIN request_form rf ON i.request_no = rf.request_no
                    JOIN departments d ON rf.department = d.id
                    WHERE i.status = 'APPROVED' OR verified_by_id = ? ORDER BY date_entry DESC ";
    }
    else if ($role == 'PMO Head') {
        $query = "SELECT jo.*, rf.request_type, rf.location, rf.details, rf.is_feedback FROM job_order jo
                    JOIN departments d ON jo.department = d.id
                    JOIN request_form rf ON jo.request_no = rf.request_no
                    WHERE jo.`status` = 'FOR PMO' OR jo.approved_by_id = ?; ";
    }

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 'i', $session_id);

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
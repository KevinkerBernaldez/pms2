<?php

    require_once('../config.php');  

    $request_no = mysqli_real_escape_string($connection, $_GET['request_no']);

    $query = "SELECT
                    jo.*,
	                d.department,
                    t.signature AS technician_by_signature, 
                    u1.signature AS verified_by_signature, 
                    u2.signature AS approved_by_signature 
                FROM `job_order` jo
                JOIN departments d ON jo.department = d.id	
                LEFT JOIN technicians t ON jo.technician_by_id = t.id
                LEFT JOIN users u1 ON jo.verified_by_id = u1.id
                LEFT JOIN users u2 ON jo.approved_by_id = u2.id
                WHERE jo.request_no = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 's', $request_no);

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
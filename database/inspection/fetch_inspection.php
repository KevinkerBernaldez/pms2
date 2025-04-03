<?php

    require_once('../config.php');  

    $request_no = mysqli_real_escape_string($connection, $_GET['request_no']);

    $query = "SELECT 
                    i.*, 
                    rf.request_type, 
                    rf.request_type_others,
                    u1.signature AS inspected_by_signature, 
                    u2.signature AS conformed_by_signature, 
                    u3.signature AS verified_by_signature, 
                    u4.signature AS approved_by_signature 
                FROM `inspection` i
                JOIN request_form rf ON i.request_no = rf.request_no
                JOIN departments d ON rf.department = d.id
                LEFT JOIN users u1 ON i.inspected_by_id = u1.id
                LEFT JOIN users u2 ON i.conformed_by_id = u2.id
                LEFT JOIN users u3 ON i.verified_by_id = u3.id
                LEFT JOIN users u4 ON i.approved_by_id = u4.id
                WHERE i.request_no = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

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
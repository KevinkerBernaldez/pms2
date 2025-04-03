<?php

    require_once('../config.php');  

    $pr_no = mysqli_real_escape_string($connection, $_GET['pr_no']);

    $query = "SELECT 
                    w.*, 
                    l.pr_no, 
                    l.ws_no, 
                    l.quantity_released, 
                    l.unit, 
                    l.description,
                    u1.signature AS prepared_by_signature, 
                    u2.signature AS received_by_signature
                FROM 
                    withdrawal w
                JOIN 
                    logsheet l ON w.pr_no = l.pr_no
                LEFT JOIN 
                    users u1 ON w.prepared_by_id = u1.id
                LEFT JOIN 
                    users u2 ON w.received_by_id = u2.id
                WHERE w.pr_no = ? ; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 's', $pr_no);

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
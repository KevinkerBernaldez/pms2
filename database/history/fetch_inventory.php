<?php

    require_once('../config.php');  

    $inventory_id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT
                    i.*, 
                    u1.fname, 
                    u1.lname,
                    u1.signature AS accepted_by_signature
                FROM `inventory` i
                LEFT JOIN users u1 ON i.user_id = u1.id
                WHERE i.id = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 'i', $inventory_id);

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
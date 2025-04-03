<?php

    require_once('../config.php');  

    $inventory_id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT
                    pi.*, 
                    d.department,
                    u1.signature AS in_charge_by_signature, 
                    u2.signature AS conformed_by_signature
                FROM `property_inventory` pi
                JOIN departments d ON pi.department_id = d.id
                LEFT JOIN users u1 ON pi.in_charge_id = u1.id
                LEFT JOIN users u2 ON pi.conformed_by_id = u2.id
                WHERE pi.id = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
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
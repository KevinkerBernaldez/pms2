<?php

    require_once('../config.php');  
    session_start();

    $incharge_id = mysqli_real_escape_string($connection, $_GET['id']);
    $role = $_SESSION["role"];

    $query = "SELECT 
                    pi.*
                FROM `property_inventory` pi
                WHERE pi.in_charge_id = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 'i', $incharge_id);

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
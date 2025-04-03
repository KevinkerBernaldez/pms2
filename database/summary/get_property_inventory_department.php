<?php

    require_once('../config.php');  
    session_start();

    $department_id = mysqli_real_escape_string($connection, $_GET['department']);
    $month = mysqli_real_escape_string($connection, $_GET['month']);
    $year = mysqli_real_escape_string($connection, $_GET['year']);

    $query = "SELECT 
                    pi.in_charge, d.department, i.*
                FROM `property_inventory` pi
                JOIN departments d ON pi.department_id = d.id
                JOIN property_inventory_items i ON pi.id = i.property_inventory_id
                WHERE pi.department_id = ?
                    AND MONTH(pi.date_inventory) = ?
                    AND YEAR(pi.date_inventory) = ?
                ORDER BY pi.in_charge ASC; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    $stmt->bind_param("iii", $department_id, $month, $year); 

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
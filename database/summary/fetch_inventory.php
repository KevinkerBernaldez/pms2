<?php

    require_once('../config.php');  

    $in_charge = mysqli_real_escape_string($connection, $_GET['in_charge']);
    $month = mysqli_real_escape_string($connection, $_GET['month']);
    $year = mysqli_real_escape_string($connection, $_GET['year']);

    $query = "SELECT
                    pi.*, 
                    d.department
                FROM `property_inventory` pi
                JOIN departments d ON pi.department_id = d.id
                WHERE pi.in_charge_id = ?
                    AND MONTH(pi.date_inventory) = ?
                    AND YEAR(pi.date_inventory) = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 'iii', $in_charge, $month, $year);

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

<?php

    require_once('../config.php');  
    session_start();

    // $logsheet_id = mysqli_real_escape_string($connection, $_GET['logsheet_id']);
    $session_id = $_SESSION["id"];
    $role = $_SESSION["role"];

    $query = "";
    if ($role == 'Property Custodian') {
        $query = "SELECT pi.*, d.department, u.fname, u.lname FROM `property_inventory` pi 
            JOIN departments d ON pi.department_id = d.id
            JOIN users u ON pi.in_charge_id = u.id; ";
    }
    else {
        $query = "SELECT pi.*, d.department, u.fname, u.lname FROM `property_inventory` pi 
            JOIN departments d ON pi.department_id = d.id
            JOIN users u ON pi.in_charge_id = u.id
            WHERE pi.in_charge_id = '$session_id'; ";
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
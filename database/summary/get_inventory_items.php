<?php
    require_once('../config.php');  
    session_start();

    // Get parameters
    $in_charge = mysqli_real_escape_string($connection, $_GET['in_charge']);
    $month = mysqli_real_escape_string($connection, $_GET['month']);
    $year = mysqli_real_escape_string($connection, $_GET['year']);
    $session_id = $_SESSION["id"];

    // Define the query with placeholders for parameters
    $query = "SELECT pi.*, i.date_inventory FROM `property_inventory_items` pi
                JOIN property_inventory i ON pi.property_inventory_id = i.id
                WHERE user_id = ? 
                AND MONTH(date_inventory) = ? 
                AND YEAR(date_inventory) = ?;";

    // Prepare the statement
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

    // Encode the result into a JSON string and output it
    echo json_encode($rows);

    // Close the statement
    mysqli_stmt_close($stmt);
?>

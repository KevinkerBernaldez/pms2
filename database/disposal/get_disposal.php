<?php

    require_once('../config.php');  
    session_start();

    $session_id = $_SESSION["id"];
    $role = $_SESSION["role"];

    $query = "SELECT pd.* FROM `property_disposal` pd WHERE pd.`prepared_by_id` = ?; ";

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

	// Bind parameters: 'i' = integer, 's' = string
    mysqli_stmt_bind_param($stmt, 'i', $session_id);

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
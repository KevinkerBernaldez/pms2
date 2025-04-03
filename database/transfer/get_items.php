<?php

    require_once('../config.php');  
    session_start();

    $category = mysqli_real_escape_string($connection, $_GET['category']);
    $session_id = $_SESSION["id"];
    $role = $_SESSION["role"];

    $query = "";
    $query = "SELECT * FROM `inventory` i
                WHERE i.`item_category` = ? AND i.quantity != 0 AND i.user_id = ?; ";

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 'si', $category, $session_id);

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
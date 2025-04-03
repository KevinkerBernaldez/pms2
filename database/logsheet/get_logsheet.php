<?php

    require_once('../config.php');  
    
    $user_in_charge = mysqli_real_escape_string($connection, $_GET['user_in_charge']);
    $category = mysqli_real_escape_string($connection, $_GET['category']);
    $fromYear = mysqli_real_escape_string($connection, $_GET['fromYear']);
    $toYear = mysqli_real_escape_string($connection, $_GET['toYear']);

    $query = "SELECT l.*, u.fname, u.lname, u.signature, w.received_date FROM logsheet l
                LEFT JOIN withdrawal w ON w.pr_no = l.pr_no
                JOIN users u ON l.user_id = u.id
                WHERE user_id = ? AND item_category = ? AND YEAR(date_released) BETWEEN ? AND ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 'isii', $user_in_charge, $category, $fromYear, $toYear);

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
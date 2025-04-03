<?php

    require_once('../config.php');  

    $request_no = mysqli_real_escape_string($connection, $_GET['request_no']);

    $query = "SELECT
                    f.*,
                    u1.signature AS personnel_signature
                FROM `feedback` f
                LEFT JOIN users u1 ON f.personnel_id = u1.id
                WHERE f.request_no = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 's', $request_no);

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
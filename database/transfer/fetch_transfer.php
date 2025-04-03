<?php

    require_once('../config.php');  

    $disposal_id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT
                    tp.*, 
                    d.department,
                    u1.signature AS prepared_by_signature, 
                    u2.signature AS checked_by_signature,
                    u3.signature AS accepted_by_signature,
                    u4.signature AS endorsed_by_signature,
                    u5.signature AS recommending_by_signature,
                    u6.signature AS approved_by_signature
                FROM `transfer_property` tp
                JOIN departments d ON tp.move_to_id = d.id
                LEFT JOIN users u1 ON tp.prepared_by_id = u1.id
                LEFT JOIN users u2 ON tp.checked_by_id = u2.id
                LEFT JOIN users u3 ON tp.accepted_by_id = u3.id
                LEFT JOIN users u4 ON tp.endorsed_by_id = u4.id
                LEFT JOIN users u5 ON tp.recommending_by_id = u5.id
                LEFT JOIN users u6 ON tp.approved_by_id = u6.id
                WHERE tp.id = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 'i', $disposal_id);

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
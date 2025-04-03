<?php

    require_once('../config.php');  
    session_start();

    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $session_id = $_SESSION["id"];

    $query = "SELECT 
                    h.*,  
                    u1.signature AS accepted_by_signature
                FROM `history_record` h
                LEFT JOIN users u1 ON h.accepted_by_id = u1.id
                WHERE h.inventory_id = ?; ";

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);

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
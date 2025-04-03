<?php

    require_once('../config.php');  

    $request_no = mysqli_real_escape_string($connection, $_GET['request_no']);

    $query = "SELECT rf.*, 
                    d.department, 
                    u1.signature AS requested_by_signature, 
                    u2.signature AS endorsed_by_signature, 
                    u3.signature AS recommend_by_signature, 
                    u4.signature AS approved_by_signature
                FROM request_form rf
                JOIN departments d ON rf.department = d.id  
                LEFT JOIN users u1 ON rf.requested_by_id = u1.id
                LEFT JOIN users u2 ON rf.endorsed_by_id = u2.id
                LEFT JOIN users u3 ON rf.recommend_by_id = u3.id
                LEFT JOIN users u4 ON rf.approved_by_id = u4.id
                WHERE request_no = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    mysqli_stmt_bind_param($stmt, 'i', $request_no);

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
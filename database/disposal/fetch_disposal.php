<?php

    require_once('../config.php');  

    $disposal_id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT
                    pd.*,
                    u1.signature AS prepared_by_signature, 
                    u2.signature AS checked_by_signature,
                    u3.signature AS noted_by_signature,
                    u4.signature AS approved_by_signature
                FROM `property_disposal` pd
                LEFT JOIN users u1 ON pd.prepared_by_id = u1.id
                LEFT JOIN users u2 ON pd.checked_by_id = u2.id
                LEFT JOIN users u3 ON pd.noted_by_id = u3.id
                LEFT JOIN users u4 ON pd.approved_by_id = u4.id
                WHERE pd.id = ?; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

	// Bind parameters: 'i' = integer, 's' = string
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
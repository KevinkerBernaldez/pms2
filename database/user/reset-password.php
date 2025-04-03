<?php
    require_once('../config.php');
    session_start();

    try {
        // Sanitize and get POST values
        $id = $_POST['id'];

        // Generate a random temporary password
        $default_password = "pms2025";
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE `users` SET `password` = ? WHERE id = ?";
        $stmt = $connection->prepare($updateQuery);
        $stmt->bind_param("si", $hashed_password, $id);
        $stmt->execute();
        
        echo 'success';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        // Close the prepared statements
        if (isset($stmt)) $stmt->close();
    }
?>

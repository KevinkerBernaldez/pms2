<?php
    require_once ('../config.php');  
    session_start();

    // Get the old and new password from the POST request
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $session_id = $_SESSION["id"];

    // Prepare the query to select the current hashed password
    $query = $connection->prepare("SELECT `password` FROM users WHERE id = ?");
    $query->bind_param("i", $session_id);  // "i" for integer
    $query->execute();
    $query->store_result();
    $query->bind_result($hashed_password);
    $query->fetch();
    $query->close();

    // Check if the provided old password matches the stored hashed password
    if (password_verify($old_password, $hashed_password)) {
        // Hash the new password before updating the database
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare the update query to change the password
        $updateQuery = $connection->prepare("UPDATE `users` SET `password` = ? WHERE id = ?");
        $updateQuery->bind_param("si", $new_hashed_password, $session_id);  // "s" for string, "i" for integer
        $updateQuery->execute();
        $updateQuery->close();

        // Log the password change
        $logQuery = $connection->prepare("INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, 'Changed Password', NOW())");
        $logQuery->bind_param("i", $session_id);
        $logQuery->execute();
        $logQuery->close();

        echo 'success';
    } else {
        echo 'Invalid old password!';
    }
?>

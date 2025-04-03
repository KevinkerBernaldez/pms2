<?php
    require_once('../config.php');  
    session_start();
    
    // Sanitize input data
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
    $item = mysqli_real_escape_string($connection, $_POST['item']);
    $delivered_to = mysqli_real_escape_string($connection, $_POST['delivered_to']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $cv_number = mysqli_real_escape_string($connection, $_POST['cv_number']);
    $remarks = mysqli_real_escape_string($connection, $_POST['remarks']);
    
    $session_id = $_SESSION["id"]; // User ID from session
	$name = $_SESSION["name"];

    // Function to log actions (optional if you want to log the update/insertion)
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES ('$user_id', '$description', NOW())";
        mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    if ($id) {
        // Updating an existing logsheet entry, including user_id first
        $updateQuery = "UPDATE `logsheet` SET `is_signed` = 'Yes' WHERE `pr_no` = ?";

        // Prepare and execute update query
        $stmtUpdate = $connection->prepare($updateQuery);
        $stmtUpdate->bind_param("s", $id);
        $stmtUpdate->execute();

        // Log the action (optional if you want to log the update)
        log_action($session_id, 'Updated logsheet entry No. ' . $id, $connection);

        $insertQuery = "INSERT INTO `withdrawal` (`pr_no`, `item`, `delivered_to`, `date`, `cv`, `remarks`, `prepared_by_id`, `prepared_by`, `received_by_id`, `received_by`, `date_entry`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        // Prepare and execute the insert query
        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("ssssssisis", $id, $item, $delivered_to, $date, $cv_number, $remarks, $session_id, $name, $user_id, $user_name);  // Bind the parameter for the user_id (assuming it's an integer)
        $stmtInsert->execute();

        // Optionally log the insert action
        log_action($session_id, 'Inserted a new withdrawal entry', $connection);

        echo 'success';
    }

?>

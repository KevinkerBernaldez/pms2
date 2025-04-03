<?php
	require_once('../config.php');  
	session_start();
	
	// Sanitize input data
	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$department = mysqli_real_escape_string($connection, $_POST['department']);
	$session_id = $_SESSION["id"];


	// Function to log actions
	function log_action($user_id, $description, $connection) {
		$query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES ('$user_id', '$description', NOW())";
		mysqli_query($connection, $query) or die(mysqli_error($connection));
	}


    if ($id) {
        // Updating an existing department
        $status = mysqli_real_escape_string($connection, $_POST['status']);
        $updateQuery = "UPDATE `departments` SET `department` = ?, `status` = ? WHERE `id` = ?";

        // Prepare and execute update query
        $stmtUpdate = $connection->prepare($updateQuery);
        $stmtUpdate->bind_param("ssi", $department, $status, $id);
        $stmtUpdate->execute();

        // Log the action
        log_action($session_id, 'Updated department No. ' . $id, $connection);

        echo 'success';
    } else {
        // Adding a new department
        $status = "Active";  // Default status for new department
        $insertQuery = "INSERT INTO departments (`department`, `status`) VALUES(?, ?)";
        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("ss", $department, $status);
		
        $stmtInsert->execute();

        $lastInsertedId = $connection->insert_id;

        // Log the action
        log_action($session_id, "Added department No. " . $lastInsertedId, $connection);

        echo 'success';
    }

?>

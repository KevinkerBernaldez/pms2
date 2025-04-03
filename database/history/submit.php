<?php
    require_once('../config.php');  
    session_start();
    
    // Sanitize input data
    $inventory_id = mysqli_real_escape_string($connection, $_POST['inventory_id']);
    $other_details = mysqli_real_escape_string($connection, $_POST['other_details']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $job_order_no = mysqli_real_escape_string($connection, $_POST['job_order_no']);
    $problem = mysqli_real_escape_string($connection, $_POST['problem']);
    $action_taken = mysqli_real_escape_string($connection, $_POST['action_taken']);
    $date_completed = mysqli_real_escape_string($connection, $_POST['date_completed']);
    $conducted_by = mysqli_real_escape_string($connection, $_POST['conducted_by']);
    $session_id = $_SESSION["id"];

    // Function to log actions using prepared statements
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $user_id, $description);
        $stmt->execute();
    }

    $insertQuery = "INSERT INTO history_record (`inventory_id`, `type`, `date`, `job_order_no`, `problem`, `action_taken`, `date_completed`, `conducted_by`, `date_entry`) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmtInsert = $connection->prepare($insertQuery);
    $stmtInsert->bind_param("isssssss", $inventory_id, $type, $date, $job_order_no, $problem, $action_taken, $date_completed, $conducted_by);
    $stmtInsert->execute();
    
    $lastInsertedId = $connection->insert_id;

    // Update another table after the insert operation
    $updateQuery = "UPDATE inventory SET other_details = ? WHERE id = ?";

    $stmtUpdate = $connection->prepare($updateQuery);
    $stmtUpdate->bind_param("si", $other_details, $inventory_id);
    $stmtUpdate->execute();

    // Log the action
    log_action($session_id, "Added history record No. " . $lastInsertedId, $connection);

    echo 'success';
?>

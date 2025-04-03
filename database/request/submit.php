<?php
require_once('../config.php');  
session_start();

// Sanitize input data
// $request_no = mysqli_real_escape_string($connection, $_POST['request_no']);
$request_type = mysqli_real_escape_string($connection, $_POST['request_type']);
$request_type_others = mysqli_real_escape_string($connection, $_POST['request_type_others']);
$department = mysqli_real_escape_string($connection, $_POST['department']);
$date_requested = mysqli_real_escape_string($connection, $_POST['date_requested']);
$location = mysqli_real_escape_string($connection, $_POST['location']);
// $date_action = mysqli_real_escape_string($connection, $_POST['date_action']);
$details = mysqli_real_escape_string($connection, $_POST['details']);
$session_id = $_SESSION["id"];
$name = $_SESSION["name"];

// Function to log actions (refactored to use prepared statements)
function log_action($user_id, $description, $connection) {
    $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("is", $user_id, $description);
    $stmt->execute();
}

if (isset($_POST['id']) && $_POST['id'] != '') {
    // Updating an existing request entry
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    
    $updateQuery = "UPDATE `request_form` SET 
                        `request_no` = ?, 
                        `request_type` = ?, 
                        `request_type_others` = ?, 
                        `department` = ?, 
                        `date_requested` = ?, 
                        `location` = ?, 
                        `date_action` = ?
                    WHERE `id` = ?";

    // Prepare and execute update query
    $stmtUpdate = $connection->prepare($updateQuery);
    $stmtUpdate->bind_param("ssssssssi", $request_no, $request_type, $request_type_others, $department, $date_requested, $location, $date_action, $id);
    $stmtUpdate->execute();

    // Log the action (optional if you want to log the update)
    log_action($session_id, 'Updated request entry No. ' . $id, $connection);

    echo 'success';
} else {
    // Adding a new request entry
    $insertQuery = "INSERT INTO `request_form` 
                    (`request_type`, `request_type_others`, `department`, `date_requested`, `location`, `details`, `requested_by_id`, `requested_by`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtInsert = $connection->prepare($insertQuery);
    $stmtInsert->bind_param("ssssssis", $request_type, $request_type_others, $department, $date_requested, $location, $details, $session_id, $name);
    $stmtInsert->execute();

    $lastInsertedId = $connection->insert_id;

    // Log the action (optional if you want to log the insertion)
    log_action($session_id, "Added request entry No. " . $lastInsertedId, $connection);

    echo 'success';
}
?>

<?php
require_once('../config.php');  
session_start();

// Sanitize input data
$request_no = mysqli_real_escape_string($connection, $_POST['request_no']);
$date_inspected = mysqli_real_escape_string($connection, $_POST['date_inspected']);
$details = mysqli_real_escape_string($connection, $_POST['details']);
$session_id = $_SESSION["id"];
$name = $_SESSION["name"];

// Function to log actions (optional if you want to log the update/insertion)
function log_action($user_id, $description, $connection) {
    $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("is", $user_id, $description);
    $stmt->execute();
}

$updateQuery = "UPDATE `request_form` SET `is_inspected` = 'Yes' WHERE `request_no` = ?";

$stmtUpdate = $connection->prepare($updateQuery);
$stmtUpdate->bind_param("s", $request_no);
$stmtUpdate->execute();

// Insert into 'inspection' table (adapted)
$insertQuery = "INSERT INTO `inspection` 
                (`request_no`, `date_inspected`, `details`, `inspected_by_id`, `inspected_by`, `inspected_by_date`) 
                VALUES (?, ?, ?, ?, ?, NOW())";

$stmtInsert = $connection->prepare($insertQuery);
$stmtInsert->bind_param("sssis", $request_no, $date_inspected, $details, $session_id, $name);
$stmtInsert->execute();

$lastInsertedId = $connection->insert_id;

// Log the action (optional if you want to log the insertion)
log_action($session_id, "Added inspection entry No. " . $lastInsertedId, $connection);

echo 'success';
?>

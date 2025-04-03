<?php
    require_once('../config.php');  
    session_start();

    // Sanitize input data
    $request_no = mysqli_real_escape_string($connection, $_POST['request_no']);
    $repair_type = mysqli_real_escape_string($connection, $_POST['repair_type']);
    $date_repair = mysqli_real_escape_string($connection, $_POST['date_repair']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $transaction = mysqli_real_escape_string($connection, $_POST['transaction']);
    $remarks = mysqli_real_escape_string($connection, $_POST['remarks']);
    $technician = mysqli_real_escape_string($connection, $_POST['technician']);
    $tech_name = mysqli_real_escape_string($connection, $_POST['tech_name']);

    $session_id = $_SESSION["id"];
    $name = $_SESSION["name"];

    // Function to log actions (optional)
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $user_id, $description);
        $stmt->execute();
    }

    $updateQuery = "UPDATE `inspection` SET `with_job_order` = 'Yes' WHERE `request_no` = ?";

    $stmtUpdate = $connection->prepare($updateQuery);
    $stmtUpdate->bind_param("s", $request_no);
    $stmtUpdate->execute();

    // Insert query with only the provided variables
    $insertQuery = "INSERT INTO `job_order` 
                    (`request_no`, `repair_type`, `date_repair`, `department`, `transaction`, `remarks`, `technician_by_id`, `technician_by`, `technician_by_date`, `verified_by_id`, `verified_by`, `verified_by_date`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, NOW())";

    $stmtInsert = $connection->prepare($insertQuery);
    $stmtInsert->bind_param("ssssssisis", $request_no, $repair_type, $date_repair, $department, $transaction, $remarks, $technician, $tech_name, $session_id, $name);
    $stmtInsert->execute();

    $lastInsertedId = $connection->insert_id;

    // Log the action (optional)
    log_action($session_id, "Added job order entry No. " . $lastInsertedId, $connection);

    echo 'success';
?>

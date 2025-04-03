<?php
    require_once('../config.php');  
    session_start();

    // Sanitize input data
    $request_no = mysqli_real_escape_string($connection, $_POST['request_no']);
    $office = mysqli_real_escape_string($connection, $_POST['office']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $service_type = mysqli_real_escape_string($connection, $_POST['service_type']);
    $service_type_others = mysqli_real_escape_string($connection, $_POST['service_type_others']);
    $jf_one = mysqli_real_escape_string($connection, $_POST['jf_one']);
    $jf_two = mysqli_real_escape_string($connection, $_POST['jf_two']);
    $jf_three = mysqli_real_escape_string($connection, $_POST['jf_three']);
    $jf_four = mysqli_real_escape_string($connection, $_POST['jf_four']);
    $jf_five = mysqli_real_escape_string($connection, $_POST['jf_five']);
    $remarks = mysqli_real_escape_string($connection, $_POST['remarks']);

    $session_id = $_SESSION["id"];
    $name = $_SESSION["name"];
    $average_jf = ((float)$jf_one + (float)$jf_two + (float)$jf_three + (float)$jf_four + (float)$jf_five) / 5;

    // Function to log actions (refactored to use prepared statements)
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $user_id, $description);
        $stmt->execute();
    }

    // Adding a new request entry
    $insertQuery = "INSERT INTO `feedback` 
                    (`request_no`, `office`, `date`, `position`, `service`, `service_others`, `jf_one`, `jf_two`, `jf_three`, `jf_four`, `jf_five`, `average_rate`, `remarks`, `personnel_id`, `personnel`, `date_entry`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmtInsert = $connection->prepare($insertQuery);
    $stmtInsert->bind_param("sssssssssssssis", 
        $request_no, $office, $date, $position, $service_type, $service_type_others, $jf_one, $jf_two, $jf_three, $jf_four, $jf_five, $average_jf, $remarks, $session_id, $name);
    $stmtInsert->execute();

    $lastInsertedId = $connection->insert_id;

    $updateQuery = "UPDATE `request_form` SET `is_feedback` = 'Yes' WHERE `request_no` = ?";

    // Prepare and execute update query
    $stmtUpdate = $connection->prepare($updateQuery);
    $stmtUpdate->bind_param("s", $request_no);
    $stmtUpdate->execute();

    // Log the action (optional if you want to log the insertion)
    log_action($session_id, "Added feedback entry No. " . $lastInsertedId, $connection);

    echo 'success';
?>
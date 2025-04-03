<?php
    require_once('../config.php');  
    session_start();
    
    // Sanitize input data
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $mname = mysqli_real_escape_string($connection, $_POST['mname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $session_id = $_SESSION["id"];

    // Function to log actions
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $user_id, $description);
        $stmt->execute();
    }

    $imageaccept = ["jpg", "png", "jpeg"];
    $path = "";
    
    if(isset($_FILES['file']) && $_FILES['file']['tmp_name'] != '') {
        $ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
        
        if (in_array($ext, $imageaccept)) {
            $path = strtotime(date('y-m-d H:i')).'_signature.'.$ext;
            $move = move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/signature/'.$path);

            // Use prepared statement for update
            $updateQuery = "UPDATE `technicians` SET `signature` = ? WHERE id = ?";
            $stmtUpdate = $connection->prepare($updateQuery);
            $stmtUpdate->bind_param("si", $path, $id);
            $stmtUpdate->execute();
        } else { 
            echo "File not accepted! \nAllowed formats: ".implode(", ", $imageaccept);
            exit();
        }
    }

    if ($id) {
        // Updating an existing technician
        $status = mysqli_real_escape_string($connection, $_POST['status']);
        $updateQuery = "UPDATE `technicians` SET `fname` = ?, `mname` = ?, `lname` = ?, `status` = ? WHERE `id` = ?";

        // Prepare and execute update query
        $stmtUpdate = $connection->prepare($updateQuery);
        $stmtUpdate->bind_param("ssssi", $fname, $mname, $lname, $status, $id);
        $stmtUpdate->execute();

        // Log the action
        log_action($session_id, 'Updated technician No. ' . $id, $connection);

        echo 'success';
    } else {
        // Adding a new technician
        $status = "Active";  // Default status for new technician
        if ($path != '') {
            // Prepared statement for insert with signature
            $insertQuery = "INSERT INTO technicians (`fname`, `mname`, `lname`, `status`, `signature`) VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $connection->prepare($insertQuery);
            $stmtInsert->bind_param("sssss", $fname, $mname, $lname, $status, $path);
        } else {
            // Prepared statement for insert without signature
            $insertQuery = "INSERT INTO technicians (`fname`, `mname`, `lname`, `status`) VALUES (?, ?, ?, ?)";
            $stmtInsert = $connection->prepare($insertQuery);
            $stmtInsert->bind_param("ssss", $fname, $mname, $lname, $status);
        }

        $stmtInsert->execute();

        $lastInsertedId = $connection->insert_id;

        // Log the action
        log_action($session_id, "Added technician No. " . $lastInsertedId, $connection);

        echo 'success';
    }
?>

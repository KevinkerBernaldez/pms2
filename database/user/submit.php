<?php
    require_once('../config.php');  
    session_start();
    
    // Sanitize input data
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $mname = mysqli_real_escape_string($connection, $_POST['mname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $session_id = $_SESSION["id"];

    $hashed_password = password_hash("pms2025", PASSWORD_DEFAULT);

    // Function to log actions using prepared statements
    function log_action($user_id, $description, $connection) {
        $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $user_id, $description);
        $stmt->execute();
    }

    $imageaccept = ["jpg", "png", "jpeg"];
    $path = "";

    // Step 1: Insert user data first
    $status = "Active";  // Default status for new user

    if ($id) {
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        // Updating an existing user
        $updateQuery = "UPDATE `users` SET `fname` = ?, `mname` = ?, `lname` = ?, department_id = ?, `username` = ?, `role` = ?, `status` = ? WHERE `id` = ?";

        $stmtUpdate = $connection->prepare($updateQuery);
        $stmtUpdate->bind_param("sssisssi", $fname, $mname, $lname, $department, $username, $role, $status, $id);
        $stmtUpdate->execute();
        // Log the action
        log_action($session_id, 'Updated user No. ' . $id, $connection);
    } else {
        // Adding a new user
        $insertQuery = "INSERT INTO users (`fname`, `mname`, `lname`, `department_id`, `username`, `role`, `avatar`, `status`, `password`) 
                        VALUES(?, ?, ?, ?, ?, ?, 'uploads/profile/user.png', ?, ?)";

        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("sssissss", $fname, $mname, $lname, $department, $username, $role, $status, $hashed_password);
        $stmtInsert->execute();
        
        $lastInsertedId = $connection->insert_id;

        // Log the action
        log_action($session_id, "Added user No. " . $lastInsertedId, $connection);
    }

    // Step 2: Upload file and update user signature
    if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != '') {
        $ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

        if (in_array($ext, $imageaccept)) {
            $path = strtotime(date('y-m-d H:i')).'_signature.'.$ext;

            // Upload the file
            if (move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/signature/'.$path)) {

                // Update user signature with the uploaded file path
                if ($id) {
                    // Update existing user's signature
                    $updateSignatureQuery = "UPDATE `users` SET `signature` = ? WHERE id = ?";
                    $stmtUpdateSignature = $connection->prepare($updateSignatureQuery);
                    $stmtUpdateSignature->bind_param("si", $path, $id);
                    $stmtUpdateSignature->execute();
                } else {
                    // Update new user's signature
                    $updateSignatureQuery = "UPDATE `users` SET `signature` = ? WHERE id = ?";
                    $stmtUpdateSignature = $connection->prepare($updateSignatureQuery);
                    $stmtUpdateSignature->bind_param("si", $path, $lastInsertedId);
                    $stmtUpdateSignature->execute();
                }
            } else {
                echo "File upload failed!";
                exit();
            }
        } else {
            echo "File not accepted! Allowed formats: ".implode(", ", $imageaccept);
            exit();
        }
    }

    echo 'success';
?>

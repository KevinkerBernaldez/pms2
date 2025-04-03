<?php
    require_once('config.php');  
    session_start();

    $username = $_GET["username"];
    $password = $_GET["password"];
    
    // Prepared statement to select user by username
    $query = $connection->prepare("SELECT u.*, d.id AS department_id, d.department FROM users u
                                    JOIN departments d ON u.department_id = d.id
                                    WHERE username = ?");
    
    // Bind the parameter to the prepared statement
    $query->bind_param("s", $username); // "s" denotes that the parameter is a string
    
    // Execute the query
    $query->execute();
    
    // Get the result
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Verify the password with password_verify
        if (password_verify($password, $row['password'])) {

            $user_status = $row['status'];
            $id = $row['id'];
            $_SESSION["id"] = $row["id"];
            $_SESSION["fname"] = $row["fname"];
            $_SESSION["lname"] = $row["lname"];
            $_SESSION["name"] = $row["fname"] . ' ' . $row["lname"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["avatar"] = $row["avatar"];
            $_SESSION["department_id"] = $row["department_id"];
            $_SESSION["department"] = $row["department"];

            // Log the login attempt
            $log_query = $connection->prepare("INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES(?, 'Logged In', NOW())");
            $log_query->bind_param("i", $id); // "i" denotes that the parameter is an integer
            $log_query->execute();

            // Check if the account is active
            if ($user_status == 'Active') {
                echo 'success';
            } else {
                echo 'User account deactivated! Please contact system administrator for further assistance.';
            }

        } else {
            echo "Incorrect Username or Password entered. \nPlease try again.";
        }
    } else {
        echo "Incorrect Username or Password entered. \nPlease try again.";
    }

    // Close the prepared statement
    $query->close();
?>

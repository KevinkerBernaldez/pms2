<?php
    require_once ('../config.php');  
    session_start();
	header("Content-Type: application/json");

	$session_id = $_SESSION["id"];
    $data = json_decode($_POST['data'], true);
    $transfer_id = mysqli_real_escape_string($connection, $_POST['transfer_id']);
    $disapprove_id = mysqli_real_escape_string($connection, $_POST['disapprove_id']);
    
	if (json_last_error() === JSON_ERROR_NONE) {

        $stmt1 = $connection->prepare("UPDATE transfer_property_items SET quantity = ?, unit = ?, `description` = ?, brand = ?,
                                            part_code = ?, model_number = ?, serial_number = ?, `status` = ? WHERE id = ?");

        foreach ($data as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];
            $unit = $item['unit'];
            $description = $item['description'];
            $brand = $item['brand'];
            $part_code = $item['part_code'];
            $model_number = $item['model_number'];
            $serial_number = $item['serial_number'];
            $status = $item['status'];

            // Bind the parameters for the update query
            $stmt1->bind_param('isssssssi', $quantity, $unit, $description, $brand, $part_code, $model_number, $serial_number, $status, $id);
            $stmt1->execute();
        }

       // Close the prepared statements
        $stmt1->close();

        // Get the role from the users table based on disapprove_id
        $query = "SELECT `role` FROM users WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $disapprove_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $role);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Prepare the update query based on the role
        $update_query = "";
        switch ($role) {
            case 'General Services':
                $update_query = "UPDATE `transfer_property` SET `status` = 'FOR GENERAL SERVICES' WHERE id = ?";
                break;
            case 'Property Custodian':
                $update_query = "UPDATE `transfer_property` SET `status` = 'FOR PROPERTY CUSTODIAN' WHERE id = ?";
                break;
            case 'PMO Head':
                $update_query = "UPDATE `transfer_property` SET `status` = 'FOR PMO' WHERE id = ?";
                break;
            case 'VP':
                $update_query = "UPDATE `transfer_property` SET `status` = 'FOR VP' WHERE id = ?";
                break;
        }

        // Execute the update query
        $stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($stmt, 'i', $transfer_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

	} else {
		// Handle JSON decoding error
		echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
	}

?>
<?php
    require_once ('../config.php');  
    session_start();
	header("Content-Type: application/json");

	$session_id = $_SESSION["id"];
    $data = json_decode($_POST['data'], true);
    $disposal_id = mysqli_real_escape_string($connection, $_POST['disposal_id']);
    $disapprove_id = mysqli_real_escape_string($connection, $_POST['disapprove_id']);
    
	if (json_last_error() === JSON_ERROR_NONE) {

        $stmt1 = $connection->prepare("UPDATE property_disposal_items SET quantity = ?, unit = ?, `description` = ?, property_code = ?,
                                            brand = ?, part_code = ?, conditioned = ? WHERE id = ?");

        foreach ($data as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];
            $unit = $item['unit'];
            $description = $item['description'];
            $property_code = $item['property_code'];
            $brand = $item['brand'];
            $part_code = $item['part_code'];
            $conditioned = $item['conditioned'];

            // Bind the parameters for the update query
            $stmt1->bind_param('issssssi', $quantity, $unit, $description, $property_code, $brand, $part_code, $conditioned, $id);
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
            case 'Property Custodian':
                $update_query = "UPDATE `property_disposal` SET `status` = 'FOR PROPERTY CUSTODIAN' WHERE id = ?";
                break;
            case 'PMO Head':
                $update_query = "UPDATE `property_disposal` SET `status` = 'FOR PMO' WHERE id = ?";
                break;
            case 'VP':
                $update_query = "UPDATE `property_disposal` SET `status` = 'FOR VP' WHERE id = ?";
                break;
        }

        // Execute the update query
        $stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($stmt, 'i', $disposal_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

	} else {
		// Handle JSON decoding error
		echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
	}

?>
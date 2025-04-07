<?php
    require_once ('../config.php');  
    session_start();
	header("Content-Type: application/json");

	$session_id = $_SESSION["id"];
	$name = $_SESSION["name"];
	$department = $_SESSION["department"];

	$requestBody = file_get_contents("php://input");

	$data = json_decode($requestBody, true);
	$sql = "";

	if (json_last_error() === JSON_ERROR_NONE) {
		$date = $data['date'];
		$transfer_location = $data['transfer_location'];
		$turnover_pmo = $data['turnover_pmo'];
		$department_id = $data['department'];
		$others = $data['others'];
		$user_in_charge = $data['user_in_charge'];
		$category = $data['category'];
		$item_name = $data['item_name'];
		$myArray = $data['data'];

		$alreadyExists = false;
        $existingRecord = null;

        $insertQuery = "INSERT INTO `transfer_property` (`date`, `move_from`, `move_to_id`, `item_category`, `is_transfer`, `is_turnover`, `others`, `prepared_by_id`, `prepared_by`, `date_entry`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        // Prepare and execute the insert query
        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("ssissssis", $date, $department, $department_id, $category, $transfer_location, $turnover_pmo, $others, $session_id, $name); 
        $stmtInsert->execute();
        $lastInsertedId = $connection->insert_id;

        $stmt1 = $connection->prepare("INSERT INTO transfer_property_items (`transfer_id`, `inventory_id`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // $stmt2 = $connection->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");

        // DELETE query for when quantity becomes 0
        // $stmt4 = $connection->prepare("DELETE FROM inventory WHERE id = ?");

        // $stmt3 = $connection->prepare("INSERT INTO inventory (`user_id`, `item_category`, `pr_no`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`) 
        //     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($myArray as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];
            $unit = $item['unit'];
            $description = $item['description'];
            $brand = $item['brand'];
            $part_code = $item['part_code'];
            $model_number = $item['model_number'];
            $serial_number = $item['serial_number'];
            $status = $item['status'];
            $pr_number = $item['pr_number'];

            // Bind the parameters for the insert query
            $stmt1->bind_param('iiisssssss', $lastInsertedId, $id, $quantity, $unit, $description, $brand, $part_code, $model_number, $serial_number, $status);
            $stmt1->execute();

            // Bind the parameters for the update query
            // $stmt2->bind_param('ii', $quantity, $id);
            // $stmt2->execute();
            
            // After the update, check if the quantity is now 0
            // $result = $connection->query("SELECT quantity FROM inventory WHERE id = $id");
            // $row = $result->fetch_assoc();
            // if ($row['quantity'] == 0) {
                // If quantity is 0, delete the row
                // $stmt4->bind_param('i', $id);
                // $stmt4->execute();
            // }

            // Bind the parameters for the insert query
            // $stmt3->bind_param('ississsssss', $user_in_charge, $category, $pr_number, $quantity, $unit, $description, $brand, $part_code, $model_number, $serial_number, $status);
            // $stmt3->execute();

        }

       // Close the prepared statements
        $stmt1->close();
        // $stmt2->close();
        // $stmt3->close();
        // $stmt4->close();

        echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

	} else {
		// Handle JSON decoding error
		echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
	}

?>
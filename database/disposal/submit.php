<?php
    require_once ('../config.php');  
    session_start();
	header("Content-Type: application/json");

	$session_id = $_SESSION["id"];
	$name = $_SESSION["name"];
	$department = $_SESSION["department"];

    $date = $_POST['date'];
    $category = $_POST['category'];
    $item_name = $_POST['item_name'];
    $data = json_decode($_POST['data'], true);
    
	$sql = "";
    $path = "";
    $imageaccept = ['pdf'];

	if (json_last_error() === JSON_ERROR_NONE) {
        if(isset($_FILES['file'])) {
            $ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            
            if (in_array($ext, $imageaccept)) {
                $path = strtotime(date('y-m-d H:i')).'_incident_report.'.$ext;
                $move = move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/incident_report/'.$path);
            } else { 
                echo "File not accepted! \nAllowed formats: ".implode(", ", $imageaccept);
                exit();
            }
        }

		$alreadyExists = false;
        $existingRecord = null;

        $insertQuery = "INSERT INTO `property_disposal` (`date`, `department`, `item_category`, `prepared_by_id`, `prepared_by`, `file`, `date_entry`) 
                            VALUES (?, ?, ?, ?, ?, ?, NOW())";

        // Prepare and execute the insert query
        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("sssiss", $date, $department, $category, $session_id, $name, $path); 
        $stmtInsert->execute();
        $lastInsertedId = $connection->insert_id;

        $stmt1 = $connection->prepare("INSERT INTO property_disposal_items (`disposal_id`, `quantity`, `unit`, `description`, `property_code`, `brand`, `part_code`, `conditioned`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt2 = $connection->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");

        foreach ($data as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];
            $unit = $item['unit'];
            $description = $item['description'];
            $property_code = $item['property_code'];
            $brand = $item['brand'];
            $part_code = $item['part_code'];
            $conditioned = $item['conditioned'];

            // Bind the parameters for the insert query
            $stmt1->bind_param('iissssss', $lastInsertedId, $quantity, $unit, $description, $property_code, $brand, $part_code, $conditioned);
            $stmt1->execute();

            // Bind the parameters for the update query
            $stmt2->bind_param('ii', $quantity, $id);
            $stmt2->execute();

        }

       // Close the prepared statements
        $stmt1->close();
        $stmt2->close();

        echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

	} else {
		// Handle JSON decoding error
		echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
	}

?>
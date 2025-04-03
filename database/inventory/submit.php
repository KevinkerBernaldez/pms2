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
    $date_inventory = $data['date_inventory'];
    $date_last_inventory = $data['date_last_inventory'];
    $property_code = $data['property_code'];
    $department_id = $data['department_id'];
    $sy = $data['sy'];
    $area = $data['area'];
    $in_charge_id = $data['in_charge_id'];
    $in_charge = $data['in_charge'];
    $category = $data['category'];
    $item_name = $data['item_name'];
    $myArray = $data['data'];

    // Check database connection
    if (!$connection) {
        die(json_encode(["status" => "error", "message" => "Database connection failed."]));
    }

    // Prepare insert query for property_inventory
    $insertQuery = "INSERT INTO `property_inventory` (`date_inventory`, `date_last`, `property_code`, `department_id`, `item_category`, `sy`, `area`, `in_charge_id`, `in_charge`, `date_entry`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmtInsert = $connection->prepare($insertQuery);
    if (!$stmtInsert) {
        die(json_encode(["status" => "error", "message" => "Failed to prepare insert query."]));
    }

    $stmtInsert->bind_param("sssisssis", $date_inventory, $date_last_inventory, $property_code, $department_id, $category, $sy, $area, $in_charge_id, $in_charge); 
    $stmtInsert->execute();
    $lastInsertedId = $connection->insert_id;

    // Prepare update query for inventory
    $stmt1 = $connection->prepare("UPDATE inventory 
                                    SET `brand` = ?, `part_code` = ?, `model_number` = ?, `serial_number` = ?, `status` = ? 
                                    WHERE `id` = ?");
    if (!$stmt1) {
        die(json_encode(["status" => "error", "message" => "Failed to prepare update query."]));
    }

    // Prepare insert query for property_inventory_items
    $stmt2 = $connection->prepare("INSERT INTO `property_inventory_items` (`property_inventory_id`, `user_id`, `item_category`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`, `date_entry`) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    if (!$stmt2) {
        die(json_encode(["status" => "error", "message" => "Failed to prepare insert query for property_inventory_items."]));
    }

    // Iterate over each item
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
        $remarks = $item['remarks'];

        // Update inventory
        $stmt1->bind_param('sssssi', $brand, $part_code, $model_number, $serial_number, $status, $id);
        $stmt1->execute();
        
        // Insert item into property_inventory_items
        $stmt2->bind_param('iissssssssss', $lastInsertedId, $in_charge_id, $category, $quantity, $unit, $description, $brand, $part_code, $model_number, $serial_number, $status, $remarks);
        $stmt2->execute();
    }

    // Close the prepared statements
    $stmt1->close();
    $stmt2->close();

    echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

} else {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
}
?>

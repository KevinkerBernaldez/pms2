<?php
require_once('../config.php');  
session_start();

$session_id = $_SESSION["id"];

$requestBody = file_get_contents("php://input");

$data = json_decode($requestBody, true);

if (json_last_error() === JSON_ERROR_NONE) {
    $pr_no = $data['pr_no'];
    $category = $data['category'];
    $date_purchase = $data['date_purchase'];
    $user_id = $data['user_id'];
    $myArray = $data['data'];

    // Prepare the queries
    $stmt1 = $connection->prepare("INSERT INTO `logsheet` (`user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity_received`, `unit`, `description`, `date_released`, `ws_no`, `quantity_released`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2 = $connection->prepare("INSERT INTO `inventory` (`user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity`, `unit`, `description`, `date_released`, `ws_no`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Loop through items
    foreach ($myArray as $item) {
        // Extract item data
        $quantity_received = $item['quantity_received'];
        $unit = $item['unit'];
        $description = $item['description'];
        $date_released = $item['date_released'];
        $ws_no = $item['ws_no'];
        $quantity_released = $item['quantity_released'];

        // Bind parameters for the first insert query (logsheet)
        $stmt1->bind_param("sssssssssi", $user_id, $category, $pr_no, $date_purchase, $quantity_received, $unit, $description, $date_released, $ws_no, $quantity_released);
        $stmt1->execute();

        // Bind parameters for the second insert query (inventory)
        $stmt2->bind_param("sssssssss", $user_id, $category, $pr_no, $date_purchase, $quantity_received, $unit, $description, $date_released, $ws_no);
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

// Function to log actions (optional if you want to log the update/insertion)
function log_action($user_id, $description, $connection) {
    $query = "INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES ('$user_id', '$description', NOW())";
    mysqli_query($connection, $query) or die(mysqli_error($connection));
}

?>

<?php
    require_once ('../config.php');  
    session_start();
	header("Content-Type: application/json");

	$session_id = $_SESSION["id"];
    $data = json_decode($_POST['data'], true);
    
	if (json_last_error() === JSON_ERROR_NONE) {

        $stmt1 = $connection->prepare("UPDATE property_disposal_items SET remarks = ? WHERE id = ?");

        foreach ($data as $item) {
            $id = $item['id'];
            $remark = $item['remark'];

            // Bind the parameters for the update query
            $stmt1->bind_param('si', $remark, $id);
            $stmt1->execute();
        }

       // Close the prepared statements
        $stmt1->close();

        echo json_encode(["status" => "success", "message" => "Records inserted successfully"]);

	} else {
		// Handle JSON decoding error
		echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
	}

?>
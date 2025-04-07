<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	$update_query = "";

	if ($role == 'Property Custodian') {
		$update_query = "UPDATE `property_disposal` SET `checked_by_id` = ?, `checked_by` = ?, `checked_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'FOR PMO' WHERE id = ?";
	} 
	else if ($role == 'PMO Head') {
		$update_query = "UPDATE `property_disposal` SET `noted_by_id` = ?, `noted_by` = ?, `noted_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'FOR VP' WHERE id = ?";
	} 
	else if ($role == 'VP') {
		$update_query = "UPDATE `property_disposal` SET `approved_by_id` = ?, `approved_by` = ?, `approved_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'APPROVED' WHERE id = ?";
	
		$select_query = "SELECT * FROM `property_disposal_items` WHERE disposal_id = ?";

		// Prepare statement
		if ($stmt = $connection->prepare($select_query)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();

			// Get result
			$result = $stmt->get_result();
			
			// Fetch all data from the result set
			$items = [];
			while ($row = $result->fetch_assoc()) {
				$items[] = $row;

				// Get the inventory_id and quantity from the current row
				$inventory_id = $row['inventory_id'];
				$quantity_to_deduct = $row['quantity']; // Adjust this field name as needed

				// Deduct quantity in the inventory table
				$deduct_inventory_query = "UPDATE `inventory` SET `quantity` = `quantity` - ? WHERE `id` = ?";
				
				// Prepare the deduct query
				if ($stmt_deduct = $connection->prepare($deduct_inventory_query)) {
					$stmt_deduct->bind_param("ii", $quantity_to_deduct, $inventory_id);
					$stmt_deduct->execute();
					$stmt_deduct->close();
				} else {
					throw new Exception("Failed to prepare deduct query: " . $connection->error);
				}
			}

			// Close the statement
			$stmt->close();
		} else {
			throw new Exception("Failed to prepare select query: " . $connection->error);
		}


	} 
	
	// Prepare the SQL query
	$stmt = mysqli_prepare($connection, $update_query);
	
	// Bind parameters: 'i' = integer, 's' = string
	mysqli_stmt_bind_param($stmt, 'isi', $session_id, $name, $id);
	
	// Execute the prepared statement
	mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
	
	// Close the prepared statement
	mysqli_stmt_close($stmt);
	
	echo 'success';
	
?>

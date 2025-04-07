<?php
	require_once('../config.php');  
	session_start();

	$id = mysqli_real_escape_string($connection, $_POST['id']);
	$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
	$session_id = $_SESSION["id"];
	$role = $_SESSION['role'];
	$name = $_SESSION['name'];

	$update_query = "";
	
	if ($role == 'General Services') {
		$update_query = "UPDATE `transfer_property` SET `checked_by_id` = ?, `checked_by` = ?, `checked_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'FOR USER' WHERE id = ?";
	} 
	else if ($role == 'Property Custodian') {
		$update_query = "UPDATE `transfer_property` SET `endorsed_by_id` = ?, `endorsed_by` = ?, `endorsed_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'FOR PMO' WHERE id = ?";
	} 
	else if ($role == 'PMO Head') {
		$update_query = "UPDATE `transfer_property` SET `recommending_by_id` = ?, `recommending_by` = ?, `recommending_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'FOR VP' WHERE id = ?";
	} 
	else if ($role == 'VP') {
		$update_query = "UPDATE `transfer_property` SET `approved_by_id` = ?, `approved_by` = ?, `approved_by_date` = NOW(), `disapproved_by_id` = null, comment = '', `status` = 'APPROVED' WHERE id = ?";
		
		$select_query = "SELECT * FROM `transfer_property_items` WHERE transfer_id = ?";

		// Prepare statement
		if ($stmt = $connection->prepare($select_query)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();

			// Get result for transfer_property_items
			$result = $stmt->get_result();
			
			// Fetch all data from the result set
			$items = [];
			while ($row = $result->fetch_assoc()) {
				// Debugging output for each row
				$items[] = $row;

				// Get the inventory_id and quantity from the current row
				$inventory_id = $row['inventory_id'];
				$quantity_to_deduct = $row['quantity']; // Adjust this field name as needed

				// Step 1: Get all data of the inventory item before performing any update or deletion
				$get_inventory_data_query = "SELECT * FROM `inventory` WHERE `id` = ?";
				if ($stmt_get_inventory = $connection->prepare($get_inventory_data_query)) {
					$stmt_get_inventory->bind_param("i", $inventory_id);
					$stmt_get_inventory->execute();

					// Get result for inventory data
					$inventory_result = $stmt_get_inventory->get_result();
					if ($inventory_data = $inventory_result->fetch_assoc()) {
						// Step 2: Insert a new entry into the inventory table based on fetched data
						$insert_inventory_query = "INSERT INTO inventory (`user_id`, `item_category`, `pr_no`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`) 
												VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						
						if ($stmt_insert_inventory = $connection->prepare($insert_inventory_query)) {
							$item_category = $inventory_data['item_category'];
							$pr_no = $inventory_data['pr_no'];
							$quantity = $quantity_to_deduct;
							$unit = $inventory_data['unit'];
							$description = $inventory_data['description'];
							$brand = $inventory_data['brand'];
							$part_code = $inventory_data['part_code'];
							$model_number = $inventory_data['model_number'];
							$serial_number = $inventory_data['serial_number'];
							$status = $inventory_data['status'];

							$stmt_insert_inventory->bind_param("ississsssss", 
								$user_id, 
								$item_category, 
								$pr_no, 
								$quantity, 
								$unit, 
								$description, 
								$brand, 
								$part_code, 
								$model_number, 
								$serial_number, 
								$status
							);
							$stmt_insert_inventory->execute();
							$stmt_insert_inventory->close();
						}
					}

					$stmt_get_inventory->close();
				}

				// Step 3: Deduct quantity from the inventory table
				$deduct_inventory_query = "UPDATE `inventory` SET `quantity` = `quantity` - ? WHERE `id` = ?";
				if ($stmt_deduct = $connection->prepare($deduct_inventory_query)) {
					$stmt_deduct->bind_param("ii", $quantity_to_deduct, $inventory_id);
					$stmt_deduct->execute();

					// After deduction, check if quantity becomes 0
					if ($stmt_deduct->affected_rows > 0) {
						$check_quantity_query = "SELECT `quantity` FROM `inventory` WHERE `id` = ?";
						if ($stmt_check = $connection->prepare($check_quantity_query)) {
							$stmt_check->bind_param("i", $inventory_id);
							$stmt_check->execute();
							$result_check = $stmt_check->get_result();

							if ($row_check = $result_check->fetch_assoc()) {
								if ($row_check['quantity'] == 0) {
									// If quantity is 0, delete the inventory row
									$delete_inventory_query = "DELETE FROM `inventory` WHERE `id` = ?";
									if ($stmt_delete = $connection->prepare($delete_inventory_query)) {
										$stmt_delete->bind_param("i", $inventory_id);
										$stmt_delete->execute();
										$stmt_delete->close();
									}
								}
							}
							$stmt_check->close();
						}
					}

					$stmt_deduct->close();
				}
			}

			// Close the statement
			$stmt->close();
		} else {
			throw new Exception("Failed to prepare select query: " . $connection->error);
		}

	}
	else {
		$update_query = "UPDATE `transfer_property` SET `accepted_by_id` = ?, `accepted_by` = ?, `accepted_by_date` = NOW(), `status` = 'FOR PROPERTY CUSTODIAN' WHERE id = ?";
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

<?php
	require_once ('../config.php');  
	session_start();

	$id = $_SESSION["id"];
	$fname = mysqli_real_escape_string($connection, $_POST['fname']);
	$lname = mysqli_real_escape_string($connection, $_POST['lname']);

	$imageaccept = ["jpg", "png", "jpeg"];

	if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != '') {
		$ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

		if (in_array($ext, $imageaccept)) {
			$path = strtotime(date('y-m-d H:i')).'_profile.'.$ext;
			$move = move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/profile/'.$path);

			// Use a prepared statement for updating avatar
			$updateAvatarQuery = $connection->prepare("UPDATE `users` SET `avatar` = ? WHERE id = ?");
			$updateAvatarQuery->bind_param("si", $path, $id);
			$updateAvatarQuery->execute();
			$updateAvatarQuery->close();

			// Update the session avatar
			$_SESSION['avatar'] = $path;
		} else { 
			echo "File not accepted! \nAllowed formats: ".implode(", ", $imageaccept);
			exit();
		}
	}

	// Use a prepared statement for updating the first name, last name, and logging the change
	$updateProfileQuery = $connection->prepare("UPDATE `users` SET `fname` = ?, `lname` = ? WHERE id = ?");
	$updateProfileQuery->bind_param("ssi", $fname, $lname, $id);
	$updateProfileQuery->execute();
	$updateProfileQuery->close();

	// Insert the log entry
	$insertLogQuery = $connection->prepare("INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES (?, 'Update Profile', NOW())");
	$insertLogQuery->bind_param("i", $id);
	$insertLogQuery->execute();
	$insertLogQuery->close();

	// Update the session variables
	$_SESSION["fname"] = $fname;
	$_SESSION["lname"] = $lname;

	echo 'success';
?>

<?php
	require_once('config.php');
	session_start();
	$id = $_SESSION["id"];
	$stmt = $connection->prepare("INSERT INTO logs (`user_id`, `logs_desc`, date_entry) VALUES(?, 'Logged Out', NOW())");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	session_destroy();
	echo '<script type="text/javascript">window.location = "../index.php";</script>';
?>

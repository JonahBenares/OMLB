<?php
	include 'includes/connection.php';

	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	/*$today = date('Y-m-d');*/
	$date_performed	= date('Y-m-d',strtotime($_POST['date_performed']));
	mysqli_query($con,"INSERT INTO logs (date_performed, main_id, sub_id, item_id, notes, performed_by,logged_by,date_logged) VALUES ('$date_performed', '$cat_name', '$sub_name', '$item_name', '$notes', '$performed_by', '$logged_by',NOW())");
	echo json_encode($log_id);
?>
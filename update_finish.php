<?php 
	include("includes/connection.php");
	date_default_timezone_set("Asia/Manila");
	session_start();
	$userid=$_SESSION['userid'];
	$date_finished=date('Y-m-d H:i:s');
	mysqli_query($con,"UPDATE log_head SET status = '$_POST[status]', date_finish = '$date_finished',  finished_by = '$userid' WHERE log_id = '$_POST[id]'");
?>
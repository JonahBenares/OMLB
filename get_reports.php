<?php 
	include 'includes/connection.php';
	if(isset($_GET['mo'])){
		$sql = mysqli_query($con,"SELECT date_performed FROM logs WHERE log_id");
		$row = mysqli_fetch_array($sql);
	}
?>
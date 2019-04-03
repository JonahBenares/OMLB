<?php 
	include 'includes/connection.php';
	include'header.php';
	if(!empty($_POST["id"])) {
		$id=$_POST['id'];
		$userid = $_SESSION['userid'];
		$userdeleteTL = $con->query("DELETE FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
		$userdelete = $con->query("DELETE FROM tmp_attachment_logs WHERE log_id = '$id'");
	}
?>
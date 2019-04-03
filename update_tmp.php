<?php 
	include 'includes/connection.php';
	include'header.php';
	if(!empty($_POST["id"])) {
		$id=$_POST['id'];
		$userid = $_SESSION['userid'];
		$update = $con->query("UPDATE tmp_log_head SET date_performed = '$date_performed', time_performed = '$time_performed', due_date = '$due_date', notes = '$notes', performed_by = '$performed_by', status = '$status' WHERE log_id = '$id' AND logged_by = '$userid'");
		/*$con->query("INSERT INTO tmp_log_head (date_performed, time_performed, due_date, notes, performed_by, status) VALUES ('date_performed','time_performed','due_date','notes','performed_by','status')");*/
	}
	/*$userdeleteTL = $con->query("DELETE FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");*/
?>
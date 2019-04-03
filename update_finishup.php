<?php 
	include("includes/connection.php");
		mysqli_query($con,"UPDATE log_head SET status = '$_POST[status]' WHERE log_id = '$_POST[id]'");
?>
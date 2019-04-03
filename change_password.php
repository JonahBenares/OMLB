<?php
	include'includes/connection.php';
	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	
	$sql = mysqli_query($con,"SELECT password FROM users where employee_id = '$id'");
	$row = mysqli_fetch_array($sql);


	if ($old_password == $row['password']){

		$ss = md5($password);
		mysqli_query($con,"UPDATE users SET password = '$ss' WHERE employee_id = $id");
		echo '<script>alert("Password successfully changed");window.close();</script>';
	}
	elseif (md5($old_password) == $row['password']) {

		$ss = md5($password);
		mysqli_query($con,"UPDATE users SET password = '$ss' WHERE employee_id = $id");
		echo'<script>alert("Password successfully changed");window.close();</script>';
	}
	else{ ?>
		<script>alert("Incorrect Old Password");
		window.location = "change_password_modal.php?id=<?php echo $id;?>"</script>
	<?php } ?>


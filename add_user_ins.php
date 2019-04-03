<?php
	include 'includes/connection.php';

	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$query=mysqli_query($con,"SELECT * from users where username = '$username'");
	$row = mysqli_fetch_array($query);
	$num_rows = mysqli_num_rows($query);
	if ($num_rows<>0){
		echo "<script type='text/javascript'>alert('Sorry! This username is already taken! You may now login!');</script>";
		echo "<script>document.location='add_new_user.php';</script>";
	}
	else if($password != $confirm_password){
		echo "<script type='text/javascript'>alert('Password Not Match!');</script>";
		echo "<script>document.location='add_new_user.php';</script>";
	}
	else {
		mysqli_query($con,"INSERT INTO users(fullname, username, password, usertype_id) VALUES ('$fullname','$username','$password','2')");
		echo "<script type='text/javascript'>alert('Successfully Registered!');</script>";
		echo "<script>document.location='add_new_user.php';</script>";

	}
?>
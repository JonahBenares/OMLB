<?php
	include 'includes/connection.php';

	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$query=mysqli_query($con,"SELECT * from department where department_name = '$department_name'");
	$row = mysqli_fetch_array($query);
	$num_rows = mysqli_num_rows($query);
	if ($num_rows<>0){
		echo "<script type='text/javascript'>alert('Sorry! This Department is already in the System!');</script>";
		echo "<script>document.location='add_new_department.php';</script>";
	}
	else {
		mysqli_query($con,"INSERT INTO department(department_name) VALUES ('$department_name')");
		echo "<script type='text/javascript'>alert('Successfully Added!');</script>";
		echo "<script>document.location='add_new_department.php';</script>";

	}
?>
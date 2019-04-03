<?php
	include 'includes/connection.php';

	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$query=mysqli_query($con,"SELECT * FROM employees WHERE employee_name = '$employee_name' AND position = '$position' AND department_id = '$department'");
	$num_rows = mysqli_num_rows($query);
	$row = mysqli_fetch_array($query);
	if ($num_rows<>0){
		echo "<script type='text/javascript'>alert('This Employee is already in the system');</script>";
		echo "<script>document.location='add_new_emp.php';</script>";
	}
	else {
		$query=mysqli_query($con,"SELECT * from users where username = '$username'");
		$row = mysqli_fetch_array($query);
		$num_rows = mysqli_num_rows($query);
		if ($num_rows<>0){
			echo "<script type='text/javascript'>alert('Sorry! This username is already taken! You may now login!');</script>";
			echo "<script>document.location='add_new_emp.php';</script>";
		}
		else {
			if($username==""){
				echo "<script type='text/javascript'>alert('Username must not be empty!');</script>";
				echo "<script>document.location='add_new_emp.php';</script>";
			}
			else if($password != $confirm_password){
				echo "<script type='text/javascript'>alert('Password Not Match!');</script>";
				echo "<script>document.location='add_new_emp.php';</script>";
			} else {
				$getEmp = mysqli_query($con, "SELECT MAX(employee_id) as maxid FROM employees");
				$fetchEmp = mysqli_fetch_array($getEmp);
				$empid = $fetchEmp['maxid']+1;


				mysqli_query($con,"INSERT INTO employees (employee_id, access, employee_name, position, department_id) VALUES ('$empid','$access', '$employee_name','$position','$department')");
				if($access==1){
					mysqli_query($con,"INSERT INTO users(fullname, username, password, usertype_id, employee_id) VALUES ('$employee_name','$username','$password','2','$empid')");
				}
				
				echo "<script type='text/javascript'>alert('Successfully Registered!');</script>";
				echo "<script>document.location='add_new_emp.php';</script>";
			}

		}

		

	}
?>
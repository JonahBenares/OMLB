<?php 
	include'includes/connection.php';
	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);

	$sql = mysqli_query($con,"UPDATE employees SET employee_name = '$employee_name', position = '$position', department_id = '$department', access = '$access' WHERE employee_id = '$id'") or die(mysqli_error($con));
	if($access == 1){
		$insert = mysqli_query($con,"INSERT INTO users (employee_id, fullname,username, password, usertype_id) VALUES('$id','$employee_name','$username','$password','2')");
	}else if($access == 0){
		$delete = mysqli_query($con,"DELETE FROM users WHERE employee_id = '$id'");
	}
	echo "<script type='text/javascript'>alert('Successfully Updated!');</script>";
	echo "<script>window.location='add_new_emp.php'</script>";
?>
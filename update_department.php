<?php 
	include'includes/connection.php';
	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$sql = mysqli_query($con,"UPDATE department SET department_name = '$department_name' WHERE department_id = '$id'") or die(mysqli_error($con));
	echo "<script type='text/javascript'>alert('Successfully Updated!');</script>";
	echo "<script>window.location='add_new_department.php'</script>";
?>
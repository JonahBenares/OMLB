<?php
include 'includes/connection.php';
if(!empty($_POST["employee_name"])) {
	$query =$con->query("SELECT employee_name FROM employees WHERE employee_name LIKE '%".$_POST["employee_name"]."%'");
	$result = $query->num_rows;
	if(!empty($result)) {
	?>
	<ul id="name-user">
	<?php
	while($fetch = mysqli_fetch_array($query)){
		$employee_name = $fetch["employee_name"];
	?>
	<li onClick="selectEmp('<?php echo $employee_name; ?>');"><?php echo $employee_name; ?></li>
	<?php } ?>
	</ul>
<?php 
	} 
} ?>
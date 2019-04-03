<?php
include 'includes/connection.php';
if(!empty($_POST["department_name"])) {
	$query =$con->query("SELECT department_name FROM department WHERE department_name LIKE '%".$_POST["department_name"]."%'");
	$result = $query->num_rows;
	if(!empty($result)) {
	?>
	<ul id="name-department">
	<?php
	while($fetch = mysqli_fetch_array($query)){
		$department_name = $fetch["department_name"];
	?>
	<li onClick="selectDepartment('<?php echo $department_name; ?>');"><?php echo $department_name; ?></li>
	<?php } ?>
	</ul>
<?php 
	} 
} ?>

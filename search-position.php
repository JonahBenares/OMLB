<?php
include 'includes/connection.php';
if(!empty($_POST["position"])) {
	$query =$con->query("SELECT DISTINCT(position) AS pos FROM employees WHERE position LIKE '%".$_POST["position"]."%'");
	$result = $query->num_rows;
	if(!empty($result)) {
	?>
	<ul id="name-user">
	<?php
	while($fetch = mysqli_fetch_array($query)){
		$position = $fetch["pos"];
	?>
	<li onClick="selectPosition('<?php echo $position; ?>');"><?php echo $position; ?></li>
	<?php } ?>
	</ul>
<?php 
	} 
} ?>

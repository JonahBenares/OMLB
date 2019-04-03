<?php
require_once("includes/connection.php");
$id = mysql_real_escape_string($_POST['id']);
if($id!='')
{
$sub_result = $con->query('select * from sub_system where main_id='.$id.'');
$options = "<option visited disabled selected>Select Sub System Category</option>";
while($row = $sub_result->fetch_assoc()) {
$options .= "<option value='".$row['sub_id']."'>".$row['subsys_name']."</option>";
}
echo $options;
}?>



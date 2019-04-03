<?php
require_once("includes/connection.php");
$id = mysql_real_escape_string($_POST['id']);
if($id!='')
{
$item_result = $con->query('select * from item where sub_id='.$id.'');
$options = "<option value=''>Select Item Name Category</option>";
while($row1 = $item_result->fetch_assoc()) {
$options .= "<option value='".$row1['item_id']."'>".$row1['item_name']."</option>";
}
echo $options;
}?>



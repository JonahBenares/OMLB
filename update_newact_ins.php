<?php
include 'includes/connection.php';
date_default_timezone_set("Asia/Manila");
session_start();
$userid = $_SESSION['userid'];
	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$sql1 = mysqli_query($con,"SELECT MAX(update_id) as updateid FROM update_logs");
	$row1 = mysqli_fetch_array($sql1);
	$max = $row1['updateid'] + 1;

	$sql2 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM log_head");
	$row2 = mysqli_fetch_array($sql2);
	$log = $row2['logid'];

	$sql3 = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
	$rows = mysqli_num_rows($sql3);
	if($rows == 1){
		mysqli_query($con,"UPDATE log_head SET status = '$status' WHERE log_id = '$id'");
		$time_performed = $hour.':'.$minutes;
		mysqli_query($con,"INSERT INTO update_logs (log_id,date_performed,time_performed,notes,equip_type_model,prob_find,work_desc,act_taken,parts_replaced,performed_by,status,logged_by,logged_date,date_finish) VALUES ('$id','$date_performed','$time_performed','$notes','$equip_type_model','$prob_find','$work_desc','$act_taken','$parts_replaced','$performed_by','$status','$userid',NOW(),NOW())");
	}	

	$sql = mysqli_query($con,"SELECT * FROM update_logs ORDER BY update_id DESC");
	$fetch = $sql->fetch_array();
	$upattach = $fetch['update_id'];
	$logid = $fetch['log_id'];
	if(!isset($counterX) || $counterX == ''){
		$ctrx = $counter;
	} 
	else{
		$ctrx = $counterX;
	}

	for($x=1; $x<=$ctrx;$x++){
		$a="attach_file".$x;
		if(!empty($_FILES[$a]["name"])){
			$activity = $_FILES[$a]['tmp_name'];
			$act = $_FILES[$a]["name"];
			$name = 'attach_name'.$x;
			$aname=$$name;
			$a = explode(".", $act); //certificate file
			$ext = $a[1];
			$afile = $upattach."_".$logid."_".$userid.$x.".".$ext;
			move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
			$update=mysqli_query($con,"INSERT INTO update_attachment (log_id,update_id,attach_file,attach_name) VALUES ('$log','$max','$afile','$aname')");
		}
	}
	/*echo "<script type='text/javascript'>alert('Files successfully saved!');</script>";
	echo '<script>document.location.href="update_rec.php?id='.$id.'"</script>';*/
?>
<?php
include 'includes/connection.php';
date_default_timezone_set("Asia/Manila");
	foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	$sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM log_head");
	$row1 = mysqli_fetch_array($sql1);
	$max = $row1['logid'] + 1;
   	$time_performed = $hour.':'.$minutes;

   	if($status=='Done') $date_finish = date('Y-m-d H:i:s');
   	else $date_finish = '';
   	$now = date('Y-m-d H:i:s');
	mysqli_query($con,"INSERT INTO log_head (log_id,date_performed,time_performed,unit,main_system,sub_system,notes,performed_by,status,logged_by,due_date,logged_date,date_finish, finished_by) VALUES ('$max','$date_performed','$time_performed','$unit','$main_id','$sub_id','$notes','$performed_by','$status','$logged_by','$due_date','$now','$date_finish','$logged_by')");

	$sql = mysqli_query($con,"SELECT performed_by From log_head ORDER BY log_id ASC");
	$fetch = $sql->fetch_array();
	$fname = $fetch['performed_by'];
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
			$a = explode(".", $act); //attach file
			$ext = $a[1];
			$afile = $fname."_".$aname.$x.".".$ext;;
			move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
			$update=mysqli_query($con,"INSERT INTO attachment_logs (log_id,attach_file,attach_name) VALUES ('$max','$afile','$aname')");
		}
	}
	echo "<script type='text/javascript'>alert('Files successfully saved!');</script>";
	echo '<script>document.location="home.php"</script>';
?>
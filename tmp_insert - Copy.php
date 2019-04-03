<?php 
	include 'includes/connection.php';
	include'header.php';
	if(!empty($_POST["id"])){
		$id = $_POST['id'];
		foreach($_POST as $var=>$value)
		$$var = mysqli_real_escape_string($con, $value);
		$userid = $_SESSION['userid'];
		$sql = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
		$rows = mysqli_num_rows($sql);
		$sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM log_head");
		$row1 = mysqli_fetch_array($sql1);
		$max = $row1['logid'] + 1;
		if($rows == 0){
			$insert = mysqli_query($con,"INSERT INTO log_head (log_id,date_performed,time_performed,unit,main_system,sub_system,notes,performed_by,status,logged_by,due_date,logged_date,date_finish) VALUES ('$max','$date_performed','$time_performed','$unit','$main_id','$sub_id','$notes','$performed_by','$status','$logged_by','$due_date',NOW(),NOW())");
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
		}
		$deleteLH = $con->query("DELETE FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
		$deleteAL = $con->query("DELETE FROM tmp_attachment_logs WHERE log_id = '$id' AND logged_by = '$userid'");
		echo '<script>alert("Successfully Saved!");</script>';
		echo '<script>window.close();</script>';
	}
?>
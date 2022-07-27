<?php
include 'includes/connection.php';
//include 'header.php';
session_start();
$userid= $_SESSION['userid'];

    foreach($_POST as $var=>$value)
    $$var = mysqli_real_escape_string($con,$value);
	
	/*echo json_encode($unit);
    echo json_encode($main_id);
    echo json_encode($sub_id);
    echo json_encode($date_performed);
    echo json_encode($hour);
    echo json_encode($minutes);
    echo json_encode($due_date);
    echo json_encode($notes);
    echo json_encode($performed_by);
    echo json_encode($status);
    echo json_encode($attach_file1);
    echo json_encode($attach_name1);*/
	
    $sql = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE logged_by = '$userid'");
    $rows = mysqli_num_rows($sql);

    $sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM tmp_log_head");
    $row1 = mysqli_fetch_array($sql1);
    $max = $row1['logid'] + 1;
    $time_performed = $hour.':'.$minutes;
    $sql5 = mysqli_query($con,"SELECT MAX(log_id) as logid From log_head");
    $fetch = $sql5->fetch_array();
    $logid = $fetch['logid']+1;
    if($status=='Done') {
        $date_finish = date('Y-m-d H:i:s');
    }else{ 
        $date_finish = '';
    }
    
    if($rows == 0){
        $insert= $con->query("INSERT INTO tmp_log_head (log_id,date_performed,time_performed,unit,main_system,sub_system,notes,equip_type_model,prob_find,work_desc,act_taken,parts_replaced,performed_by,status,logged_by,due_date,logged_date,date_finish) VALUES ('$max','$date_performed','$time_performed','$unit','$main_id','$sub_id','$notes','$equip_type_model','$prob_find','$work_desc','$act_taken','$parts_replaced','$performed_by','$status','$userid','$due_date', NOW(), '$date_finish')");
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
                $afile = $logid."_".$userid.$x.".".$ext;;
                move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
                $update=mysqli_query($con,"INSERT INTO tmp_attachment_logs (log_id,attach_file,attach_name) VALUES ('$max','$afile','$aname')");
               /* echo json_encode("INSERT INTO tmp_attachment_logs (log_id,attach_file,attach_name) VALUES ('$max','$afile','$aname')");*/
            }
        }  
    } else {
        $update = mysqli_query($con,"UPDATE tmp_log_head SET date_performed = '$date_performed', time_performed = '$time_performed', due_date = '$due_date', notes = '$notes', equip_type_model = '$equip_type_model', prob_find = '$prob_find', work_desc = '$work_desc', act_taken = '$act_taken', parts_replaced = '$parts_replaced', performed_by = '$performed_by', status = '$status' WHERE logged_by = '$userid'");
       
          if(!isset($counterX) || $counterX == ''){
            $ctrx = $counter;
        } 
        else{
            $ctrx = $counterX;
        }
        
        $sql6 = mysqli_query($con,"SELECT log_id From tmp_log_head WHERE logged_by = '$userid'");
        $fetch1 = $sql6->fetch_array();
        $logid1 = $fetch1['log_id'];

        $getattach = $con->query("SELECT log_id FROM tmp_attachment_logs WHERE log_id = '$logid1'");
        $rows_att=$getattach->num_rows;
       
       
        if($rows_att==$ctrx){
            for($x=1; $x<=$ctrx;$x++){
                $a="attach_file".$x;
                $name = 'attach_name'.$x;
                $aname=$$name;
                $attid = 'attach_id'.$x;
                $attachid=$$attid;
                if(!empty($_FILES[$a]["name"])){
                    $activity = $_FILES[$a]['tmp_name'];
                    $act = $_FILES[$a]["name"];
                    
                    $a = explode(".", $act); //attach file
                    $ext = $a[1];
                    $afile = $logid."_".$userid.$x.".".$ext;
                    move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
                    $update=mysqli_query($con,"UPDATE tmp_attachment_logs SET attach_file = '$afile', attach_name='$aname' WHERE attach_id='$attachid'");
                }
                if(!empty($aname)){
                      $update=mysqli_query($con,"UPDATE tmp_attachment_logs SET attach_name='$aname' WHERE attach_id='$attachid'");
                     

                }
            }
        } else {
            
            for($x=1; $x<=$ctrx;$x++){
                $a="attach_file".$x;
                 $name = 'attach_name'.$x;
                 $attid = 'attach_id'.$x;
                 $aname=$$name;
                 $attachid=$$attid;
                if(!empty($_FILES[$a]["name"])){
                    $activity = $_FILES[$a]['tmp_name'];
                    $act = $_FILES[$a]["name"];
                   
                    $a = explode(".", $act); //attach file
                    $ext = $a[1];
                    $afile = $logid."_".$userid.$x.".".$ext;
                    $getex=$con->query("SELECT log_id FROM tmp_attachment_logs WHERE attach_id = '$attachid'");
                    echo json_encode("SELECT log_id FROM tmp_attachment_logs WHERE attach_id = '$attachid'");
                    $rowex=$getex->num_rows;
                    if($rowex>0){
                         move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
                          $update=mysqli_query($con,"UPDATE tmp_attachment_logs SET attach_file = '$afile', attach_name='$aname' WHERE attach_id='$attachid'");
                         // echo json_encode("UPDATE tmp_attachment_logs SET attach_file = '$afile', attach_name='$aname' WHERE attach_id='$attachid'");
                    } else {
                           move_uploaded_file($_FILES['attach_file'.$x]['tmp_name'], "uploads/" . $afile);
                     $update=mysqli_query($con,"INSERT INTO tmp_attachment_logs (log_id,attach_file,attach_name) VALUES ('$logid1','$afile','$aname')");
                    // echo json_encode("INSERT INTO tmp_attachment_logs (log_id,attach_file,attach_name) VALUES ('$logid1','$afile','$aname')");
                   
                    }
                }
                if(!empty($aname)){
                      $update=mysqli_query($con,"UPDATE tmp_attachment_logs SET attach_name='$aname' WHERE attach_id='$attachid'");
                    //  echo json_encode("UPDATE tmp_attachment_logs SET attach_name='$aname' WHERE attach_id='$attachid'");
                }
                
            }
        } 
        
    }
?>
      

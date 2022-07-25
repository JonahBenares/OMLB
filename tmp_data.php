<?php 
    include 'header.php'; 
    include 'includes/connection.php';
    include 'includes/functions.php';
    $userid= $_SESSION['userid'];
   

    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        foreach($_POST as $var=>$value)
        $$var = mysqli_real_escape_string($con, $value);

        $userid = $_SESSION['userid'];
        $sql = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
        $rows= mysqli_fetch_array($sql);
        $rows_count = mysqli_num_rows($sql);
        $sql2 = mysqli_query($con,"SELECT * FROM tmp_attachment_logs WHERE log_id = '$id'");
        $row = mysqli_num_rows($sql2);
        $sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM log_head");
        $row1 = mysqli_fetch_array($sql1);
        $max = $row1['logid'] + 1;
        $unit=$rows['unit'];

        if($status=='Done') { 
            $date_finish = date('Y-m-d H:i:s');
            $fin=$userid;
        } else { 
            $date_finish = '';
            $fin=0;
        }

        if($rows_count != 0){
            $notes=mysqli_real_escape_string($con,$rows['notes']);
            $insert = mysqli_query($con,"INSERT INTO log_head (log_id,date_performed,time_performed,unit,main_system,sub_system,notes,performed_by,status,logged_by,due_date,logged_date,date_finish, finished_by) VALUES ('$max','$rows[date_performed]','$rows[time_performed]','$rows[unit]','$rows[main_system]','$rows[sub_system]','$notes','$rows[performed_by]','$rows[status]','$rows[logged_by]','$rows[due_date]','$rows[logged_date]', '$rows[date_finish]', '$fin')");
         
        }

        if($row != 0){
            while($fetch = mysqli_fetch_array($sql2)){
                $update=mysqli_query($con,"INSERT INTO attachment_logs (log_id,attach_file,attach_name) VALUES ('$max','$fetch[attach_file]','$fetch[attach_name]')");
            }
            
        }
        $deleteLH = $con->query("DELETE FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
        $deleteAL = $con->query("DELETE FROM tmp_attachment_logs WHERE log_id = '$id'");
        echo '<script>alert("Successfully Saved!");</script>';
       echo '<script>window.opener.location.href="enternew.php?unit='.$unit.'"; window.close();</script>';
    }
?>
<style type="text/css">
    input{
        color: black;
    }
    table tbody tr td {
        background-color: #3d3d3d00;
        border: 0px solid #47474700!important;
        border-bottom: 1px solid #ffffff5e!important;
    }
</style>
<script>
    function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
    }

   
        function refreshParent() {
            window.opener.location.href="enternew.php";
        }
</script>

<body onload="startTime()">
    <div class="container">     
        <div class="row side-nav">
            <div class="col-lg-12">
                <div class="dash-unit" style="padding:20px">
                    <!-- <a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
                    <dtitle style="color:#b2c831">Enter new Record</dtitle>
                    <hr>
                    <div style=""></div>
                    <div style="width:50%;margin-left:25%"> -->
                    <form method = "POST" enctype="multipart/form-data" class = "update-tmp" id = "delete-tmp" name = "deletetmp">
                        <?php
                            $sqli = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE logged_by = '$userid' ORDER BY log_id DESC");

                            $rowi = mysqli_fetch_array($sqli);
                            /*$sql = mysqli_query($con,"SELECT * FROM tmp_attachment_logs ORDER BY log_id DESC");
                            $rows = mysqli_fetch_array($sql);*/
                        ?>
                        <h2>Data Correct?</h2><br>
                        <table width="100%" style="font-size:15px;" >
                           
                            <tr hidden>
                                <td hidden>
                                    <?php echo $rowi['log_id']; ?>  
                                </td>
                            </tr>
                            <tr>                                
                                <td width='35%' >
                                    Status: 
                                </td>
                                <td >
                                    <?php echo $rowi['status']; ?>
                                </td>
                                <td rowspan="5"></td>
                            </tr>
                            <tr>
                                <td>
                                    Date/Time Performed:  
                                </td>
                                <td>
                                    <?php echo $rowi['date_performed'] . ' ' . $rowi['time_performed']; ?> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Equipment Type/Model:  
                                </td>
                                <td>
                                    sample 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Problem/Findings:  
                                </td>
                                <td>
                                    sample
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Work Description:  
                                </td>
                                <td>
                                    sample
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Action Taken:  
                                </td>
                                <td>
                                    sample
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Parts Replaced: 
                                </td>
                                <td>
                                    sample
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Due Date: 
                                </td>
                                <td>
                                    <?php echo $rowi['due_date']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Performed By: 
                                </td>
                                <td>
                                    <?php echo $rowi['performed_by']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Notes: 
                                </td>
                                <td  colspan="2">
                                    <?php echo $rowi['notes']; ?>
                                </td>
                            </tr>
                            
                            <tr> 
                                <td colspan="3">Attachment:</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                               
                                <?php 
                                    $c=1;
                                    $sql1 = mysqli_query($con,"SELECT * FROM tmp_attachment_logs WHERE log_id = '$rowi[log_id]' ORDER BY log_id DESC");
                                 
                                    while ($row1 = mysqli_fetch_array($sql1)){    
                                    $cert=explode(".",$row1['attach_file']);
                                    $attach = $cert[1];
                                    if($attach=='png' || $attach=='jpg' || $attach == 'jpeg' || $attach == 'PNG' || $attach == 'JPG' || $attach == 'JPEG'){
                                ?>
                                <div class="column" style="float:left" >                                
                                    <img id="hase" style="margin-bottom:2px" class = "thumbnail sd"  src="
                                        <?php 
                                            if (empty($row1['attach_file'])){
                                                echo "uploads/default.jpg";
                                                }
                                            else{
                                                echo 'uploads/'. $row1['attach_file']; 
                                            }
                                        ?>" width="100px" height="100px" class="hover-shadow cursor" >
                                      <h5 class="sas " style="color:white;margin:2px"><?php echo $row1['attach_name']?></h5>
                                </div> 
                                <input type = "hidden" name = "attach_file" value = "<?php echo $row1['attach_file']?>">
                                <input type = "hidden" name = "attach_name" value = "<?php echo $row1['attach_name']?>"> 
                                <?php } $c++; } ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <center>
                              <a href = "javascript:void(0)" style = "padding: 8px 28px 10px 26px; font-size:14px;" onclick = "cancel()" class=" btn btn-sm btn-danger btn-fill">Delete and Enter New</a>  
                            <a href = "javascript:void(0)" style = "padding: 8px 28px 10px 26px; font-size:14px;" onclick = "update()" class=" btn btn-sm btn-primary btn-fill">Change</a> 
                          
                            <input type="submit" value="Confirm" name = "submit" class=" btn btn-sm btn-success btn-fill">
                        </center>                                                         
                        </div>
                        <input type = "hidden" name = "logged_by" value = "<?php echo $userid;?>">
                        <input type = "hidden" name = "id" value = "<?php echo $rowi['log_id'];?>">
                        <input type = "hidden" name = "unit" value = "<?php echo $rowi['unit'];?>">
                        <input type = "hidden" name = "main_id" value = "<?php echo $rowi['main_system'];?>">
                        <input type = "hidden" name = "sub_id" value = "<?php echo $rowi['sub_system'];?>">
                        <input type = "hidden" name = "date_performed" value = "<?php echo $rowi['date_performed'];?>">
                        <input type = "hidden" name = "time_performed" value = "<?php echo $rowi['time_performed'];?>">
                        <input type = "hidden" name = "due_date" value = "<?php echo $rowi['due_date'];?>">
                        <input type = "hidden" name = "notes" value = "<?php echo $rowi['notes'];?>">
                        <input type = "hidden" name = "performed_by" value = "<?php echo $rowi['performed_by'];?>">
                        <input type = "hidden" name = "status" value = "<?php echo $rowi['status'];?>">
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /row -->
</div> 


</body>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<link href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
    rel="stylesheet" type="text/css" /> -->
<script type="text/javascript" src="js/lineandbars.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script src = "js/jquery.min.js" type="text/javascript"></script>
<script src = "js/jquery-migrate.min.js" type="text/javascript"></script>
<script src="js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    } 
    function cancel(){
        var data = $("#delete-tmp").serialize();
        $.ajax({
            data: data,
            type: "POST",
            url: "delete_tmp.php",
            success: function(output){
                /* alert(output);*/
                /*alert('Successfully Fill Up!');*/
                 window.close();
                 refreshParent();

            }
        });
    } 
    function update(){
        window.close();
        //window.opener.location.href="add_newact.php?unit=<?php echo $rowi['unit']; ?>&items=<?php echo $rowi['main_system']; ?>";
    } 
    
    $('#datepicker').datepicker();
</script>
</html>
<?php include 'header.php'; 
include 'includes/connection.php';
include 'includes/functions.php';
$userid= $_SESSION['userid'];
	if(isset($_GET['id'])){
        $id = str_replace('"', '', $_GET['id']);
    }
    else{
        $id = "";
    }
    $today=date("Y-m-d");
?>
<link href="css/update_rec.css" rel="stylesheet">
<script> 	
    function showFileSize() {

        var input, file;
     

        if (!window.FileReader) {
            bodyAppend("p", "The file API isn't supported on this browser yet.");
            return;
        }
        counter = document.getElementById('counter').value;
        counterX = document.getElementById('counterX').value;

        var counter_error=0;
        if(counterX===''){
            ctr =  counter;
        } 
        else{
            counterX_val = document.getElementById('counterX').value;
            ctr =  counterX_val;
        }

        if(ctr==1){
            act = document.getElementById('p_acti1');
            fileact = act.files[0];
            if(typeof fileact !== 'undefined'){
                if(fileact.size > 2000000){
                document.getElementById("certBox1").innerHTML="Error: Picture size is too big. Max file size is 2mb.";
                counter_error++;
                }
            }
        } 
        else if(ctr>=2){
            for(x=1;x<=ctr;x++){
                act = document.getElementById('p_acti'+x);
                fileact = act.files[0];
                if(typeof fileact !== 'undefined'){
                    if(fileact.size > 2000000){
                      document.getElementById('certBox'+x).innerHTML="Error: Picture size is too big. Max file size is 2mb.";
                      counter_error++;
                    }
                }
            }
        }
       
       
        if(counter_error==0){

            var frm = new FormData();
            id = document.getElementById('id').value;
            // alert(id);
         
                if(counterX===''){
                    ctr =  counter;
                } else{
                    counterX_val = document.getElementById('counterX').value;
                    ctr =  counterX_val;             
                }

            frm.append('id', id);
            frm.append('counter', counter);
            frm.append('counterX', counterX);

            if(ctr==1){
               act = document.getElementById('p_acti1');
               attachname1 = document.getElementById('attach_name1').value;
               frm.append('attach_file1', act.files[0]);
               frm.append('attach_name1', attachname1);

            } 
            else if(ctr>=2){
                for(x=1;x<=ctr;x++){
                   act = document.getElementById('p_acti'+x);
                   certname = document.getElementById('attach_name'+x).value;
                   frm.append('attach_file'+x, act.files[0]);
                   frm.append('attach_name'+x, certname);
                }
            } 
            var date_performed =document.getElementById('date_performed').value;
            frm.append('date_performed', date_performed);
            var hour =document.getElementById('hour').value;
            frm.append('hour', hour);
            var minutes =document.getElementById('minutes').value;
            frm.append('minutes', minutes);
            var notes =document.getElementById('notes').value;
            frm.append('notes', notes);
            var equip_type_model =document.getElementById('equip_type_model').value;
            frm.append('equip_type_model', equip_type_model);
            var prob_find =document.getElementById('prob_find').value;
            frm.append('prob_find', prob_find);
            var work_desc =document.getElementById('work_desc').value;
            frm.append('work_desc', work_desc);
            var act_taken =document.getElementById('act_taken').value;
            frm.append('act_taken', act_taken);
            var parts_replaced =document.getElementById('parts_replaced').value;
            frm.append('parts_replaced', parts_replaced);
            var performed_by =document.getElementById('performed_by').value;
            frm.append('performed_by', performed_by);
            var status =document.getElementById('status').value;
            frm.append('status', status);
            $.ajax({
                type: 'POST',
                url: "update_newact_ins.php",
                data: frm,
                contentType: false,
                processData: false,
                cache: false,
                success: function(output){
                    alert('Files successfully saved!');
                    window.location.href="update_rec.php?id="+id;
               }
            });    
        }
    }

    $(function() {
        var ctrx = document.getElementById('counter').value
        var activityDiv = $('#p_activity');
        var mm = $('#p_activity div').size() + 1;
        /*var act = mm - 4;
        var ii = act;*/
        var ii = document.getElementById('counter').value;

        $('#addActivity').live('click', function() {
            ii++;
            $('<div class = "acti'+ii+'"><div class="row"><div class="col-lg-5" style="padding-right:0px"><input type="file" name="attach_file'+ii+'" id="p_acti'+ii+'" class="btn btn-sm btn-default " style="width:100%" ><div id="certBox'+ii+'" class="acti"></div></div><div for = "attach_name1" class="col-lg-5" style="padding-right:0px"><input type="name" name="attach_name'+ii+'" id="attach_name'+ii+'" class="form-control" style="width:100%;height:35px;margin-bottom:5px;" placeholder="Remarks"></div><div class="col-lg-2"><a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity" style="padding:5px 8px">+</a> <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity" style="padding:5px 9px">x</a></div></div></div>').appendTo(activityDiv);
            
               /* var count = ii - 1;*/
                document.getElementById("counterX").value = ii;
                return false;
        });
        $('#remActivity').live('click', function() { 
            if( ii >= 2 ) {
                ii--;
                $("div").remove(".acti" + ii);
            } 
            return false;
        });
    });

    function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
    }
</script>

<body onload="startTime()">
<?php include 'navbar.php';?>
<div class="container"> 
  	<div class="row">
        <div class="col-lg-6">
      		<div class="dash-unit" >
                <a href="view_latest.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
                <dtitle style="color:#b2c831">Update Record</dtitle>
		  		<hr>
                <div style="padding:0px 15px 0px 15px">
                    <form method = "POST" enctype="multipart/form-data" id = "add-vendor" name = "addvendor" >
                        <table>
                            <tr>
                                <td width="">Date Performed: </td>
                                <td colspan="4"><input type = "date" id = "date_performed" name = "date_performed" class = "form-control" required style='width:450px;margin-bottom:0px'></td>
                            </tr>
                            <tr>
                                <td>Time Performed: </td>
                                <td><input type = "text" id = "hour" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" placeholder="Hour" required style="margin-bottom:0px"></td> 
                                <td > : </td>
                                <td> <input type = "text" id = "minutes" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" placeholder="Minutes" required style="margin-bottom:0px"></td>
                                <!-- <td>
                                    <input type = "radio" name = "time_of_day" value = "AM" required> AM
                                    <input type = "radio" name = "time_of_day" value = "PM" required> PM
                                </td> -->
                            </tr>
                            <tr>
                                <td >Equipment Type/Model: </td>
                                <td colspan="4"><textarea rows='1' class = "form-control" id = "equip_type_model" name = "equip_type_model" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Problem/ Findings: </td>
                                <td colspan="4"><textarea rows='2' class = "form-control" id = "prob_find" name = "prob_find" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Work Description: </td>
                                <td colspan="4"><textarea rows='2' class = "form-control" id = "work_desc" name = "work_desc" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Action Taken: </td>
                                <td colspan="4"><textarea rows='2' class = "form-control" id = "act_taken" name = "act_taken" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Parts Replaced: </td>
                                <td colspan="4"><textarea rows='2' class = "form-control" id = "parts_replaced" name = "parts_replaced" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Notes: </td>
                                <td colspan="4"><textarea rows='2' class = "form-control" id = "notes" name = "notes" style='resize:none;margin: 0;'></textarea></td>
                            </tr>
                            <tr>
                                <td >Performed By: </th >
                                <td colspan="4"><input type = "text" name = "performed_by" id = "performed_by" class = "form-control" style="margin-bottom:0px"></td>
                            </tr>
                            <tr>
                                <td >Status: </td>
                                <td colspan="4">
                                  <!-- <input type = "text" name = "performed_by" class = "form-control"> -->
                                    <select class = "form-control" id = "status" name = "status" style="margin-bottom: 0px;">
                                        <option selected visited disabled>-Select Status-</option>
                                        <option value="Done">Done</option>
                                        <option value="On-Progress">On-Progress</option>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        <label for="p_acti">Attach Files:</label>
                        <div id = "p_activity">
                            <div class="row" >
                                <div class="col-lg-5" style="padding-right:0px">
                                    <input type="file" name="attach_file1" id="p_acti1" class="btn btn-sm btn-default " style="width:100%" >
                                </div>
                                <div class="col-lg-5"  style="padding-right:0px">
                                    <input type="name" name="attach_name1" id="attach_name1" class="form-control" style="width:100%;height:35px;margin-bottom:5px;" placeholder="Remarks" > 
                                    <input type = "hidden" value = "1" id = "counter" name = "counter">
                                </div>                               
                                <div class="col-lg-2">
                                    <a href="#" class="btn btn-primary btn-xs btn-fill" id="addActivity" style="padding:5px 8px">+</a>
                                    <a href="#" class="btn btn-danger btn-xs btn-fill" id="remActivity" style="padding:5px 9px">x</a>
                                </div>
                            </div>
                            <div class = "row">
                                <div class = "col-lg-3"></div> 
                                <div class = "col-lg-7">
                                    <div id='certBox1' class='acti'></div>
                                </div>
                            </div> 
                        </div>
                        <input type = "hidden" name = "id" id='id' value = "<?php echo $_GET['id']; ?>">
                        <input type = "hidden" name = "logged_by" value = "<?php echo $userid; ?>">
                        <input type = "hidden" name = "counterX" id='counterX'>
                        <div class="row">
                            <div class="col-lg-3"></div>
                                <div class="col-lg-8">
                                <br>
                                  <center>
                                      <input type="button" value="Save" name = "save_data" onclick='showFileSize();' class=" btn btn-sm btn-success btn-fill">  
                                  </center>                                    
                                </div>                             
                            <div class="col-lg-3"></div>                             
                        </div>
                    </form>
                </div>
			</div>
        </div>
        <div id="loader" style="left:70%">
            <figure class="one"></figure>
            <figure class="two">loading</figure>
        </div>
        <div id="contents" style="display: none">
            <div class="col-lg-6 dash-unit">
                <a class="btn btn-xs"><!-- <span class="fa fa-chevron-left"></span> --> <!-- BACK --></a><!--  // -->
                 <?php 
                    $sql2 = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
                    $row = mysqli_fetch_array($sql2);
                    $diff = dateDifference($row['due_date'],$today);
                ?>
                <span style="font-size:12px">Status:</span> 
                <?php if($row['status'] == 'Done') { ?>
                <span style="font-size:12px;font-weight:900!important" class = "label label-success"><?php echo $row['status']; ?></span>
                <?php } else { ?>
                    <span style="font-size:12px;font-weight:900!important" class = "label label-warning"><?php echo $row['status']; ?></span>
                <?php } ?>
                <dtitle style="color:#b2c831"></dtitle>
                <hr>
                
                <div class="shadow latest" style="">
                    <table width="100%" class="" style="text-align: left;">                        
                        <tr>                         
                            <td width="20%"><label style="font-size:12px">Date/Time Performed:</label></td>
                            <td width="80%"> <label style="font-size:12px;font-weight:900!important"><?php echo $row['date_performed'].' '.$row['time_performed']?></label></td>
                        </tr>
                        <tr>
                            <td> <label style="font-size:12px">Due Date:</label></td>
                            <td>   
                                <label style="font-size:12px;font-weight:900!important">
                                    <?php echo $row['due_date']?>
                                    <i style = "font-weight:100; font-size:13px;">(Days Left: 
                                        <?php 
                                            if($row['status'] == 'On-Progress') {
                                                if($diff<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff."</span>";
                                                else echo "<span style='color:#78dc52; font-weight:bold'>".$diff."</span>";
                                            }
                                        ?>)
                                    </i>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Performed By:</label></td> 
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo $row['performed_by'] ?></label></td>                             
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Unit:</label></td>                                
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo getInfo($con, "unit_name", "unit", "unit_id", $row['unit']); ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Main Category:</label></td> 
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo getInfo($con, "system_name", "main_system", "main_id", $row['main_system']); ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Sub System:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo getInfo($con, "subsys_name", "sub_system", "sub_id", $row['sub_system']); ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Equipment Type/Model:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['equip_type_model']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Problem/ Findings:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['prob_find']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Work Description:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['work_desc']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Action Taken:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['act_taken']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Parts Replaced:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['parts_replaced']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Notes:</label></td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['notes']); ?></label> </td>
                        </tr>
                        <tr>
                            <?php if ($row['status'] == 'Done') { ?>
                            <td colspan="4"> 
                            </td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Date Finished:</label> </td>                                
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo $row['date_finish'] ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Done by:</label> </td>
                            <td><label style="font-size:12px;font-weight:900!important"><?php echo getInfo($con, "fullname", "users", "user_id", $row['finished_by']); ?></label>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <td>
                            <label style="font-size:12px">Status:</label> </td>
                         <td>   <label style="font-size:12px;font-weight:900!important"><?php echo $row['status'] ?></label>
                        </td>
                        <?php } ?>
                        <tr>
                            <td>
                                <label style="font-size:12px">Logged by/Date&Time:</label> </td>
                            <td><label style="font-size:12px;font-weight:900!important">
                                    <?php echo getInfo($con, "fullname", "users", "user_id", $row['logged_by']) . " / " . $row['logged_date'];?> 
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Attachments:</label><br> 
                                <?php 
                                $c=1;
                                $sql = mysqli_query($con,"SELECT * FROM attachment_logs WHERE log_id = '$id'");
                                while ($row1 = mysqli_fetch_array($sql)){    
                                    $cert=explode(".",$row1['attach_file']);
                                    $attach = $cert[1];
                                    if($attach=='png' || $attach=='jpg' || $attach == 'jpeg' || $attach == 'PNG' || $attach == 'JPG' || $attach == 'JPEG'){
                                    ?>
                                        <div class="column" style="float:left" >                                
                                            <img id="hase" class = "thumbnail sd"  src="
                                                <?php 
                                                    if (empty($row1['attach_file'])){
                                                        echo "images/default.jpg";
                                                    }
                                                    else{
                                                        echo 'uploads/'. $row1['attach_file']; 
                                                    }
                                                ?>" width="100px" height="100px" onclick="openModal();currentSlide(<?php echo $c;?>)" class="hover-shadow cursor" alt="<?php echo $row1['attach_file']?>" >
                                              <h5 class="sas" style = "font-size:13px;"><?php echo $row1['attach_name']?></h5>
                                        </div>  
                                    <?php } else { ?>
                                        <div class="column" >  
                                            <a href='uploads/<?php echo $row1['attach_file']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='images/files.png' width="230" height="230"><h5 class="sas" style="color:#0087ff" ><?php echo $row1['attach_file']; ?></h5></a> 
                                        </div>
                                <?php } $c++; } ?>
                                <div id="mode" class="modal" >
                                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                    <div onclick="closeModal()">
                                        <span class="close cursor" onclick="closeModal()">&times;</span>
                                        <div class="modal-content">                              
                                            <?php
                                                $a = 1;
                                                $sql3 = mysqli_query($con,"SELECT * FROM attachment_logs WHERE log_id = '$id'");
                                                $b = mysqli_num_rows($sql3);
                                                while ($row2 = mysqli_fetch_array($sql3)){ 
                                                $crt=explode(".",$row2['attach_file']);
                                                $attach1 = $crt[1];
                                            ?>
                                            <div class="mySlides">
                                                <div class="numbertext" ><?php echo $a.'/'.$b ?>&nbsp-&nbsp<?php echo $row2['attach_name'];?></div>
                                                    <img src="<?php 
                                                        if (empty($row2['attach_file'])){
                                                            echo "images/default.jpeg";
                                                        } else{
                                                            if($attach1 == 'jpg' || $attach1 == 'png' || $attach1 == 'jpeg'  || $attach1 == 'PNG' || $attach1 == 'PNG' || $attach1 == 'JPG' || $attach1 == 'JPEG'){
                                                                echo 'uploads/'. $row2['attach_file']; 
                                                            } else {
                                                                echo "images/files.png";
                                                            }
                                                        }
                                                    ?>" style="width:100%">
                                                </div>
                                                <?php $a++; }?>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>                       
                            </td>
                        </tr>  
                    </table>
                </div>
                <?php
                    $sql5 = mysqli_query($con,"SELECT * FROM update_logs WHERE log_id = '$id' ORDER BY update_id DESC");
                    $row5 = $sql5->num_rows;
                    $count=1;
                    if($row5 >0){ ?>
                    <hr style="margin:10px 0px 0px 0px">
                        <center>
                            <label style="font-size:25px;color:#c0d834">
                                <span class="glyphicon glyphicon-arrow-down"></span> 
                                UPDATES 
                                <span class="glyphicon glyphicon-arrow-down"></span>
                            </label>
                        </center>
                    <hr>
                <?php
                    while($row4 = mysqli_fetch_array($sql5)) {
                ?>
                <div class="shadow latest1" style="">
                    <table width="100%" class="table-bosrdered" style="text-align: left;">
                        <tr>                        
                            <td>
                                <label style="font-size:12px">Date/Time:</label> 
                                <label style="font-size:12px;font-weight:900!important"><?php echo $row4['date_performed'].' '.$row4['time_performed']?></label>
                            </td>                                      
                        </tr>
                        <tr>
                            <td  colspan="4">
                                <label style="font-size:12px">Performed By:</label> 
                                <label style="font-size:12px;font-weight:900!important"><?php echo $row4['performed_by'] ?></label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Equipment Type/Model:</label>&nbsp; <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['equip_type_model']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Problem/ Findings:</label>&nbsp; <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['prob_find']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Work Description:</label>&nbsp; <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['work_desc']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Action Taken:</label>&nbsp; <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['act_taken']); ?></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:12px">Parts Replaced:</label>&nbsp; <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['parts_replaced']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><label style="font-size:12px">Notes:</label> 
                            <label style="font-size:12px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['notes']); ?></label> </td>
                        </tr>
                        <tr>
                            <?php if ($row4['status'] == 'Done') { ?>
                            <td colspan="4">
                                <label style="font-size:12px">Status:</label> 
                                <label style="font-size:12px;font-weight:900!important"><?php echo $row4['status'] ?></label>  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label style="font-size:12px">Date Finished:</label> 
                                <label style="font-size:12px;font-weight:900!important"><?php echo $row4['date_finish'] ?></label>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <td>
                            <label style="font-size:12px">Status:</label> 
                            <label style="font-size:12px;font-weight:900!important"><?php echo $row4['status'] ?></label>
                        </td>
                        <?php } ?>  
                        <tr>
                            <td>
                                <label style="font-size:12px">Logged by/Date&Time:</label> 
                                <label style="font-size:12px;font-weight:900!important">
                                    <?php echo getInfo($con, "fullname", "users", "user_id", $row4['logged_by']) . " / " . $row4['logged_date'];?> 
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><label style="font-size:12px">Attachments:</label><br> 
                                <?php 
                                $f=1;
                                $sql6 = mysqli_query($con,"SELECT * FROM update_attachment WHERE update_id = '$row4[update_id]'");
                                while ($row8 = mysqli_fetch_array($sql6)){    
                                    $cert1=explode(".",$row8['attach_file']);
                                    $attach2 = $cert1[1];

                                    if($attach2=='png' || $attach2=='jpg' || $attach2 == 'jpeg' || $attach2 == 'PNG' || $attach2 == 'JPG' || $attach2 == 'JPEG'){                           
                                    ?>
                                    <div class="column" style="float:left" >                                
                                        <img id="hase" class = "thumbnail sd"  src="
                                            <?php 
                                                if (empty($row8['attach_file'])){
                                                    echo "images/default.jpg";
                                                }
                                                else{
                                                    echo 'uploads/'. $row8['attach_file']; 
                                                }
                                            ?>" width="100px" height="100px" onclick="openModal<?php echo $count; ?>();currentSlide<?php echo $count; ?>(<?php echo $f;?>)" class="hover-shadow cursor" alt="<?php echo $row8['attach_file']?>" >
                                        <h5 class="sas" style = "font-size:13px;"><?php echo $row8['attach_name']?></h5>
                                    </div>  
                                    <?php } else { ?>
                                    <div class="column" >  
                                        <a href='uploads/<?php echo $row8['attach_file']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='images/files.png' width="230" height="230"><h5 class="sas" style="color:#0087ff" ><?php echo $row8['attach_file']; ?></h5></a> 
                                    </div>
                                <?php } $f++; } ?>
                                <div id="mode<?php echo $count; ?>" class="modal" >
                                    <a class="prev" onclick="plusSlides<?php echo $count; ?>(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides<?php echo $count; ?>(1)">&#10095;</a>
                                    <div onclick="closeModal<?php echo $count; ?>()">
                                        <span class="close cursor" onclick="closeModal<?php echo $count; ?>()">&times;</span>
                                        <div class="modal-content">                                          
                                            <?php
                                                $g = 1;
                                                $sql7 =  mysqli_query($con,"SELECT * FROM update_attachment WHERE update_id = '$row4[update_id]'");
                                                $h = mysqli_num_rows($sql7);
                                                while ($row7 = mysqli_fetch_array($sql7)){ 
                                                $crt1=explode(".",$row7['attach_file']);
                                                $attach4 = $crt1[1];
                                            ?>
                                            <div class="mySlides<?php echo $count; ?>">
                                                <div class="numbertext"><?php echo $g.'/'.$h ?>&nbsp-&nbsp<?php echo $row7['attach_name'];?></div>
                                                    <img src="<?php 
                                                        if (empty($row7['attach_file'])){
                                                            echo "images/default.jpeg";
                                                        } else{
                                                            if($attach4 == 'jpg' || $attach4 == 'png' || $attach4 == 'jpeg'  || $attach4 == 'PNG' || $attach4 == 'PNG' || $attach4 == 'JPG' || $attach4 == 'JPEG'){
                                                                echo 'uploads/'. $row7['attach_file']; 
                                                            } 
                                                            else {
                                                                echo "images/files.png";
                                                            }
                                                        }
                                                    ?>" style="width:100%">
                                                </div>
                                                <?php $g++; }?>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>                       
                            </td>
                        </tr> 
                    </table>
                </div>
                <?php $count++; } } ?>
                <input type='hidden' name='count' id='count' value='<?php echo $count; ?>'>          
            </div>
        </div>

</div> <!-- /container -->
<div id="footerwrap">
  	<footer class="clearfix"></footer>
  	<div class="container">
  		<div class="row">
  			<div class="col-sm-12 col-lg-12">
  			<p><span></span></p>
  			<p style="z-index:-9">OPERATIONS AND MAINTENACE LOGBOOK - Copyright <script>document.write(new Date().getFullYear())</script></p>
  			</div>

  		</div><!-- /row -->
  	</div><!-- /container -->		
</div><!-- /footerwrap -->    
</body>
<script type="text/javascript" src="js/lineandbars.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<!-- <script src="js/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> -->
<script src = "js/jquery-migrate.min.js" type="text/javascript"></script>
<script src="js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
     
        function openModal() {
          document.getElementById('mode').style.display = "block";
        }

        function closeModal() {
          document.getElementById('mode').style.display = "none";

        }

        var slideIndex = 1;
       // showSlides(slideIndex);

        function plusSlides(n) {
          showSlides(slideIndex += n);
        }

        function currentSlide(n) {
          showSlides(slideIndex = n);
        }
 
        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          var captionText = document.getElementById("kik");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
          captionText.innerHTML = dots[slideIndex-1].alt;
        }
    <?php for($x=1;$x<=$count;$x++){ ?>
        function openModal<?php echo $x; ?>() {
          document.getElementById('mode<?php echo $x; ?>').style.display = "block";
        }

        function closeModal<?php echo $x; ?>() {
          document.getElementById('mode<?php echo $x; ?>').style.display = "none";

        }

        var slideIndex<?php echo $x; ?> = 1;
        //showSlides1(slideIndex<?php echo $x; ?>);

        function plusSlides<?php echo $x; ?>(n) {
          showSlides<?php echo $x; ?>(slideIndex<?php echo $x; ?> += n);
        }

        function currentSlide<?php echo $x; ?>(n) {
          showSlides<?php echo $x; ?>(slideIndex<?php echo $x; ?> = n);
        }

        function showSlides<?php echo $x; ?>(n) {
          var i;
          var slides<?php echo $x; ?> = document.getElementsByClassName("mySlides<?php echo $x; ?>");
          var dots = document.getElementsByClassName("demo1");
          var captionText = document.getElementById("kik1");
          if (n > slides<?php echo $x; ?>.length) {slideIndex<?php echo $x; ?> = 1}
          if (n < 1) {slideIndex<?php echo $x; ?> = slides<?php echo $x; ?>.length}
          for (i = 0; i < slides<?php echo $x; ?>.length; i++) {
              slides<?php echo $x; ?>[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides<?php echo $x; ?>[slideIndex<?php echo $x; ?>-1].style.display = "block";
          dots[slideIndex<?php echo $x; ?>-1].className += " active";
          captionText.innerHTML = dots[slideIndex<?php echo $x; ?>-1].alt;
        }
   <?php }
 ?>

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
	
	$('#datepicker').datepicker();
</script>

<script type="text/javascript">
    window.onload = function () {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500); 

        var myVar;
        myVar   =setTimeout(showPage,2000);
    };
    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("contents").style.display = "block";

    }
</script> 

</html>
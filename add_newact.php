<?php 
    include 'header.php'; 
    include 'includes/connection.php';
    include 'includes/functions.php';
    $userid= $_SESSION['userid'];
	if(isset($_GET['id'])){
        $id = str_replace('"', '', $_GET['id']);
    }
    else{
        $id = "";
    } 
?>
<style type="text/css">
	input{
    	color: black;
        font-size:14px !important;
    }
    textarea{
        font-size:17px !important;
    }
    select{
        font-size:17px !important;
    }
    table tbody tr td {
        background-color: #3d3d3d00;
        border: 1px solid #47474700!important;
        font-size:17px;
    }
    #resumeBox, #mapBox, #essayBox, #photoBox,.acti, .eval{
	    color:#f79393;
	    font-style: italic;
	    font-size:11px;
  	}
</style>
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
          
         
                if(counterX===''){
                    ctr =  counter;
                } else{
                    counterX_val = document.getElementById('counterX').value;
                    ctr =  counterX_val;             
                }

          
            frm.append('counter', counter);
            frm.append('counterX', counterX);

            if(ctr==1){
               act = document.getElementById('p_acti1');
               attachname1 = document.getElementById('attach_name1').value;
               attachid1 = document.getElementById('attach_id1').value;
               frm.append('attach_file1', act.files[0]);
               frm.append('attach_name1', attachname1);
               frm.append('attach_id1', attachid1);

            } 
            else if(ctr>=2){
        	    for(x=1;x<=ctr;x++){
        	       act = document.getElementById('p_acti'+x);
                   attachname1 = document.getElementById('attach_name'+x).value;
                   attachid1 = document.getElementById('attach_id'+x).value;
        	       frm.append('attach_file'+x, act.files[0]);
        	       frm.append('attach_name'+x, attachname1);
                   frm.append('attach_id'+x, attachid1);
        	    }
            } 
            var unit =document.getElementById('unit').value;
            frm.append('unit', unit);
            var main_id =document.getElementById('main_id').value;
            frm.append('main_id', main_id);
            var sub_id =document.getElementById('sub_id').value;
            frm.append('sub_id', sub_id);
            var date_performed =document.getElementById('date_performed').value;
            frm.append('date_performed', date_performed);
            var hour =document.getElementById('hour').value;
            frm.append('hour', hour);
            var minutes =document.getElementById('minutes').value;
            frm.append('minutes', minutes);
            var due_date =document.getElementById('due_date').value;
            frm.append('due_date', due_date);
            var notes =document.getElementById('notes').value;
            frm.append('notes', notes);
            var performed_by =document.getElementById('performed_by').value;
            frm.append('performed_by', performed_by);
            var status =document.getElementById('status').value;
            frm.append('status', status);
            $.ajax({
                type: 'POST',
                url: "tmp_insert.php",
                data: frm,
                contentType: false,
                processData: false,
                cache: false,
                success: function(output){
                   // alert(output);
                    window.open('tmp_data.php', '_blank', 'width=600,height=500', 'fullscreen=yes,resizable=no');
                    /*alert(output);*/
               }
            });    
        }
    }

    $(function() {
          var ctrx = document.getElementById('counter').value
          /*if(ctrx==0) var activityDiv = $('#p_activity');
          else var activityDiv = $('#p_activity1');
		var mm = $('#p_activity div').size() + 1;
		var act = mm - 4;
		var ii = act-1;*/
        if(ctrx == 0){
            var activityDiv = $('#p_activity');
        } else {
            var activityDiv = $('#p_activity1');
        }
        var ii = document.getElementById('counter').value;
		$('#addActivity').live('click', function() {
            ii++;
		    $('<div class = "acti'+ii+'"><div for="p_certs"></div><table><tr><td><input type="file" name="attach_file'+ii+'" id="p_acti'+ii+'" class="btn btn-sm btn-normal" style="width:120%;margin-left:103px" ><div id="certBox'+ii+'" class="acti"></div></td><td for = "name_certs"><input type="name" name="attach_name'+ii+'" id="attach_name'+ii+'" class="form-control" style="width:93%;height:35px;margin-bottom:5px;margin-left:90px" placeholder="Remarks"></td><td class = "col-lg-4"><a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity" style = "margin-left:75px">+</a> || <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a></td></tr></table></div>').appendTo(activityDiv);
		    
                /*var count = ii - 1;*/
                document.getElementById("counterX").value = ii;
                $('<input type="hidden" id="attach_id'+ii+'" name="attach_id'+ii+'" value="" />').appendTo(activityDiv);
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
      	<div class="row side-nav">
	        <div class="col-lg-12">
	      		<div class="dash-unit">
                    <a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831">Enter new Record</dtitle>
			  		<hr>
                    <div style=""></div>
                    <div style="width:50%;margin-left:25%">
                        <form method = "POST" enctype="multipart/form-data"  id = "add-vendor" name = "addvendor">
                            <table>
                                <?php 
                                    $main = getInfo($con, "main_id", "sub_system", "sub_id", $_GET['items']);
                                    $sub =  getInfo($con, "subsys_name", "sub_system", 'sub_id', $_GET['items']);
                                ?>
                                <tr>
                                    <th><label>Unit:</label></th>
                                    <td colspan="6"><strong style="padding-left:10px; color:#b2c831"><?php echo getInfo($con, "unit_name", "unit", "unit_id", $_GET['unit']) ?></strong></td>
                                </tr>
                                <tr>
                                    <th><label>Main Category:</label></th>
                                    <td colspan="6"><strong style="padding-left:10px; color:#b2c831"><?php echo getInfo($con, "system_name", "main_system", "main_id", $main)?></strong></td>
                                </tr>
                                <tr>                                    
                                    <th><label>Sub System:</label></th>
                                    <td colspan="6"><strong style="padding-left:10px; color:#b2c831"><?php echo $sub?></strong></td>
                                </tr>
                            </table>
                            <hr>
                            <table>

                            <?php 

                                $sql2 = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE logged_by = '$userid'");
                                $row = mysqli_fetch_array($sql2);
                                $row_num = $sql2->num_rows;
                            ?>
                            <tr>
                                <?php if(!empty($row['date_performed'])) { ?>
                                <th>Date Performed: </th>
                                <td colspan="4">
                                    <input type = "date" id = "date_performed" name = "date_performed" class = "form-control" required style='width:450px' value = "<?php echo $row['date_performed'];?>" autocomplete="off">
                                </td>
                                <?php } else { ?>
                                <th>Date Performed: </th>
                                <td colspan="4">
                                    <input type = "date" id = "date_performed" name = "date_performed" class = "form-control" required style='width:450px' autocomplete="off">
                                </td>
                                <?php }?>
                            </tr>
                            <tr>
                                <th> </th >
                                <td colspan="4">
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <?php if(!empty($row['time_performed'])) { 
                                    $time = $row['time_performed'];
                                    $time_performed = explode(":", $time);
                                ?>
                                <th>Time Performed: </th>
                                <td>
                                    <input type = "text" id = "hour" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" value = "<?php echo $time_performed[0]; ?>" placeholder="Hour" required autocomplete="off">
                                </td> 
                                <?php } else if(empty($row['time_performed'])){ ?>
                                <th>Time Performed: </th>
                                <td>
                                    <input type = "text" id = "hour" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" placeholder="Hour" required autocomplete="off">
                                </td>
                                <?php } else { ?>
                                <th>Time Performed: </th>
                                <td>
                                    <input type = "text" id = "hour" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" placeholder="Hour" required autocomplete="off">
                                </td>
                                <?php } ?>
                                <td > : </td>
                                <?php if(!empty($row['time_performed'])){ ?>
                                <td> 
                                    <input type = "text" id = "minutes" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" value = "<?php echo $time_performed[1]; ?>" placeholder="Minutes" required>
                                </td>
                                <?php } else if(empty($row['time_performed'])) { ?>
                                <td> 
                                    <input type = "text" id = "minutes" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" placeholder="Minutes" required>
                                </td>
                                <?php } else { ?>
                                <td> 
                                    <input type = "text" id = "minutes" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" placeholder="Minutes" required>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['due_date'])){ ?>
                                <th>Due Date: </th>
                                <td colspan="4">
                                    <input type = "date" name = "due_date" id = "due_date" value = "<?php echo $row['due_date']?>" class = "form-control" style = "width:450px;">
                                </td>
                                <?php } else { ?>
                                <th>Due Date: </th>
                                <td colspan="4">
                                    <input type = "date" name = "due_date" id = "due_date" value = "<?php echo $row['due_date']?>" class = "form-control" style = "width:450px;">
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['notes'])){ ?>
                                <th >Notes: </th >
                                <td colspan="4">
                                    <textarea rows='10' class = "form-control" id = "notes" name = "notes" style='resize:none'><?php echo $row['notes']; ?></textarea>
                                </td>
                                <?php } else { ?>
                                <th >Notes: </th >
                                <td colspan="4">
                                    <textarea rows='10' class = "form-control" id = "notes"  name = "notes" style='resize:none'></textarea>
                                </td>   
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['performed_by'])){ ?>
                                <th >Performed By: </th >
                                <td colspan="4">
                                    <input type = "text" name = "performed_by" id = "performed_by" value = "<?php echo $row['performed_by']?>" class = "form-control">
                                </td>
                                <?php } else { ?>
                                <th >Performed By: </th >
                                <td colspan="4">
                                    <input type = "text" id = "performed_by" name = "performed_by" class = "form-control">
                                </td>  
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['status'])) { ?>
                                <th >Status: </th >
                                <td colspan="4">
                                    <select class = "form-control" id = "status" name = "status">
                                        <option selected visited disabled>-Select Status-</option>
                                        <option value="Done" <?php echo (($row['status'] == 'Done') ? ' selected' : ''); ?>>Done</option>
                                        <option value="On-Progress" <?php echo (($row['status'] == 'On-Progress') ? ' selected' : ''); ?>>On-Progress</option>
                                    </select>
                                </td>
                                <?php } else { ?>
                                <th >Status: </th >
                                <td colspan="4">
                                    <select class = "form-control" id = "status" name = "status">
                                        <option selected visited disabled>-Select Status-</option>
                                        <option value="Done">Done</option>
                                        <option value="On-Progress">On-Progress</option>
                                    </select>
                                </td>
                                <?php } ?>
                            <tr>
                            </table><br>
                            <?php

                                 $tmp_attach = $con->query("SELECT * FROM tmp_attachment_logs WHERE log_id = '$row[log_id]' ORDER BY attach_id ASC");
                                $rows_attach = $tmp_attach->num_rows; 
                              
                                if($row_num==0) { ?>
                            <div id = "p_activity">
                                
                                    <table>
                                        <tr>
                                            <th for="p_acti">Attach Files:</th>
                                            <td>
                                                <input type="file" name="attach_file1" id="p_acti1" class="btn btn-sm btn-normal " style="width:120%;margin-left:60px">
                                            </td>
                                            <td>
                                                <input type="name" name="attach_name1" id="attach_name1" class="form-control" style="width:100%;height:35px;margin-bottom:5px;margin-left:80px" placeholder="Remarks" > 
                                                <input type = "hidden" value = "1" id = "counter" name = "counter">
                                            </td>                        
                                            <td class = "col-lg-4">
                                                <a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity" style = "margin-left:75px">+</a> || 
                                                <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a>
                                            </td>
                                        </tr>
                                    </table>
                                
                                  <input type = "hidden" value = "0" id = "attach_id1" name = "attach_id1">
                                <div class = "row">
                                	<div class = "col-lg-4"></div> 
                                    <div class = "col-lg-6">
                                    	<div id='certBox1' class='acti'></div>
                                    </div>
                                </div>
                            </div>
                            <?php } if($row_num>0) { 
                                $r=1;
                                while($fetch_attach=$tmp_attach->fetch_array()) { ?>
                                <div id = "p_activity">
                                <table>
                                    <tr>
                                        <th for="p_acti">Attach Files:</th>
                                        <td>
                                            <input type="file" name="attach_file<?php echo $r; ?>" id="p_acti<?php echo $r; ?>" class="btn btn-sm btn-normal " style="width:100%;margin-left:60px" >
                                            <!--<div id='certBox1' class='acti'></div>-->
                                        </td>
                                        <td>
                                            <input type="name" name="attach_name<?php echo $r; ?>" id="attach_name<?php echo $r; ?>" class="form-control" style="width:100%;height:35px;margin-bottom:5px;margin-left:80px" value="<?php echo $fetch_attach['attach_name']; ?>" >   
                                        </td>                                
                                        <td class = "col-lg-4">
                                            <a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity" style = "margin-left:75px">+</a> || 
                                            <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a>
                                        </td>
                                    </tr>
                                </table>
                                <div class = "row">
                                    <div class = "col-lg-4"></div> 
                                    <div class = "col-lg-6">
                                        <div id='certBox1' class='acti'></div>
                                    </div>
                                </div>
                            </div>
                            <input type = "hidden" value = "<?php echo $fetch_attach['attach_id']; ?>" id = "attach_id<?php echo $r; ?>" name = "attach_id<?php echo $r; ?>">
                            <input type = "hidden" value = "<?php echo $rows_attach; ?>" id = "counter" name = "counter">
                                <?php
                                $r++; } ?>
                            <?php } ?>
                            <div id = "p_activity1" >
                            </div>
                            <input type = "hidden" name = "counterX" id='counterX'>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <center>
                                            <input type="button" value="Save" name = "save_data" onclick='showFileSize();' class=" btn btn-sm btn-success btn-fill">  
                                           <!--  <button onclick='showFileSize();' class=" btn btn-sm btn-success btn-fill">Save</button> --> 
                                        </center>                                    
                                    </div>                             
                                <div class="col-lg-3"></div>                             
                            </div>
                            <tr>
                          
                            <input type = "hidden" name = "unit" id="unit" value = "<?php echo $_GET['unit'];?>">
                            <input type = "hidden" name = "main_id" id = "main_id" value = "<?php echo $main;?>">
                            <input type = "hidden" name = "sub_id" id = "sub_id" value = "<?php echo $_GET['items'];?>">
                            <input type = "hidden" name = "logged_by" value = "<?php echo $userid;?>">
                        </form>
                    </div>
				</div>
	        </div>
        </div><!-- /row -->
	</div> <!-- /container -->
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
      			   <p><span></span></p>
      			   <p>OPERATIONS AND MAINTENANCE LOGBOOK - Copyright <script>document.write(new Date().getFullYear())</script></p>
      			</div>
      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->     
</body>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<link href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
    rel="stylesheet" type="text/css" /> -->
<script type="text/javascript" src="js/lineandbars.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script src = "js/jquery-migrate.min.js" type="text/javascript"></script>
<script src="js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $("#dialog").dialog({
            modal: true,
            autoOpen: false,
            title: "jQuery Dialog",
            width: 300,
            height: 150
        });
        $("#btnShow").click(function () {
            $('#dialog').dialog('open');
        });
    });
</script>
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
	
	$('#datepicker').datepicker();
</script>
</html>
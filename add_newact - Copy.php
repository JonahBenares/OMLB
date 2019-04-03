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

if(isset($_POST['save_data'])){
    foreach($_POST as $var=>$value)
    $$var = mysqli_real_escape_string($con,$value);
    $sql = mysqli_query($con,"SELECT * FROM tmp_log_head WHERE log_id = '$id' AND logged_by = '$userid'");
    $rows = mysqli_num_rows($sql);
    $sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM tmp_log_head");
    $row1 = mysqli_fetch_array($sql1);
    $max = $row1['logid'] + 1;
    $time_performed = $hour.':'.$minutes;
    if($rows == 0){
        $insert= $con->query("INSERT INTO tmp_log_head (log_id,date_performed,time_performed,unit,main_system,sub_system,notes,performed_by,status,logged_by,due_date,logged_date,date_finish) VALUES ('$max','$date_performed','$time_performed','$unit','$main_id','$sub_id','$notes','$performed_by','$status','$logged_by','$due_date',NOW(),NOW())");
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
                $update=mysqli_query($con,"INSERT INTO tmp_attachment_logs (log_id,attach_file,attach_name) VALUES ('$max','$afile','$aname')");
            }
        }  
    }
    else if($rows != 0){
        $update = mysqli_query($con,"UPDATE tmp_log_head SET date_performed = '$date_performed', time_performed = '$time_performed', due_date = '$due_date', notes = '$notes', performed_by = '$performed_by', status = '$status' WHERE log_id = '$id' AND logged_by = '$userid'");
        $updatepic = mysqli_query($con,"UPDATE tmp_attachment_logs SET attach_file = 'attach_file', attach_name = 'attach_name'");
    }
?>
    <script>window.open('tmp_data.php', '_blank', 'width=600,height=500', 'fullscreen=yes,resizable=no');</script>
<?php } ?>


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
</style>
<script>
    function showFileSize() {
        var input, file;
        // (Can't use `typeof FileReader === "function"` because apparently
        // it comes back as "object" on some browsers. So just see if it's there
        // at all.)

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
                document.getElementById("certBox1").innerHTML="Error: Certificate file size is too big. Max file size is 2mb.";
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
    		          document.getElementById('certBox'+x).innerHTML="Error: Certificate file size is too big. Max file size is 2mb.";
    		          counter_error++;
    	          	}
    	       	}
    	    }
        }
        
        if(counter_error==0){
            var frm = new FormData();
            id = document.getElementById('id').value;

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
        }   
    }

    $(function() {
		var activityDiv = $('#p_activity');
		var mm = $('#p_activity div').size() + 1;
		var act = mm - 4;
		var ii = act-1;
		$('#addActivity').live('click', function() {
		    $('<div class = "acti'+ii+'"><div class="row"><div for="p_certs" class="col-lg-3"></div><div class="col-lg-3"><input type="file" name="attach_file'+ii+'" id="p_acti'+ii+'" class="btn btn-sm btn-normal " style="width:100%" ><div id="certBox'+ii+'" class="acti"></div></div><div for = "name_certs" class="col-lg-3"><input type="name" name="attach_name'+ii+'" id="name_cert'+ii+'" class="form-control" style="width:100%;height:35px;margin-bottom:5px;" placeholder="Remarks"></div><div class="col-lg-3"><a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity">+</a> || <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a></div></div></div>').appendTo(activityDiv);
		    ii++;
                var count = ii - 1;
                document.getElementById("counterX").value = count;
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
                        <form method = "POST" enctype="multipart/form-data" >
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
                            ?>
                            <tr>
                                <?php if(!empty($row['date_performed'])) { ?>
                                <th>Date Performed: </th>
                                <td colspan="4">
                                    <input type = "date" name = "date_performed" class = "form-control" required style='width:450px' value = "<?php echo $row['date_performed'];?>" autocomplete="off">
                                </td>
                                <?php } else { ?>
                                <th>Date Performed: </th>
                                <td colspan="4">
                                    <input type = "date" name = "date_performed" class = "form-control" required style='width:450px' autocomplete="off">
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
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" value = "<?php echo $time_performed[0]; ?>" placeholder="Hour" required autocomplete="off">
                                </td> 
                                <?php } else if(empty($row['time_performed'])){ ?>
                                <th>Time Performed: </th>
                                <td>
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" placeholder="Hour" required autocomplete="off">
                                </td>
                                <?php } else { ?>
                                <th>Time Performed: </th>
                                <td>
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "hour" class = "form-control" placeholder="Hour" required autocomplete="off">
                                </td>
                                <?php } ?>
                                <td > : </td>
                                <?php if(!empty($row['time_performed'])){ ?>
                                <td> 
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" value = "<?php echo $time_performed[1]; ?>" placeholder="Minutes" required>
                                </td>
                                <?php } else if(empty($row['time_performed'])) { ?>
                                <td> 
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" placeholder="Minutes" required>
                                </td>
                                <?php } else { ?>
                                <td> 
                                    <input type = "text" onkeypress="return isNumberKey(event)" maxlength="2" name = "minutes" class = "form-control" placeholder="Minutes" required>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['due_date'])){ ?>
                                <th>Due Date: </th>
                                <td colspan="4">
                                    <input type = "date" name = "due_date" value = "<?php echo $row['due_date']?>" class = "form-control" style = "width:450px;">
                                </td>
                                <?php } else { ?>
                                <th>Due Date: </th>
                                <td colspan="4">
                                    <input type = "date" name = "due_date" value = "<?php echo $row['due_date']?>" class = "form-control" style = "width:450px;">
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['notes'])){ ?>
                                <th >Notes: </th >
                                <td colspan="4">
                                    <textarea rows='10' class = "form-control" name = "notes" style='resize:none'><?php echo $row['notes']; ?></textarea>
                                </td>
                                <?php } else { ?>
                                <th >Notes: </th >
                                <td colspan="4">
                                    <textarea rows='10' class = "form-control" name = "notes" style='resize:none'></textarea>
                                </td>   
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['performed_by'])){ ?>
                                <th >Performed By: </th >
                                <td colspan="4">
                                    <input type = "text" name = "performed_by" value = "<?php echo $row['performed_by']?>" class = "form-control">
                                </td>
                                <?php } else { ?>
                                <th >Performed By: </th >
                                <td colspan="4">
                                    <input type = "text" name = "performed_by" class = "form-control">
                                </td>  
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(!empty($row['status'])) { ?>
                                <th >Status: </th >
                                <td colspan="4">
                                    <select class = "form-control" name = "status">
                                        <option selected visited disabled>-Select Status-</option>
                                        <option value="Done" <?php echo (($row['status'] == 'Done') ? ' selected' : ''); ?>>Done</option>
                                        <option value="On-Progress" <?php echo (($row['status'] == 'On-Progress') ? ' selected' : ''); ?>>On-Progress</option>
                                    </select>
                                </td>
                                <?php } else { ?>
                                <th >Status: </th >
                                <td colspan="4">
                                    <select class = "form-control" name = "status">
                                        <option selected visited disabled>-Select Status-</option>
                                        <option value="Done">Done</option>
                                        <option value="On-Progress">On-Progress</option>
                                    </select>
                                </td>
                                <?php } ?>
                            <tr>
                            </table><br>
                            <div id = "p_activity">
                                <div class="row" >
                                    <div for="p_acti" class="col-lg-3">Attach Files:</div>
                                    <div class="col-lg-3">
                                        <input type="file" name="attach_file1" id="p_acti1" class="btn btn-sm btn-normal " style="width:100%" >
                                        <div id='certBox1' class='cert'></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="name" name="attach_name1" id="name_cert1" class="form-control" style="width:100%;height:35px;margin-bottom:5px;" placeholder="Remarks" > 
                                        <input type = "hidden" value = "1" id = "counter" name = "counter">
                                    </div>                                
                                    <div class="col-lg-3">
                                        <a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity">+</a> || 
                                        <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a>
                                    </div>
                                </div >
                            </div>
                            <input type = "hidden" name = "counterX" id='counterX'>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <center>
                                            <input type="submit" value="Save" name = "save_data" class=" btn btn-sm btn-success btn-fill">   
                                        </center>                                    
                                    </div>                             
                                <div class="col-lg-3"></div>                             
                            </div>
                            <tr>
                            <input type = "hidden" name = "id" value = "<?php echo $row['log_id'];?>">
                            <input type = "hidden" name = "unit" value = "<?php echo $_GET['unit'];?>">
                            <input type = "hidden" name = "main_id" value = "<?php echo $main;?>">
                            <input type = "hidden" name = "sub_id" value = "<?php echo $_GET['items'];?>">
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
<script src = "js/jquery.min.js" type="text/javascript"></script>
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
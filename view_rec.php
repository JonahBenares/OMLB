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
<link href="css/view_rec.css" rel="stylesheet">
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
        var ii = act;

        $('#addActivity').live('click', function() {
            $('<div class = "acti'+ii+'"><div class="row"><div for="p_certs" class="col-lg-3"></div><div class="col-lg-3"><input type="file" name="attach_file'+ii+'" id="p_acti'+ii+'" class="btn btn-sm btn-default " style="width:100%" ><div id="certBox'+ii+'" class="acti"></div></div><div for = "name_certs" class="col-lg-3"><input type="name" name="attach_name'+ii+'" id="name_cert'+ii+'" class="form-control" style="width:100%;height:35px;margin-bottom:5px;" placeholder="Notes"></div><div class="col-lg-3"><a href="#" class="btn btn-primary btn-sm btn-fill" id="addActivity">+</a> || <a href="#" class="btn btn-danger btn-sm btn-fill" id="remActivity">x</a></div></div></div>').appendTo(activityDiv);
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
    function print(log_id){
        window.open('print.php?id='+log_id, '_blank', 'width=1000,height=1000');
    }
</script>
<body onload="startTime()">
<?php include 'navbar.php';?>
<!-- <div id="loader">
    <figure class="one"></figure>
    <figure class="two">loading</figure>
</div> -->
<div >
    <div class="container"> 
      	<div class="row">           
            <div class="col-lg-12 dash-unit" >            
                <a class="btn btn-xs" href = "view_latest.php"><span class="fa fa-chevron-left"></span> BACK</a><!--  // -->
                <dtitle style="color:#b2c831"></dtitle>
                <hr>
                <div class="row">
                    <div class="col-lg-4 col-md-4  col-md-offset-4">
                        <center>
                       
                            <a class="btn btn-info" href='<?php echo previousData($con,$_GET); ?>'>PREVIOUS</a> 
                            <a class="btn btn-primary" href='<?php echo nextData($con,$_GET); ?>'>NEXT</a>
                        </center>
                    </div>
                </div>
                <br>

                
                <?php 
                    $sql2 = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
                    $row = mysqli_fetch_array($sql2);
                    $diff = dateDifference($row['due_date'],$today);
                ?>
                <div class="shadow latest">
                    <table width="100%"  style="text-align: left;">
                        <?php if ($row['status'] == 'Done') { ?>
                        <tr>                        
                            <td width="15%">
                               <label style="font-size:15px">Status:&nbsp</label>
                              
                            </td>
                            <td width="37%">
                                <label class="label label-success" style="font-size:15px;font-weight:900!important;"><?php echo $row['status'] ?></label>
                            </td>
                            <td width="50%"><a href='update_rec.php?id=<?php echo $id; ?>' class='btn btn-info pull-right'>Update</a></td>
                            <td><button onClick="print(<?php echo $row['log_id']; ?>)" class="btn btn-danger btn-fill" style="width:80px;">Print</button></td>           
                        </tr>
                        <tr>                        
                            <td width="13%">
                               <label style="font-size:15px">Date Finished:&nbsp</label>  
                            </td>
                            <td width="37%">
                                <label style="font-size:15px;font-weight:900!important"><?php echo $row['date_finish'] ?></label>
                            </td>
                            <td width="50%"><label style="font-size:15px">Notes:</label></td>                     
                        </tr>
                         <tr>                        
                            <td width="13%">
                               <label style="font-size:15px">Done By:&nbsp</label>  
                            </td>
                            <td width="37%">
                                <label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "fullname", "users", "user_id", $row['finished_by']); ?></label>
                            </td>                
                        </tr>
                        <?php } else { ?>

                        <tr>
                            <td width='15%'><label style="font-size:15px">Status:&nbsp</label>
                            </td>
                            <td><label class="label label-warning" style="font-size:15px;font-weight:900!important;color:black;"><?php echo $row['status'] ?></label></td>
                            <td> <a href='update_rec.php?id=<?php echo $id; ?>' class='btn btn-info pull-right'>Update</a></td> 
                            <td><button onClick="print(<?php echo $row['log_id']; ?>)" class="btn btn-danger btn-fill" style="width:80px;">Print</button></td>
                        </tr>
                        <tr>                        
                            <td></td>
                            <td></td>
                            <td width='50%'><label style="font-size:15px">Notes:</label></td>                     
                        </tr>
                        <?php } ?>
                        <tr >
                            <td><label style="font-size:15px">Date/Time Performed:&nbsp</label></td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo $row['date_performed'].' '.$row['time_performed']?></label></td>
                            <td rowspan="8" style="padding-top:0px!important">
                                <label style="font-size:15px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row['notes']); ?></label>
                            </td> 
                        </tr>
                        <tr>
                        	<td>
                        		<label style="font-size:15px">Due Date:&nbsp</label>
                        	</td>
                        	<td>
                        		<label style="font-size:15px;font-weight:900!important"><?php echo $row['due_date']?> <i style = "font-weight:100; font-size:13px;">(Days Left: 
                        		<?php 
    			             		if($row['status'] == 'On-Progress') {
    		             				if($diff<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff."</span>";
    		             				else echo "<span style='color:#78dc52; font-weight:bold'>".$diff."</span>";
    			             		}
    			             	?>)</i>
                        	</label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:15px">Performed By:&nbsp</label></td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo $row['performed_by'] ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:15px">Unit:&nbsp</label></td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "unit_name", "unit", "unit_id", $row['unit']); ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:15px">Main Category:&nbsp</label></td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "system_name", "main_system", "main_id", $row['main_system']); ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:15px">Sub System:&nbsp</label> </td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "subsys_name", "sub_system", "sub_id", $row['sub_system']); ?></label></td>
                        </tr>
                        <tr>
                            <td><label style="font-size:15px">Logged by/Date&Time:</label> </td>
                            <td><label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "fullname", "users", "user_id", $row['logged_by']) . " / " . $row['logged_date']; ?> </label></td>
                        </tr>
                        <tr>
                            <td colspan="3"><label style="font-size:15px">Attachments:&nbsp</label></td>
                        </tr>
                        <tr>
                            <td colspan="3">
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
                                                echo "uploads/default.jpg";
                                                }
                                            else{
                                                echo 'uploads/'. $row1['attach_file']; 
                                            }
                                        ?>" width="100px" height="100px" onclick="openModal();currentSlide(<?php echo $c;?>)" class="hover-shadow cursor" alt="<?php echo $row1['attach_file']?>" >
                                      
                                      <h5 class="sas " style="color:white"><?php echo $row1['attach_name']?></h5>
                                </div>  
                                <?php } else { ?>
                                    <div class="column" >  
                                        <a href='uploads/<?php echo $row1['attach_file']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='uploads/files.png' width="230" height="230">
                                        <h5 class="sas" style="color:#0087ff" ><?php echo $row1['attach_file']; ?></h5></a> 
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
                                                            echo "uploads/default.jpeg";
                                                        } else{
                                                            if($attach1 == 'jpg' || $attach1 == 'png' || $attach1 == 'jpeg'  || $attach1 == 'PNG' || $attach1 == 'PNG' || $attach1 == 'JPG' || $attach1 == 'JPEG'){
                                                                echo 'uploads/'. $row2['attach_file']; 
                                                            } else {
                                                                echo "uploads/files.png";
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
                    if($row5 >0){ 
                ?>
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
                <div class="shadow latest1" >
                    <table width="100%" class="" style="text-align: left;">
                        <tr>
                        
                            <td>
                                <label style="font-size:15px">Status:&nbsp</label> 
                                <label class="<?php echo (($row4[status] == 'Done') ? 'label label-success' :'label label-warning'); ?>" style="font-size:15px;font-weight:900!important"><?php echo $row4['status'] ?></label>  
                            </td>
                        </tr>
                            <?php if ($row4['status'] == 'Done') { ?>
                        <tr>
                            <td>
                                <label style="font-size:15px">Date Finished:&nbsp</label> 
                                <label style="font-size:15px;font-weight:900!important"><?php echo $row4['date_finish'] ?></label>
                            </td>
                            <td style='width:50%'><label style="font-size:14px">Notes:&nbsp</label></td>
                        </tr>
                        <?php } ?>
                        <tr>                        
                            <td>
                                <label style="font-size:14px">Date/Time Performed:&nbsp</label> 
                                <label style="font-size:15px;font-weight:900!important"><?php echo $row4['date_performed'].' '.$row4['time_performed']?></label>
                            </td>  
                             <?php if ($row4['status'] == 'On-Progress') { ?>
                             <td style='width:50%'><label style="font-size:14px">Notes:&nbsp</label></td>
                             <?php } ?>
                             <?php if ($row4['status'] == 'Done') { ?>
                             <td rowspan='4' style='width:50%'><label style="font-size:14px"><?php echo str_replace("-","<br>-",$row4['notes']); ?></label></td>
                             <?php } ?>
                                                    
                        </tr>
                        <tr>
                            <td >
                                <label style="font-size:14px">Performed By:&nbsp</label> 
                                <label style="font-size:15px;font-weight:900!important"><?php echo $row4['performed_by'] ?></label>
                            </td>
                             <?php if ($row4['status'] == 'On-Progress') { ?>
                              <td rowspan="2" width='50%'>    
                             <label style="font-size:15px;font-weight:900!important"><?php echo str_replace("-","<br>-",$row4['notes']); ?> </label>
                             </td>   
                             <?php } ?>
                           
                        </tr>
                         <tr>
                            <td>
                            	<label style="font-size:15px">Logged by/Date&Time:</label> 
                            	<label style="font-size:15px;font-weight:900!important"><?php echo getInfo($con, "fullname", "users", "user_id", $row['logged_by']) . " / " . $row['logged_date']; ?> 
                            	</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label style="font-size:14px">Attachments:</label><br> 
                                <?php 
                                    $f=1;
                                    $sql6 = mysqli_query($con,"SELECT * FROM update_attachment WHERE update_id = '$row4[update_id]'");
                                    while ($row8 = mysqli_fetch_array($sql6)){    
                                    $cert1=explode(".",$row8['attach_file']);
                                    $attach2 = $cert1[1];
                                    if($attach2=='png' || $attach2=='jpg' || $attach2 == 'jpeg' || $attach2 == 'PNG' || $attach2 == 'JPG' || $attach2 == 'JPEG'){                           
                                ?>
                                <div class="column" style="float:left;" >                                
                                    <img id="hase" class = "thumbnail sd"  src="
                                        <?php 
                                            if (empty($row8['attach_file'])){
                                                echo "uploads/default.jpg";
                                                }
                                            else{
                                                echo 'uploads/'. $row8['attach_file']; 
                                            }
                                        ?>" width="100px" height="100px" onclick="openModal<?php echo $count; ?>();currentSlide<?php echo $count; ?>(<?php echo $f;?>)" class="hover-shadow cursor" alt="<?php echo $row8['attach_file']?>" >
                                      <h5 class="sas" style="color:white"><?php echo $row8['attach_name']?></h5>
                                </div>  
                                <?php } else { ?>
                                        <div class="column" >  
                                            <a href='uploads/<?php echo $row8['attach_file']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='uploads/files.png' width="230" height="230">
                                            <h5 class="sas" style="color:#0087ff" ><?php echo $row8['attach_file']; ?></h5></a> 
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
                                                            echo "uploads/default.jpeg";
                                                        } else{
                                                            if($attach4 == 'jpg' || $attach4 == 'png' || $attach4 == 'jpeg'  || $attach4 == 'PNG' || $attach4 == 'PNG' || $attach4 == 'JPG' || $attach4 == 'JPEG'){
                                                                echo 'uploads/'. $row7['attach_file']; 
                                                            } else {
                                                                echo "uploads/files.png";
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
</div>
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
<script src = "js/jquery.min.js" type="text/javascript"></script>
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

    //----------------------------------------------------------update

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

    //----------------------------------------------------------update end



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
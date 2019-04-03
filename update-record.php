<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	$userid=$_SESSION['userid'];
	if(isset($_GET['from'])){ 
        $from = $_GET['from'];
        $to = $_GET['to'];
    }
    else{
        $from = '';
        $to = '';
    }
?>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<body onload="startTime()">
<?php include 'navbar.php';?>
    <div class="container"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit">
	      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >Update Records</dtitle>
			  	
			  		<div class="col-lg-12"><hr></div> 	
				    	<table class="table table-striped table-bordered table-hover" id="dt1">
				        <thead>
				          	<tr>
					            <th colspan="1">Date Performed</th>
					            <th>Unit</th>
					            <th>Main Category</th>
					            <th>Sub Category</th>
					            <th>Performed By</th>
					            <th>No. of Updates</th>
					            <th>Status</th>
					            <th>Action</th>
				          	</tr>
				        </thead>
				        <tbody>	
				        	<?php 
			  					$sql = mysqli_query($con,"SELECT * FROM log_head WHERE logged_by = '$userid' ORDER BY date_performed DESC");
			  					while($row = mysqli_fetch_array($sql)){
			  						$getlogs=mysqli_query($con, "SELECT * FROM update_logs WHERE log_id = '$row[log_id]'");
					            	$row_logs = $getlogs->num_rows;
			  				?>		         
				          	<tr class="gradeA">
					            <td><?php echo $row['date_performed'];?></td>
					            <td><?php echo getInfo($con, 'unit_name', 'unit', 'unit_id',  $row['unit']);?></td>
					            <td><?php echo getInfo($con, 'system_name', 'main_system', 'main_id',  $row['main_system']);?></td>
					            <td><?php echo getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $row['sub_system']);?></td>
					            <td class="center"><?php echo $row['performed_by'];?></td>
					             <td class="center"><?php echo $row_logs;?></td>
					            <?php if($row['status'] == "Done") { ?>
					            	<td class="center">
					            		<center>
					            			<span class = "label label-success"><?php echo $row['status'];?></span>
					            		</center>
					            	</td>
					            <?php } else if($row['status'] == "On-Progress") { ?>
					            	<td class="center">
					            		<center>
					            			<a onclick = "myFunction(<?php echo $row['log_id']; ?>)" style = "cursor:pointer;"><span class = "label label-danger" id = "demo"><?php echo $row['status'];?></span></a>
					            		</center>
					            	</td>
					            <?php } else { ?>
					            	<td class="center">
					            		<center>
					            			<span class = "label label-success"><?php echo $row['status'];?></span>
					            		</center>
					            	</td>
					            <?php }?>
					            <td>
						            <center>
						            	<a class="btn btn-success btn-xs" href='update_rec.php?id=<?php echo $row['log_id']; ?>'><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Update</a>
						            </center>
					            </td>
					        </tr>
					          <?php } ?>
				        </tbody>
				    </table>
				</div>
        	</div>
		</div> 
    </div> 
<?php include 'footer.php';?>
</body>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<script src="js/gijgo.min.js" type="text/javascript"></script>
<!-- <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
	$(document).ready(function () {
        $('#dt1').dataTable({
         	"bSort": false,
         	"order": [[0 , "desc"]]
        });
    });
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
	function confirmationDelete(anchor){
        var conf = confirm('Are you sure you want to cancel this record?');
        if(conf)
        window.location=anchor.attr("href");
    }
    function generate(){
           var df = $('#date_from').val();
           var dt = $('#date_to').val();
            $('#btn_gen').attr('href','view_records.php?from='+df+'&to='+dt);  
    }
</script>
<script>
	function myFunction(id) {
		if(confirm("Are you sure you want to finish this task?")){
			var data = "status=Done&id="+id;
			//alert(data);
		    $.ajax({
	             data: data,
	             type: "post",
	             url: "update_finish.php",
	             success: function(output){
	             window.location='update-record.php';
	         	  }
	      	});
		}
	}
</script>
</html>
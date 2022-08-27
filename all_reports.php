<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	$userid=$_SESSION['userid'];
	$usertype=$_SESSION['usertype'];
 	$today=date("Y-m-d");
?>
<style>	
	table td{
		color:#fff;
		font-size: 14px;
	}
</style>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<script src = "js/scripts/jquery.min.js" type="text/javascript"></script>
<body onload="startTime()">
	<?php include 'navbar.php';?>
	<div id="loader">
	    <figure class="one"></figure>
	    <figure class="two">loading</figure>
	</div>
	<div id="contents" style="display: none">
		<div style="margin: 20px;"> 
			<div class="row">
			<div class="col-lg-12">
		  		<div class="dash-unit ">
		  			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >All Repors</dtitle>
			  		<hr>
			  		<?php 
					 	if(!empty($_POST)){
					 		$param = printURLReports($con,$_POST);
					 	} else {
					 		$param = '';
					 	}
					?>
			  		<a href="javascript:void(0)" data-toggle="modal" data-target="#searchModal" class="btn btn-info btn-md btn-fill" style='float:left'>Search</a>	
					<a href='print_reports.php?<?php echo $param; ?>' target='_blank' class='btn btn-primary pull-right' style='margin-bottom:10px'>EXPORT</a>
					<div class='row' style='margin-bottom:20px'>
						<div class="col-lg-12">
				  		
				  			<?php 	if(!empty($_POST)){ 
					        		echo "Filters Applied: " . filterReports($con,$_POST); ?>
					        		<a href='<?php  $_SERVER['PHP_SELF']; ?>'>Remove Filter</a>
					        		<?php } ?>
				  		</div> 
			  		</div>
			  		<table class="table table-striped table-bordered table-hover" id="dt1">
				        <thead>
				          	<tr>
					            <th colspan="1">Date Performed</th>
					            <th colspan="1">Time Performed</th>
					            <th colspan="1">Date Finished</th>
					            <th colspan="1">Time Finished</th>
					            <th>Unit</th>
					            <th>Sub Category</th>
					            <th>Equipment Type/Model</th>
					            <th>Problem/Findings</th>
					            <th>Action Taken</th>
					            <th>Parts Replaced</th>
					            <th>Performed by</th>
					            <th>Status</th>
				          	</tr>
				        </thead>
				        <tbody>	
				        	<?php
				        	if(!empty($_POST)){ 

								if(!empty(filteredSQLReports($con,$_POST))){
									$data=filteredSQLReports($con,$_POST);
									$url=filterURL($con,$_POST);
									foreach($data AS $id){
				        		$sql = $con->query("SELECT * FROM log_head WHERE log_id = '$id'");
			  					while($row = mysqli_fetch_array($sql)){
			  					$getlogs=mysqli_query($con, "SELECT * FROM update_logs WHERE log_id = '$row[log_id]'");
				            	$row_logs = $getlogs->num_rows;
			  				?>         
				          	<tr class="gradeA">
					            <td><?php echo $row['date_performed'];?></td>
					            <td><?php echo $row['time_performed'];?></td>
					            <td><?php echo $row['date_finished'];?></td>
					            <td><?php echo $row['time_finished'];?></td>
					            <td><?php echo getInfo($con, 'unit_name', 'unit', 'unit_id',  $row['unit']);?></td>
					            <td><?php echo getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $row['sub_system']);?></td>
					            <td class="center"><?php echo $row['equip_type_model'];?></td>
					            <td class="center"><?php echo $row['prob_find'];?></td>
					            <td class="center"><?php echo $row['act_taken'];?></td>
					            <td class="center"><?php echo $row['parts_replaced'];?></td>
					            <td class="center"><?php echo $row['performed_by'];?></td>
					            	<td class="center">
					            		<center>
					            			<span class = "label label-success"><?php echo $row['status'];?></span>
					            		</center>
					            	</td>
							</tr>
							<?php } } } } ?>
				        </tbody>
				    </table>
				</div>
			</div>


		</div> 
		</div>
	</div>
  	<div id="searchModal" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
		    <div class="modal-content" style='padding:10px'>
		      	<div class="modal-header">
			       	<h4 class="modal-title">Add Filters
				       	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </h4>	        
		      	</div>	     
		       	<div class='vendorinfo'>
			       	<div id="errorBox" ></div>
			       	<form method="POST">
				       	<table class='table'>
				  			<tr>
				  				<td>Date From:</td>
				  				<td>
				  					<input type = "date" name = "date_from" id="date_from"  class = "form-control">
				  				</td>
				  			</tr>
				  			<tr>
				  				<td>Date To:</td>
				  				<td>
				  					<input type="date" class = "form-control" id="date_to" name="date_to">
				  				</td>
				  			</tr>
				  			<tr>
				  				<td>Unit:</td>
				  				<td>
					  				<?php
					                  	$unit_result = $con->query('select * from unit order by unit_name');
					                ?>
					                <select name="unit_name" id = "unit_name" class = "form-control">
					                    <option value="" selected visited disabled>Select Unit</option>
					                    <?php
											while($row1 = $unit_result->fetch_assoc()) {
					                    ?>
					                    <option value="<?php echo $row1["unit_id"]; ?>"><?php echo $row1["unit_name"]; ?></option>
					                    <?php
					                      	}
					                    ?>
					                </select>
				                </td>
				            </tr>
				            <tr>
				  				<td>Sub System:</td>
				  				<td>
				  				<?php
				                  	
				                  	$sub_result = $con->query('select * from sub_system order by subsys_name');
				                ?>
				                	<select name="subsys_name" id="sub-list" class = "form-control">
					                    <option value="" selected visited disabled>Select Sub System</option>
					                    <?php
											if ($sub_result->num_rows > 0) {
												while($row = $sub_result->fetch_assoc()) {
					                    ?>
					                    	<option value="<?php echo $row["sub_id"]; ?>"><?php echo $row["subsys_name"]; ?></option>
					                    <?php
					                      		}
					                    	}
					                    ?>
				                	</select>
				  				</td>
				  			</tr>
							<tr>
								<td>Status:</td>
								<td>
									<select name="status" class = "form-control">
					                  	<option value='' selected visited disabled>Select Status</option>
					                  	<option value='Done'>Done</option>
					                  	<option value='On-Progress'>On-Progress</option>
					                </select>
					            </td>
					        </tr>
					        <tr>
				  				<td colspan='2'>
									<center><input class="btn btn-fill btn-info" type = "submit" value = "Apply Filters" name = "submit"></center>
								</td>
				  			</tr>
				  		</table>				  		
			       	</form>
		       	</div>
		    </div>
	  	</div>
	</div>
	<?php include 'footer.php';?>
</body>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<script src="js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
        $('#dt1').dataTable({
         	"bSort": true,
         	"order": [[0 , "desc"]]
        });
    });
    $('#main-list').on('change', function(){
		var id = this.value;
		$.ajax({
		type: "POST",
		url: "get_subcat.php",
		data:'id='+id,
			success: function(result){
				$("#sub-list").html(result);
			}
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
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
	    <div class="container"> 
	      	<div class="row">
	        	<div class="col-lg-12">
		      		<div class="dash-unit ">
		      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
				  		<dtitle style="color:#b2c831" >View Records / Upate Records</dtitle>
				  		<hr>
				  		
				  	
				  		<a href="javascript:void(0)" data-toggle="modal" data-target="#searchModal" class="btn btn-info btn-md btn-fill" style='float:left'>Search</a>	
							<?php 

						
						 if($usertype=='admin'){
						 	if(!empty($_POST)){
						 		$param = printURL($con,$_POST);
						 	} else {
						 		$param = '';
						 	}
						?>
						<a href='print-logs.php?<?php echo $param; ?>' target='_blank' class='btn btn-primary pull-right' style='margin-bottom:10px'>EXPORT</a>
						<?php } ?>
						<div class='row' style='margin-bottom:20px'>
							<div class="col-lg-12">
					  		
					  			<?php 	if(!empty($_POST)){ 
						        		echo "Filters Applied: " . filtersApplied($con,$_POST); ?>
						        		<a href='<?php  $_SERVER['PHP_SELF']; ?>'>Remove Filter</a>
						        		<?php } ?>
					  		</div> 
				  		</div>
				  		<table class="table table-striped table-bordered table-hover" id="dt1">
					        <thead>
					          	<tr>
						            <th colspan="1">Date/Time Performed</th>
						            <th>Unit</th>
						            <th>Main Category</th>
						            <th>Sub Category</th>
						            <th>Logged By</th>
						            <th>Updates</th>
						            <th>Days Left</th>
						            <th>Working Days</th>
						             <th>Status</th>
						            <th>Action</th>
					          	</tr>
					        </thead>
					        <tbody>	
					        	<?php
					        	if(!empty($_POST)){ 

									if(!empty(filteredSQL($con,$_POST))){
										$data=filteredSQL($con,$_POST);
										foreach($data AS $id){
											
									
					        		$sql = $con->query("SELECT * FROM log_head WHERE log_id = '$id'");
				  					while($row = mysqli_fetch_array($sql)){
				  					$getlogs=mysqli_query($con, "SELECT * FROM update_logs WHERE log_id = '$row[log_id]'");
					            	$row_logs = $getlogs->num_rows;
					            	$diff = dateDifference($row['due_date'],$today);
					            	$diff1 = dateDifference($today,$row['date_performed']);
				  				?>	         
					          	<tr class="gradeA">
						            <td><?php echo $row['date_performed'] . ' ' . $row['time_performed'];?></td>
						            <td><?php echo getInfo($con, 'unit_name', 'unit', 'unit_id',  $row['unit']);?></td>
						            <td><?php echo getInfo($con, 'system_name', 'main_system', 'main_id',  $row['main_system']);?></td>
						            <td><?php echo getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $row['sub_system']);?></td>
						          
						              
						            <td class="center"><?php echo getInfo($con, 'fullname', 'users', 'user_id', $row['logged_by']);?></td>
						           
						             <td class="center"><?php echo $row_logs;?></td>
						             <td class="center">
						             	<?php 
						             		
						             	if($row['status'] == 'On-Progress') {
						             				if($diff<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff."</span>";
						             				else echo "<span style='color:#78dc52; font-weight:bold'>".$diff."</span>";
						             			}
						             	?>
						             </td>
						             <td class="center">
							             <?php 
							             if($row['status'] == 'On-Progress') {
							             	if($diff1<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff1."</span>";
						             		else echo "<span style='color:#78dc52; font-weight:bold'>".$diff1."</span>";
						             		}
							             ?>
						             </td>
						              <?php if($row['status'] == "Done") { ?>
						            	<td class="center">
						            		<center>
						            			<span class = "label label-success"><?php echo $row['status'];?></span>
						            		</center>
						            	</td>
						            <?php } else if($row['status'] == "On-Progress") { ?>
						            	<td class="center">
						            		<center>
						            			<a onclick = "myFunction(<?php echo $row['log_id']; ?>)" style = "cursor:pointer;"><span class = "label label-warning" id = "demo" style="color:black"><?php echo $row['status'];?></span></a>
						            			
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
							            	<a href = "view_rec.php?id=<?php echo $row['log_id']; ?>" class="btn btn-success btn-xs" target='_blank'><span class="fa fa-eye" aria-hidden="true"></span> </a>
							            	
							            	<a class="btn btn-primary btn-xs" href='update_rec.php?id=<?php echo $row['log_id']; ?>' target='_blank'><span class="fa fa-pencil-square-o" aria-hidden="true"></span> </a>
							            	
						            	</center>
						            </td>
								</tr>
					           <?php } 
					           	}
									}
									
								} else { 
									
								$sql = $con->query("SELECT * FROM log_head");
				  					while($row = mysqli_fetch_array($sql)){
				  					$getlogs=mysqli_query($con, "SELECT * FROM update_logs WHERE log_id = '$row[log_id]'");
					            	$row_logs = $getlogs->num_rows;
					            	$diff = dateDifference($row['due_date'],$today);
					            	$diff1 = dateDifference($today,$row['date_performed']);
				  				?>	         
					          	<tr class="gradeA">
						            <td><?php echo $row['date_performed'] . ' ' . $row['time_performed'];?></td>
						            <td><?php echo getInfo($con, 'unit_name', 'unit', 'unit_id',  $row['unit']);?></td>
						            <td><?php echo getInfo($con, 'system_name', 'main_system', 'main_id',  $row['main_system']);?></td>
						            <td><?php echo getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $row['sub_system']);?></td>
						            
						          
						            <td class="center"><?php echo getInfo($con, 'fullname', 'users', 'user_id', $row['logged_by']);?></td>
						           
						             <td class="center"><?php echo $row_logs;?></td>
						             <td class="center">
						             	<?php 
						             		if($row['status'] == 'On-Progress') {
						             				if($diff<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff."</span>";
						             				else echo "<span style='color:#78dc52; font-weight:bold'>".$diff."</span>";
						             			}
						             	?>
						             </td>
						             <td class="center">
							             <?php 
							             if($row['status'] == 'On-Progress') {
							             	if($diff<=0) echo "<span style='color:#f82e48; font-weight:bold'>".$diff1."</span>";
						             		else echo "<span style='color:#78dc52; font-weight:bold'>".$diff1."</span>";
						             		}
							             ?>
						             </td>
						               <?php if($row['status'] == "Done") { ?>
						            	<td class="center">
						            		<center>
						            			<span class = "label label-success"><?php echo $row['status'];?></span>
						            		</center>
						            	</td>
						            <?php } else if($row['status'] == "On-Progress") { ?>
						            	<td class="center">
						            		<center>
						            			<a onclick = "myFunction(<?php echo $row['log_id']; ?>)" style = "cursor:pointer;"><span class = "label label-warning" id = "demo" style="color:black"><?php echo $row['status'];?></span></a>
						            			
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
							            	<a href = "view_rec.php?id=<?php echo $row['log_id']; ?>" class="btn btn-success btn-xs" target='_blank'><span class="fa fa-eye" aria-hidden="true"></span> </a>
							            	
							            	<a class="btn btn-primary btn-xs" href='update_rec.php?id=<?php echo $row['log_id']; ?>' target='_blank'><span class="fa fa-pencil-square-o" aria-hidden="true"></span></a>
						            	</center>
						            </td>
								</tr>

								<?php }
							}
								?>
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
	        </button></h4>
	        
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
	  				<td>Due Date From:</td>
	  				<td>
	  					<input type = "date" name = "due_from" id="due_from"  class = "form-control">
	  				</td>
	  			</tr>
	  			<tr>
	  				<td>Due Date To:</td>
	  				<td>
	  					<input type="date" class = "form-control" id="due_to" name="due_to">
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
	  				<td>Main Category:</td>
	  				<td>
	  				<?php
	                  	
	                  	$main_result = $con->query('select * from main_system order by system_name');
	                ?>
	                	<select name="system_name" id="main-list" class = "form-control">
		                    <option value="" selected visited disabled>Select Main System Category</option>
		                    <?php
								if ($main_result->num_rows > 0) {
									while($row = $main_result->fetch_assoc()) {
		                    ?>
		                    	<option value="<?php echo $row["main_id"]; ?>"><?php echo $row["system_name"]; ?></option>
		                    <?php
		                      		}
		                    	}
		                    ?>
	                	</select>
	  				</td>
	  			</tr>
	  			 <tr>
	  				<td>Sub System:</td>
	  				<td>
	  					<select name="subsys_name" id="sub-list" class = "form-control">
		                  	<option value='' selected visited disabled>Select Sub System Category</option>
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
		         	<td>Other Information:</td>
		         	<td><input type='text' name='others' placeholder="Other Information" class = "form-control"></td>
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
<!-- <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
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
	             window.location='view_records.php';
	         	  }
	      	});
		}
	}
</script>
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
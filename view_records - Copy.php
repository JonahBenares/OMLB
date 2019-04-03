<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	$userid=$_SESSION['userid'];
	$usertype=$_SESSION['usertype'];
    $today=date("Y-m-d");
?>
<style>
	input[type=submit] {
    font-family: 'Open Sans', sans-serif;
    font-size: 15px;
    background: #3eb8ff;
    color: #fff;
    border: none;
    padding: 8px 28px 10px 26px;
    -moz-border-radius: 4px;
    border-radius: 4px;
	}
</style>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<body onload="startTime()">
<?php include 'navbar.php';?>
    <div class="container"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit ">
	      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >View Records</dtitle>
			  		<hr>
			  		<form method = "GET">
				  		<table>
				  			<tr>
				  				<td>
				  					<input type = "date" name = "date_from" id="date_from"  class = "form-control">
				  				</td>
				  				<td>
				  					<input type="date" class = "form-control" id="date_to" name="date_to">
				  				</td>
				  				<td>
					  				<?php
					                  	$unit_result = $con->query('select * from unit order by unit_name');
					                ?>
					                <select name="unit_name" id = "unit_name" class = "form-control" style = "width:170px;">
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
				  				<td>
				  				<?php
				                  	$main_result = $con->query('select * from main_system order by system_name');
				                ?>
				                	<select name="system_name" id="main-list" class = "form-control" style = "width:170px;">
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
				  				<td>
				  					<select name="subsys_name" id="sub-list" class = "form-control" style = "width:170px;">
					                  	<option value='' selected visited disabled>Select Sub System Category</option>
					                </select>
								</td>
								<td>
									<select name="status" class = "form-control" style = "width:170px;">
					                  	<option value='' selected visited disabled>Select Status</option>
					                  	<option value='Finish'>Finish</option>
					                  	<option value='On-Going'>On-Going</option>
					                </select>
					            </td>
				  				<td>
									<input class="btn btn-fill btn-info" type = "submit" value = "Generate" name = "submit">
								</td>
				  			</tr>
				  		</table>				  			
			  		</form>	
			  		<div class="col-lg-12"><hr></div> 	
						<?php 
							$sql = "SELECT * FROM log_head";
							$url="";
							if(!empty($_GET)){
								$sql .= " WHERE"; 
								
								if(!empty($_GET['date_from'])){
									if(!empty($_GET['date_to'])){
										$sql .= " date_performed BETWEEN '$_GET[date_from]' AND '$_GET[date_to]' AND";
										$url.="datefrom=".$_GET['date_from']."&dateto=".$_GET['date_to'];
									}else{
										$sql .= " date_performed BETWEEN '$_GET[date_from]' AND '$_GET[date_from]' AND";
										$url.="datefrom=".$_GET['date_from']."&dateto=".$_GET['date_from'];
									}
								}
								if(!empty($_GET['unit_name'])){
									$sql .= " unit =  '$_GET[unit_name]' AND";
									$url.="unit=".$_GET['unit_name'];
								}
								if(!empty($_GET['system_name'])){
									$sql .= " main_system =  '$_GET[system_name]' AND";
									$url.="main_system=".$_GET['system_name'];
								}
								if(!empty($_GET['subsys_name'])){
									$sql .= " sub_system =  '$_GET[subsys_name]' AND";
									$url.="sub_system=".$_GET['subsys_name'];
								}
								if(!empty($_GET['status'])){
									$sql .= " status =  '$_GET[status]' AND";
									$url.="status=".$_GET['status'];
								}
							}
							$q = substr($sql,-3);
							if($q == 'AND'){
								$sql = substr($sql,0,-3);
							}
							$query = mysqli_query($con,$sql);
						
					if($usertype=='admin'){	?>
					<a href='print-logs.php?<?php echo $url; ?>' target='_blank' class='btn btn-primary pull-right' style='margin-bottom:10px'>EXPORT</a>
					<?php } ?>
			  		<table class="table table-striped table-bordered table-hover" id="dt1">
				        <thead>
				          	<tr>
					            <th colspan="1">Date Performed</th>
					            <th>Unit</th>
					            <th>Main Category</th>
					            <th>Sub Category</th>
					            <th>Performed By</th>
					            <th>Status</th>
					            <th>Logged By</th>
					            <th>No. of Updates</th>
					            <th>Remaining Days</th>
					            <th>Action</th>
				          	</tr>
				        </thead>
				        <tbody>	
				        	<?php
			  					while($row = mysqli_fetch_array($query)){
			  					$getlogs=mysqli_query($con, "SELECT * FROM update_logs WHERE log_id = '$row[log_id]'");
				            	$row_logs = $getlogs->num_rows;
			  				?>	         
				          	<tr class="gradeA">
					            <td><?php echo $row['date_performed'];?></td>
					            <td><?php echo getInfo($con, 'unit_name', 'unit', 'unit_id',  $row['unit']);?></td>
					            <td><?php echo getInfo($con, 'system_name', 'main_system', 'main_id',  $row['main_system']);?></td>
					            <td><?php echo getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $row['sub_system']);?></td>
					            <td class="center"><?php echo $row['performed_by'];?></td>
					            <?php if($row['status'] == "Done") { ?>
					            	<td class="center">
					            		<center>
					            			<span class = "label label-success"><?php echo $row['status'];?></span>
					            		</center>
					            	</td>
					            <?php } else if($row['status'] == "On-Progress") { ?>
					            	<td class="center">
					            		<center>
					            			<?php if($row['logged_by'] == $userid){ ?>
					            			<a onclick = "myFunction(<?php echo $row['log_id']; ?>)" style = "cursor:pointer;"><span class = "label label-warning" id = "demo" style="color:black"><?php echo $row['status'];?></span></a>
					            			<?php } else { ?>
											<span class = "label label-warning" style="color:black"><?php echo $row['status'];?></span>
					            			<?php } ?>
					            		</center>
					            	</td>
					            <?php } else { ?>
					            	<td class="center">
					            		<center>
					            			<span class = "label label-success"><?php echo $row['status'];?></span>
					            		</center>
					            	</td>
					            <?php }?>
					            <td class="center"><?php echo getInfo($con, 'fullname', 'users', 'user_id', $row['logged_by']);?></td>
					           
					             <td class="center"><?php echo $row_logs;?></td>
					             <td class="center">
					             	<?php 
					             		$diff = dateDifference($row['due_date'],$today);
					             		echo $diff;
					             	?>
					             </td>
					            <td>
					            	<center>
						            	<a href = "view_rec.php?id=<?php echo $row['log_id']; ?>" class="btn btn-success btn-xs" ><span class="fa fa-eye" aria-hidden="true"></span> </a>
						            	<?php if($row['logged_by'] == $userid){ ?>
						            	<a class="btn btn-primary btn-xs" href='update_rec.php?id=<?php echo $row['log_id']; ?>'><span class="fa fa-pencil-square-o" aria-hidden="true"></span> </a>
						            	<?php } ?>
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
         	"bSort": false,
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
</html>
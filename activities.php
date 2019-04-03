<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
?>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<style type="text/css">
	label{
        color: white;
    }
    .dataTables_info{
        color: white!important;
    }
    a#dt1_previous.paginate_button.previous.disabled{
        color: white!important;
    }
    a#dt1_next.paginate_button.next.disabled{
        color: white!important;
    }
    a#dt1_previous.paginate_button.previous{
        color: white!important;
    }
    a#dt1_next.paginate_button.next{
        color: white!important;
    }
    a#dt1_next.paginate_button.next{
        color: white!important;
    }
    a.paginate_button {
    	color: white!important;
    }
    select{
    	color: black;
    }
    .cancelled{
    	background-color: #605c5c;
    	color:#7c7979;

    }
    label input{
    	color: black;
    }
</style>
<body onload="startTime()">


  	<?php	include 'navbar.php';?>
    <div class="container"> 
   
      	<div class="row side-nav">
        	<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
		  		<dtitle></dtitle>
		  		<hr style="margin:0px">	      			
		  			<div class="clockcenter">
		  				<br>	
		  				<p style="margin:0px;padding:0px"><?php echo date("F j, Y") ?></p>
			      		<digiclock id="txt">12:45:25</digiclock>
		      		</div>
		      	<hr style="margin:0px">
		      	<a href="index.php" class="btn btn-dark btn-md " style="width:100%">Dashboard</a>
		      	<a href="activities.php" class="btn btn-dark btn-md active" style="width:100%">Activities</a>
		      	<a href="reports.php" class="btn btn-dark btn-md" style="width:100%">Reports</a>
		      	<br>
				<br>
				<br>
				<br>				
				<hr>
				<div class="info-user">
					<span aria-hidden="true" class="li_user fs1"></span>
					<span aria-hidden="true" class="li_settings fs1"></span>
					<span aria-hidden="true" class="li_mail fs1"></span>
					<span aria-hidden="true" class="li_key fs1"></span>
				</div>
			</div>
		</div>      
        <div class="col-sm-9 col-lg-9">
      		<div class="dash-unit">
		  		<dtitle style="color:#b2c831" >Activities</dtitle>
		  		<hr>
		  		<div class="col-lg-6"></div>
		  		<div class="col-lg-6" style="margin-bottom:10px">
		  			<div class="col-lg-3 pull-right">
		  				<a href="add_activities.php" class="btn btn-success btn-sm">Add Activity</a>
		  			</div>
		  		</div>
		  		<table class="table table-striped table-bordered table-hover" id="dt1">
			        <thead>
			          	<tr>
				            <th colspan="1">Date Performed</th>
				            <th>Main Category</th>
				            <th>Sub Category</th>
				            <th>Item Category</th>
				            <th>Notes</th>
				            <th>Performed By</th>
				            <th>Logged By</th>
				            <th>Status</th>
				            <th>Action</th>
			          	</tr>
			        </thead>
			        <tbody>	
			        	<?php 
		  					$sql = mysqli_query($con,"SELECT * FROM logs ORDER BY status ASC");
		  					while($row = mysqli_fetch_array($sql)){
		  					if($row['status'] == "Cancelled"){
		  				?>		         
		  				<tr class="gradeA">
				            <td class="cancelled"><?php echo date('m/d/Y',strtotime($row['date_performed']));?></td>
				            <td class="cancelled"><?php echo getInfo($con, 'cat_name', 'main_cat', 'main_id',  $row['main_id']);?></td>
				            <td class="cancelled"><?php echo getInfo($con, 'sub_name', 'sub_cat', 'sub_id',  $row['sub_id']);?></td>
				            <td class="center cancelled"><?php echo getInfo($con, 'item_name', 'item', 'item_id', $row['item_id']);?></td>
				            <td class="center cancelled"><?php echo $row['notes'];?></td>
				            <td class="center cancelled"><?php echo $row['performed_by'];?></td>
				            <td class="center cancelled"><?php echo $row['logged_by'];?></td>
				            <td class="center cancelled">
				            	<span class="label label-danger"><?php echo $row['status'];?></span>
				            </td>
				            <td class="center cancelled"></td>
			         	</tr>
			         	 <?php }  else{ ?>
			          	<tr class="gradeA">
				            <td><?php echo date('m/d/Y',strtotime($row['date_performed']));?></td>
				            <td><?php echo getInfo($con, 'cat_name', 'main_cat', 'main_id',  $row['main_id']);?></td>
				            <td><?php echo getInfo($con, 'sub_name', 'sub_cat', 'sub_id',  $row['sub_id']);?></td>
				            <td class="center"><?php echo getInfo($con, 'item_name', 'item', 'item_id', $row['item_id']);?></td>
				            <td class="center"><?php echo $row['notes'];?></td>
				            <td class="center"><?php echo $row['performed_by'];?></td>
				            <td class="center"><?php echo $row['logged_by'];?></td>
				            <td class="center">
				            	<span class="label label-danger"><?php echo $row['status'];?></span>
				            </td>
				            <td class="center">
					            <center>
					            	<a value = "Cancel" onclick="confirmationDelete(this);return false;" class = "label label-success" href = "update_record.php?id=<?php echo $row['log_id']; ?>"><i class= "li_trash"> Cancel</i></a>
					            </center>
				            </td>
			         	</tr>
			         	<?php }  }?>
			        </tbody>
			    </table>
			</div>
        </div>
    </div> 
</div> <!-- /container -->
<div id="footerwrap">
  	<footer class="clearfix"></footer>
  	<div class="container">
  		<div class="row">
  			<div class="col-sm-12 col-lg-12">
	  			<p><span></span></p>
	  			<p>REPAIR AND MAINTENANCE MANAGEMENT SYSTEM - Copyright <script>document.write(new Date().getFullYear())</script></p>
  			</div>
  		</div><!-- /row -->
  	</div><!-- /container -->		
</div><!-- /footerwrap -->      
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
</script>
</html>
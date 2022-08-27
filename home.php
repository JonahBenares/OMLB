<?php 
include 'header.php';
include 'includes/connection.php';
include 'includes/functions.php';
$usertype=$_SESSION['usertype'];
$userid=$_SESSION['userid'];

?>
<script>
	function changePassword(user_id){
	  	window.open('change_pass_user.php?id='+user_id, '_blank', 'width=600,height=500');
	}
</script>
<style type="text/css">
	.section-graph{
		height: 370px!important;
		
	}
	.top{
		max-height: 1000px;
		min-height: 510px;
	}
	.time{
		font-size: 100px;
	}
	.title{
		color: #b2c831;
	}
	.class_show{
		display: none;
	}

	.reminder{
		background-color:#d9534f;
		padding:10px 20px 10px 20px; 
		min-width:200px;
		max-width:500px;
		min-height:130px;
		position:fixed;
		left:1050px;
		border-radius: 20px;
		border-color:#d43f3a;
		color: #fff;
	}
	.badge-style{
		background-color:#5bc0de;border-color: #46b8da;color:#474747
	}
	.alert-text{
		font-weight:bold;text-shadow:1px 1px 5px black;
	}
</style>
<body onload="startTime()">

  	<!-- <?php	//include 'navbar.php';?> -->
    <div class="container"> 

      	<div class="row top">
      		<div class="col-lg-12">
				<div class="row">	
					<?php 
					$overdue=overdueTasks($con);
					$thisweek=tasksThisWeek($con);
					if($overdue != 0 || $thisweek != 0){ ?>
					<div class="reminder shadow" style="">
						<center><h4 class="alert-text">Alert <span class="fa fa-warning"> </span></h4></center>
						<hr style="margin:0px 0px 1px 0px;">	
						<?php if($overdue!=0) { ?>
							<p style="margin:2px">	Overdue Task/s: <span class="badge shadow badge-style"><?php echo $overdue; ?></span></p>
						<?php }
						if($thisweek!=0) { ?>
						<p> Task/s this week: <span class="badge shadow badge-style" ><?php echo $thisweek; ?></span></p></p>
						<?php } ?>
						<center><a href="reminders.php" class="label label-warning shadow" style="color:#474747">View More</a></center>

					</div>
					<?php } ?>
					<center>
						<digiclock id="txt" class="time">12:45:25</digiclock>
						<h1 style="color:white"><?php echo date("F j, Y") ?></h1>
						<hr>
						<h1 class="title">OPERATIONS AND MAINTENANCE LOGBOOK</h1>
						<hr>
					</center>
				</div>
      			<div class="row">
      				<center>
      					<?php if($usertype == 'admin'){ ?>
      					<a href="masterfile.php" class="btn btn-dark btn-md" id="masterfile" >
							<center>
		      					<span class="fa fa-address-book" aria-hidden="true" style="font-size:50px"></span><br>
		      					Masterfile
		      				</center>
	      				</a>
	      				<?php } ?>
	      				<a href="reminders.php" class="btn btn-dark btn-md" id="masterfile" >
							<center>
		      					<span class="fa fa-exclamation" aria-hidden="true" style="font-size:50px"></span><br>
		      					Reminders
		      				</center>
	      				</a>
	      				<a href="enternew.php" class="btn btn-dark btn-md" id="enter_new">
							<center>
		      					<span class="fa fa-sign-in" aria-hidden="true" style="font-size:50px"></span><br>
		      					Enter New Record
		      				</center>
	      				</a>
	      				<a href="view_latest.php" class="btn btn-dark btn-md" id="view_update">
							<center>
		      					<span class="fa fa-eye" aria-hidden="true" style="font-size:50px"></span><br>
		      					View/Update Record
		      				</center>
	      				</a>
	      				<a href="all_reports.php" class="btn btn-dark btn-md" id="all_reports">
							<center>
		      					<span class="fa fa-book" aria-hidden="true" style="font-size:50px"></span><br>
		      					All Reports
		      				</center>
	      				</a>
	      				
	      			
      				</center>
      			</div>
      			<?php 
  					$sql = mysqli_query($con,"SELECT * FROM users where user_id = '$userid'");
  					$row = mysqli_fetch_array($sql);
  				?>
      			<div class="row">
      				<center>
      					<div class="container" style="padding:0px 110px 0px 110px">
      						<a href="#" onClick="changePassword(<?php echo $row['user_id']; ?>)" class="btn btn-dark btn-md " style="height:50px;padding:10px;">
								<center>
			      					<span class="glyphicon glyphicon-lock"> </span> Change Password
			      				</center>
		      				</a>
		      				<a href="logout.php" class="btn btn-dark btn-md " style="height:50px;padding:10px;">
								<center>
			      					<span class="glyphicon glyphicon-log-out"> </span> Logout
			      				</center>
		      				</a>
		      			</div>
      				</center>
      			</div>
      		</div>

      		<!-- <div class="pull-left" id="mastersub">
				<a href="add_user.php" class="btn btn-dark btn-md" style="height:50px;padding:10px;">
				<center>
  					<span class="glyphicon glyphicon-user"> </span> User
  				</center>
				</a>
				<a href="add_user.php" class="btn btn-dark btn-md" style="height:50px;padding:10px;">
				<center>
  					<span class="glyphicon glyphicon-user"> </span> Employees
  				</center>
				</a>
			</div> -->	   
	      	<!-- <div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
			  		<dtitle></dtitle>
			  		<hr style="margin:0px">	      			
			  			<div class="clockcenter">
			  				<br>	
			  				<p style="margin:0px;padding:0px"><?php echo date("F j, Y") ?></p>
				      		<digiclock id="txt">12:45:25</digiclock>
			      		</div>
			      	<hr style="margin:0px">
			      	<a href="index.php" class="btn btn-dark btn-md active" style="width:100%">Dashboard</a>
			      	<a href="activities.php" class="btn btn-dark btn-md" style="width:100%">Activities</a>
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
			</div> -->
      
	       <!--  <div class="col-sm-9 col-lg-9">
	      		<div class="dash-unit">
			  		<dtitle style="color:#b2c831">DASHBOARD</dtitle>
			  		<hr>
			  		<br>
			  		<br>
			  		<div class="section-graph" >
				      <div id="importantchart"></div>
				      <br>
				      <div class="graph-info">
				        <i class="graph-arrow"></i>
				        <span class="graph-info-big">634.39</span>
				        <span class="graph-info-small">+2.18 (3.71%)</span>
				      </div>
				    </div>
			  			
				</div>
	        </div> -->     
      	</div>
	</div>
	<?php	include 'footer.php';?>
          
</body>
<script type="text/javascript" src="js/lineandbars.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script src="js/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
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

	
	$('#datepicker').datepicker();
</script>

</html>
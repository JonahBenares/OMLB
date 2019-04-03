
<!doctype html>
<html><head>
    <meta charset="utf-8">
   	<title>Operations and Maintenance Logbook </title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="CENPRI">
    <link rel="icon" href="images/oplogo.png">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    

    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/css/font-awesome.css" rel="stylesheet">
    
    
    <!-- <link href="css/table.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.7.3/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    

    <script type="text/javascript" src="js/jquery.js"></script>       
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/gauge.js"></script>	
	<script src="js/jquery.flexslider.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/admin.js"></script>    
</head>
<?php 
//include 'header.php'; 
include 'includes/connection.php';

if(isset($_POST['login'])){
	foreach($_POST as $var=>$value)
		$$var = mysqli_real_escape_string($con, $value);
	$pass = md5($password);
	$get=$con->query("SELECT * FROM users WHERE username = '$username' AND (password='$password' OR password = '$pass')");
	$rows = $get->num_rows;
	$fetch=$get->fetch_array();
	if($rows>0){
		session_start();
		$_SESSION['userid'] = $fetch['user_id'];
		$_SESSION['username'] = $fetch['username'];
		$_SESSION['fullname'] = $fetch['fullname'];
		if($fetch['usertype_id'] == 1) $_SESSION['usertype'] = 'admin';
		if($fetch['usertype_id'] == 2) $_SESSION['usertype'] = 'staff';

		echo "<script>window.location = 'home.php';</script>";
	} else {
		echo "<script>alert('Username/Password incorrect.'); window.location = 'index.php';</script>";
	}


} ?>
<style type="text/css">
	.section-graph{
		height: 370px!important;
		
	}
	.top{
		max-height: 1000px;
		min-height: 530px;
	}
	.time{
		font-size: 100px;
	}
	.title{
		color: #b2c831;
	}
	input[type=password], textarea {
    background: #cdcbcc;
    font-size: 13px;
    display: block;
    width: 100%;
    border: none;
    box-shadow: none;
    height: 30px;
    line-height: 18px;
    padding: 0;
    text-indent: 18px;
    margin: 0 0 18px;
	}
	.block{
		text-align:center; 
		padding:30px;
		background-color: #313131;
		border-radius: 10px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	#username{
		border-radius: 10px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	#password{
		border-radius: 10px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	.img-circle , .submit{
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	.unit{
		padding: 10px;
	}
	.unit:hover{
		padding: 10px;
		border: 1px solid #c0d834;
		border-radius: 10px;
	}
</style>
<body onload="startTime()">

  	<!-- <?php	//include 'navbar.php';?> -->
    <div class="container"> 

      	<div class="row top">
      		<div class="col-lg-12">
      			<div class="row">
      				<div class="container">
				        <div class="row">
					   		<div class="col-lg-offset-4 col-lg-4" style="margin-top:100px">
					   			<div class="unit">
						   			<div class="block-unit block" >
						   				<img src="images/oplogo.png" style="width:80px;height:80px" alt="avatar" class="img-circle">
						   				<h5>OPERATIONS AND MAINTENANCE LOGBOOK  </h5>
						   				<hr style="margin-bottom:0px; border-color: #b8ba10 ">
						   				<br>
										<form class="cmxform" id="signupForm" method="POST" >
											<fieldset>
												<p>
													<input id="username" name="username" type="text" placeholder="Username">
													<input id="password" name="password" type="password" placeholder="Password">
												</p>
													<input class="submit btn-success btn btn-large" type="submit" name='login' value="Login">
											</fieldset>
										</form>
						   			</div>	
						   		</div>					   		
					   		</div>
				        </div>
				    </div>
      			</div>
      		</div>
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
<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
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
	.hayt{
		height:500px;
	}
</style>
<script>
    $(document).ready(function(){
		$("#fullname").keyup(function(){
			$.ajax({
			type: "POST",
			url: "search-user.php",
			data:'fullname='+$(this).val(),
			beforeSend: function(){
			  $("#fullname").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
			  $("#suggestion-fullname").show();
			  $("#suggestion-fullname").html(data);
			  $("#fullname").css("background","#FFF");
			}
			});
		});
   });
    $(document).ready(function(){
		$("#username").keyup(function(){
			$.ajax({
				type: "POST",
				url: "search-username.php",
				data:'username='+$(this).val(),
				beforeSend: function(){
				  $("#username").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data){
				  $("#suggestion-username").show();
				  $("#suggestion-username").html(data);
				  $("#username").css("background","#FFF");
				}
			});	
		});
   	});
    function selectUser(val) {
        $("#fullname").val(val);
        $("#suggestion-fullname").hide();
    }
    function selectUsername(val) {
        $("#username").val(val);
        $("#suggestion-username").hide();
    }
</script>
<style>
 #name-user{float:left;list-style:none;margin-top:-17px;padding:0;width:335px;position: absolute; z-index:1;}
    #name-user li:hover {
        background: #28422c;
        cursor: pointer;
        font-weight: bold;
        color: white;
    }
    #name-user li {
        padding: 5px;
        background-color: #b5e8bb;
        border-bottom: #bbb9b9 1px solid;
        border-radius: 10px;
    }
#search-user{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<body onload="startTime()">
<?php include 'navbar.php';?>
	<!--MODAL-->
	<!-- <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
	      	</div>
	      	<div class="modal-body">	        
	          
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
	      	</div>
	    	</div>
	  	</div>
	</div>  -->



    <div class="container"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit hayt ">
	      			<!-- <a href = "view_user.php" class = "btn btn-primary pull-right fa fa-eye" style = "margin-top:5px;">View User</a><br> -->
	      			<a href="masterfile.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >Add User</dtitle>
			  		<hr>
			  			<center>
			  				<h5 style="font-size:20px"><strong>Add New User</strong></h5>
			  			</center>
			  		<hr>
			  		<div class="col-lg-3"></div>
			  		<div class="col-lg-6">
				  		<form method = "POST" action = "add_user_ins.php">
				  			<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Last Name, First Name, Middle Initial" autocomplete="off" required>
				  			<span id="suggestion-fullname"></span>
				  			<input type="text" name="username" id = "username" class="form-control" placeholder="Username" autocomplete="off" required>
				  			<span id="suggestion-username"></span>
				  			<input type="password" id="password" name='password' class = "form-control password" placeholder="Password" required><br>
                            <input type="password" name='confirm_password' id="confirm_password" class = "form-control confirm_password"   onchange = "val_cpass()" placeholder="Confirm Password" required>
                            <div  class = "alert alert-danger" id="cpass_msg" style = "display:none; width:100%; height:50px;text-align:center;">
                                <h6 style="color:red">Confirm Password not Match!</h6>
                            </div><br>

				  			
				  			<input type="submit" id = "submit" name = "submit" class="btn btn-md btn-primary" value="Submit" style="width:100%">
				  		</form>
			  		</div>
			  		<div class="col-lg-3"></div>
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
	function val_cpass() {
	    var password = $(".password").val();
	    var confirm_password = $(".confirm_password").val();
	    if(password != confirm_password) {
	        $("#cpass_msg").show();
	        $("#cpass_msg").html("Confirm password not match!");
	        // $("#btn_save").hide();
	    }
	    else{
	        $("#cpass_msg").hide();
	        $("#btn_save").show();
	    }
	}
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
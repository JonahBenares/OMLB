<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    else{
        $id = "";
    }
?>
<script>
  	$(document).ready(function(){
		$("#employee_name").keyup(function(){
			$.ajax({
			type: "POST",
			url: "search-employee.php",
			data:'employee_name='+$(this).val(),
			beforeSend: function(){
			  $("#employee_name").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
			  $("#suggestion-employee_name").show();
			  $("#suggestion-employee_name").html(data);
			  $("#employee_name").css("background","#FFF");
			}
			});
		});
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


  	$(document).ready(function(){
		$("#position").keyup(function(){
			$.ajax({
			type: "POST",
			url: "search-position.php",
			data:'position='+$(this).val(),
			beforeSend: function(){
			  $("#position").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
			  $("#suggestion-position").show();
			  $("#suggestion-position").html(data);
			  $("#position").css("background","#FFF");
			}
			});
		});
   });

  	function selectEmp(val) {
        $("#employee_name").val(val);
        $("#suggestion-employee_name").hide();
    }

    function selectPosition(val) {
        $("#position").val(val);
        $("#suggestion-position").hide();
    }
    function selectUsername(val) {
        $("#username").val(val);
        $("#suggestion-username").hide();
    }
</script>
<style type="text/css">
	input[type=submit] {
    font-family: 'Open Sans', sans-serif;
    font-size: 15px;
    background: #b2c831;
    color: #000;
    border: none;
    padding: 8px 28px 10px 26px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    font-weight: bold;
	}
	input[type=submit]:hover {
    font-family: 'Open Sans', sans-serif;
    font-size: 15px;
    background: #81921e;
    color: #fff;
    border: none;
    padding: 8px 28px 10px 26px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    font-weight: bold;
     box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	.hayt{
		height:500px;
	}
.btn-active{
	background-color: #e8ff61;
    border-radius: 0px;
    border-radius: 20px;
    padding: 40px;
    font-size:20px;
    color: black;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    margin:10px; 
}
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
        color: black;
        font-weight: bold;
    }
#search-user{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<script src = "js/jquery.min.js" type="text/javascript"></script>
<body onload="startTime()">
<?php include 'navbar.php';?>
    <div class="container" style="width: 1300px;"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit" style="margin-bottom:5px"> 
	      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >MasterFile / Employee</dtitle>
			  		<hr style="margin:0px">
			  			<center>			  				
							<a href="add_new_department.php" id="user" class="btn btn-dark btn-md" style="height:50px;padding:10px;">
								<center>
				  					<span class="glyphicon glyphicon-user"> </span> Department
				  				</center>
							</a>
							<a href="add_new_emp.php" id="employee" class="btn btn-dark btn-md" style="height:50px;padding:10px;">
								<center>
				  					<span class="glyphicon glyphicon-user"> </span> Employees
				  				</center>
							</a>			
			  			</center>
			  		<hr>		
				</div>
				<!-- <div id="user_table">
					<div class="col-lg-4" style="padding-left:0px;padding-right:5px;">
			      		<div class="dash-unit">
					  		<dtitle style="color:#b2c831">Add new user</dtitle>
					  		<hr>
					  		<div style="padding:10px">
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
						</div>
			        </div>
			        <div class="col-lg-8" style="padding-right:0px;padding-left:5px">
			      		<div class="dash-unit">
					  		<dtitle style="color:#b2c831">User List</dtitle>
					  		<hr>
				        	<table class="table table-striped table-bordered table-hover" id="dt1_user">
						        <thead>
						          	<tr>
							            <th colspan="1">Fullname</th>
							            <th>Username</th>
							            <th>Usertype</th>
						          	</tr>
						        </thead>
						        <tbody>	
						        	<?php 
					  					$sql = mysqli_query($con,"SELECT * FROM users ORDER BY fullname DESC");
					  					while($row = mysqli_fetch_array($sql)){
					  				?>		         
						          	<tr class="gradeA">
							           <td><?php echo $row['fullname']?></td>
							           <td><?php echo $row['username']?></td>
							           <td><?php echo getInfo($con, 'usertype_name', 'usertype', 'usertype_id',  $row['usertype_id']);?></td>
						         	</tr>
						         	<?php } ?>
						        </tbody>
						    </table>
				        	
						</div>
			        </div>
		        </div> -->
		        <div id="employee_table">
					<div class="col-lg-4" style="padding-left:0px;padding-right:5px;">
			      		<div class="dash-unit">
					  		<dtitle style="color:#b2c831">Add new employee</dtitle>
					  		<hr>
					  		<div style="padding:10px">
					        	<form method = "POST" action = "add_emp_ins.php">
						  			<input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Last Name, First Name, Middle Initial" autocomplete="off" required>
						  			<span id="suggestion-employee_name"></span>
						  			<input type="text" name="position" id = "position" class="form-control" placeholder="Position" autocomplete="off" required>
						  			<span id="suggestion-position"></span>
						  			<select type="text" id="department" name='department' class = "form-control " placeholder="Department" required>
						  				<option selected="" visited disabled="">--Select Department--</option>
						  				<?php						                 
						                  $sql1 = mysqli_query($con, 'select * from department order by department_name');
						                  while ($row = mysqli_fetch_array($sql1)) {
						                ?>
						  				<option value="<?php echo $row['department_id']?>"><?php echo $row["department_name"]?></option>
						  				<?php } ?>
						  			</select>

			                        <br>
	                        		<span><input type = "radio" name = "access" id = "withaccess" value = "1" onclick="giveaccess()">&nbspWith Access</span>
	                        		<br>
	                        		<span><input type = "radio" name = "access" id = "woaccess" value = "0" onclick="giveaccess()">&nbspWithout Access</span><br><br>
	                        		<div id = "login">
		                        		<input style = "display:none" type="text" name="username" id = "username" class="form-control" placeholder="Username" autocomplete="off" >
					  					<span id="suggestion-username"></span>
		                        		<input style = "display:none" type="password" id="password" name='password' class = "form-control password" placeholder="Password" ><br>
			                            <input style = "display:none" type="password" name='confirm_password' id="confirm_password" class = "form-control confirm_password" onchange = "val_cpass()" placeholder="Confirm Password" >
			                            <div  class = "alert alert-danger" id="cpass_msg" style = "display:none; width:100%; height:50px;text-align:center;">
			                                <h6 style="color:red">Confirm Password not Match!</h6>
			                            </div>
		                            </div>
		                            <br>
						  			<input type="submit" id = "submit" name = "submit" class="btn btn-md btn-primary" value="Submit" style="width:100%">
					  			</form>
				  			</div>
						</div>
			        </div>
			        <div class="col-lg-8" style="padding-right:0px;padding-left:5px">
			      		<div class="dash-unit">
					  		<dtitle style="color:#b2c831">Employee List</dtitle>
					  		<hr>
				        	<table class="table table-striped table-bordered table-hover" id="dt2_employee">
						        <thead>
						          	<tr>
							            <th colspan="1">Employee Name</th>
							            <th>Position</th>
							            <th>Department</th>
							            <th>Access</th>
							            <th>Action</th>
						          	</tr>
						        </thead>
						        <tbody>	
						        	<?php 
					  					$sql = mysqli_query($con,"SELECT * FROM employees ORDER BY employee_name ASC");
					  					while($row = mysqli_fetch_array($sql)){
					  				?>		         
						          	<tr class="gradeA">
							           <td><?php echo $row['employee_name']?></td>
							           <td><?php echo $row['position']?></td>
							           <td><?php echo getInfo($con, 'department_name', 'department', 'department_id',  $row['department_id']);?></td>
							           <td><?php echo (($row['access']==1) ? 'Yes' : 'No'); ?></td>
							           <td>
							           		<a href = "edit_user.php?id=<?php echo $row['user_id'];?>" class = "btn btn-primary">Update</a>	
							           </td>
						         	</tr>
						         	<?php } ?>
						        </tbody>
						    </table>
				        	
						</div>
			        </div>
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
        $('#dt1_user').dataTable({
         	"bSort": false,
         	"order": [[0 , "desc"]]
        });
    });
    $(document).ready(function () {
        $('#dt2_employee').dataTable({
         	"bSort": false,
         	"order": [[0 , "desc"]]
        });
    });

	// $("#user_table").hide();
	// $("#employee_table").hide();
	// $("#user").removeClass("btn-dark");
 //    $("#user").addClass("btn-active");
	// $("#user").click(function(){
	//     $("#user_table").show();
	//     $("#employee_table").hide();
	    
	//     $("#employee").removeClass("btn-active");
	//     $("#employee").addClass("btn-dark");

	// });
	$("#employee").removeClass("btn-dark");
	$("#employee").addClass("btn-active");
	$("#employee").click(function(){
		$("#employee_table").show();
	    $("#user_table").hide();
	    
	    $("#user").removeClass("btn-active");
	    $("#user").addClass("btn-dark");


	});

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

    function giveaccess(){
   	if(document.getElementById('withaccess').checked) {
		$("#username").show();
		$("#password").show();
		$("#confirm_password").show();
   	}
   	if(document.getElementById('woaccess').checked) {
   		$("#username").hide();
		$("#password").hide();
		$("#confirm_password").hide();
   	}
}
</script>
</html>
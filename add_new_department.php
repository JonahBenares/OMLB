<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
?>

<script>
    $(document).ready(function(){
		$("#department_name").keyup(function(){
			$.ajax({
			type: "POST",
			url: "search-department.php",
			data:'department_name='+$(this).val(),
			beforeSend: function(){
			  $("#department_name").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
			  $("#suggestion-department_name").show();
			  $("#suggestion-department_name").html(data);
			  $("#department_name").css("background","#FFF");
			}
			});
		});
   });
   
    function selectDepartment(val) {
        $("#department_name").val(val);
        $("#suggestion-department_name").hide();
    }
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<script src = "js/jquery.min.js" type="text/javascript"></script>
<body onload="startTime()">
<?php include 'navbar.php';?>
    <div class="container" style="width: 1300px;"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit" style="margin-bottom:5px"> 
	      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >MasterFile / Department</dtitle>
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
				<div id="loader">
			        <figure class="one"></figure>
			        <figure class="two">loading</figure>
			    </div>
			    <div id="contents" style="display: none">  
					<div id="user_table">
						<div class="col-lg-4" style="padding-left:0px;padding-right:5px;">
				      		<div class="dash-unit">
						  		<dtitle style="color:#b2c831">Add Department</dtitle>
						  		<hr>
						  		<div style="padding:10px">
						        	<form method = "POST" action = "add_dept_ins.php">
							  			<input type="text" name="department_name" id="department_name" class="form-control" placeholder="Department Name" autocomplete="off" required style="text-transform:capitalize;">
							  			<span id="suggestion-department_name"></span>
							  			
							  			<input type="submit" id = "submit" name = "submit" class="btn btn-md btn-primary" value="Submit" style="width:100%">
						  			</form>
					  			</div>
							</div>
				        </div>
				        <div class="col-lg-8" style="padding-right:0px;padding-left:5px">
				      		<div class="dash-unit">
						  		<dtitle style="color:#b2c831">Department List</dtitle>
						  		<hr>
					        	<table class="table table-striped table-bordered table-hover" id="dt1_user">
							        <thead>
							          	<tr>
								            <th>Department</th>
								            <th width = "10%">Action</th>
							          	</tr>
							        </thead>
							        <tbody>	
							        	<?php 
						  					$sql = mysqli_query($con,"SELECT * FROM department ORDER BY department_name Asc");
						  					while($row = mysqli_fetch_array($sql)){
						  				?>		         
							          	<tr class="gradeA" style="text-transform:capitalize;">
								           <td><?php echo $row['department_name']?></td>
								           <td>
								           		<center>
								           			<a href = "edit_department.php?id=<?php echo $row['department_id'];?>" class = "btn btn-primary btn-xs" title = "Update"><span class = "fa fa-edit"></span></a>
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
        	</div>
		</div> 
    </div> 
<?php include 'footer.php';?>
</body>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<script src="js/gijgo.min.js" type="text/javascript"></script>
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
	$("#user").removeClass("btn-dark");
    $("#user").addClass("btn-active");
	$("#user").click(function(){
	    $("#user_table").show();
	    $("#employee_table").hide();
	    
	    $("#employee").removeClass("btn-active");
	    $("#employee").addClass("btn-dark");

	});	

	function val_cpass() {
	    var password = $(".password").val();
	    var confirm_password = $(".confirm_password").val();
	    if(password != confirm_password) {
	        $("#cpass_msg").show();
	        $("#cpass_msg").html("Confirm password not match!");	     
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
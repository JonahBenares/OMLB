<?php include 'header.php'; ?>
<script>
function addAcitivities(){
	var data = $("#add-activities").serialize();
	$.ajax({
	     data: data,
	     type: "post",
	     url: "insert.php",
	     success: function(output){
	      /*document.location='uploadfiles.php?id='+output;*/
	      alert("Successfully Saved!");
	      document.location='activities.php';
	   }
	});
}
</script>
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
		<form method="POST" id ="add-activities" name = "addactivities">     
	        <div class="col-sm-9 col-lg-9">
	      		<div class="dash-unit">
			  		<dtitle style="color:#b2c831" >Add Activities</dtitle>
			  		<hr>
			  		<center>
			  			<label>Date:</label>
			  			<input type = "text" name = "date_performed" id="datepicker" class = "form-control" style="width:423px" >
			  			<?php
		                  	require_once('includes/connection.php');
		                  	$main_result = $con->query('select * from main_cat order by cat_name');
		                ?>
		                <label>Main Category:</label>
		                <select name="cat_name" id="main-list" class = "form-control" style = "width:423px;height:82%;margin-top:0px;">
		                    <option value="" selected visited disabled>Select Main Name Category</option>
		                    <?php
								if ($main_result->num_rows > 0) {
									while($row = $main_result->fetch_assoc()) {
		                    ?>
		                    	<option value="<?php echo $row["main_id"]; ?>"><?php echo $row["cat_name"]; ?></option>
		                    <?php
		                      		}
		                    	}
		                    ?>
		                </select>
		                <label>Sub Category:</label>
		                <select name="sub_name" id="sub-list" class = "form-control" style = "width:423px;height:82%;;margin-top:0px;">
		                  	<option value='' selected visited disabled>Select Sub Name Category</option>
		                </select>
		                <label>Item Category:</label>
		                <select name="item_name" id="items-list" class = "form-control" style = "width:423px;height:82%;;margin-top:0px;">
		                  	<option value='' selected visited disabled>Select Item Name Category</option>
		                </select>
		        		<label>Notes:</label>
		        		<textarea class = "form-control" name = "notes" style = "width:423px"></textarea>
		        		<label>Performed By:</label>
		        		<textarea class = "form-control" name = "performed_by" style = "width:423px"></textarea>
		        		<label>Logged By:</label>
		        		<input type = "text" class = "form-control" name = "logged_by" style = "width:423px">
		        		<button onClick="addAcitivities()" type="button" class="btn btn-primary btn-fill">Save</button>
		        	</center>
				</div>
	        </div>
        </form>
    </div><!-- /row -->
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
<!-- <script src="js/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> -->
<script src="js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
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
$('#sub-list').on('change', function(){
	var id = this.value;
	$.ajax({
	type: "POST",
	url: "get_items.php",
	data:'id='+id,
		success: function(result){
			$("#items-list").html(result);
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
</script>
</html>
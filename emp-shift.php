<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	$userid=$_SESSION['userid'];
	$usertype=$_SESSION['usertype'];

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
<script>
function addShift(){
  window.open('add-shift.php', '_blank', 'width=1200,height=600');
}
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<body onload="startTime()">
<?php include 'navbar.php';?>
    <div class="container"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit ">
	      			<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >Employee Shift</dtitle>
			  		<hr>
			  		<a href='javascript:void(0)' onclick="addShift()" class='btn btn-success'>ADD SHIFT</a><br><br>	
			  		<table class="table table-striped table-bordered table-hover" id="dt1">
				        <thead>
				          	<tr>
					            <th colspan="1">Employee Name</th>
					            <th>Position</th>
					            <th>Shift</th>
					            <th>Date From/To</th>
				          	</tr>
				        </thead>
				        <tbody>	
				        	<tr>
				        		<td></td>
				        		<td></td>
				        		<td></td>
				        		<td></td>
				        	</tr>
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
	
s
</script>
</html>
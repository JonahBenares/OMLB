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
     <div class="container"> 
      	<div class="row">
        	<div class="col-lg-12">
	      		<div class="dash-unit">
	      			<a href="add_user.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >User List</dtitle>
			  	
			  		<div class="col-lg-12"><hr></div> 	
					
				    <table class="table table-striped table-bordered table-hover" id="dt1">
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
		</div> 
    </div> 
	<?php include 'footer.php';?>
</body>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<script src="js/gijgo.min.js" type="text/javascript"></script>
<!-- <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
$(document).ready(function () {
        $('#dt1').dataTable({
         	"bSort": true,
         	"aaSorting": [[0 , "desc"]]
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
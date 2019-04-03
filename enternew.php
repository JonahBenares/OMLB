<?php 
	include 'header.php';
	include 'includes/connection.php'; 
	include 'includes/functions.php';
	if(isset($_GET['from'])){ 
        $from = $_GET['from'];
        $to = $_GET['to'];
    }
    else{
        $from = '';
        $to = '';
    }
?>
<style type="text/css">
	table tbody tr td {
    background-color: #3d3d3d00;
    border: 1px solid #47474700!important;
	}
	input[type=radio] {
          border: 2px solid #000;
          padding: 1.01em;
          -webkit-appearance: none;
        }

        input[type=radio]:checked {
          background: url(images/check.png) no-repeat center center;
          background-size: 50px 50px;
        }

        input[type=radio]:focus {
          outline-color: transparent;
        }

        input[type=radio].sub {
          border: 2px solid #000;
          padding: 0.6em;
          -webkit-appearance: none;
        }

        input[type=radio].sub:checked {
          background: url(images/check.png) no-repeat center center;
          background-size: 30px 30px;
        }

        input[type=radio].sub:focus {
          outline-color: transparent;
        }
        .label {
            font-size: 15px;
        }

        .sub_system{
            padding: 35px 0px 10px 0px;
            background-color: #82b128;
            color: #000;
            width: 100%;
            font-weight:700!important; 
            height:90px;
            font-size:17px!important;

        }
        .border{
            border-left: 1px solid grey;
            height:700px;
        }

        input[type=radio]:checked + label {
          color: black;
          font-weight: 500!important;
          background-color: #b2c831;
          border-radius: 5px;
          border: 2px solid black;
          padding: 5px;
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        } 

</style>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" />
<body onload="startTime()">
  	<?php	include 'navbar.php';?>
    <div class="container" style = "width:100%"> 
      	<div class="row ">
        	<div class="col-lg-12">
	      		<div class="dash-unit top">
			  		<a href="home.php" class="btn btn-xs"><span class="fa fa-chevron-left"></span> BACK</a> //
			  		<dtitle style="color:#b2c831" >Enter new Record</dtitle>
			  		<hr>		  				
			  		<form method = "GET" action = "add_newact.php">
				  		<div class="col-lg-12">
				  			<div class="row">
				  				<div class="col-lg-12">
				  					<center>				  					
					  					<label style="font-size:50px">Choose Unit / Engine: </label>
					  				</center>								
								</div>
				  			</div>
				  			<div class="row">
					  			<?php
					  				$count = 1; 
		  							$sql1 = mysqli_query($con,"SELECT * FROM unit ORDER BY unit_id ASC");
		  							while($row1 = mysqli_fetch_array($sql1)){
		  						?>
					  				<div class="col-lg-2">
					  					<?php 
					  					if(empty($_GET['unit'])) { 
					  						$checked=''; ?>
					  						<label class="btn btn-black btn-sm" id="dg<?php echo $count; ?>">
					  						
					  					<?php } else { 
					  						if($_GET['unit'] == $count){ 
					  						$checked='checked'; ?>
					  						<label class="btn btn-green btn-sm" id="dg<?php echo $count; ?>">
					  							
					  					<?php } else { 
					  						$checked=''; ?>
					  						<label class="btn btn-black btn-sm" id="dg<?php echo $count; ?>">
					  						
					  					<?php }
					  					}	?>
					  					<input type="radio" id = "dgval<?php echo $count; ?>" name="unit" value = "<?php echo $row1['unit_id']; ?>" <?php echo $checked; ?>><br><?php echo $row1['unit_name']?></label>
									</div>
				  				<?php $count++; 
				  					} ?>
				  			</div>
				  			<br>
				  			<hr>
				  			<?php
		  					if(!empty($_GET['unit'])){ ?>
		  					<div class="row" id="category">
		  						<table class="table">
		  							<tr>
			  							<td colspan="2">
			  								<center>				  					
						  					<label style="font-size:50px">Choose Item: </label>
						  					</center>
						  				</td>
			  						</tr>
			  						<?php 
		  								$mainid=1; 
			  							$sql = mysqli_query($con,"SELECT * FROM main_system ms INNER JOIN unit_rel ur ON ms.main_id = ur.main_id WHERE ur.unit_id = '$_GET[unit]' ORDER BY ms.main_id ASC");
			  							while($row = mysqli_fetch_array($sql)) {
			  						?>
		  							<tr>
		  								<td width="20%" style="border-bottom:1px solid #fff!important" id='mainid<?php echo $mainid; ?>'  >
		  									<center style="height:100%">
			  									<label class="sub_system" style="border-radius:10px;font-size:15px" ><?php echo $row['system_name']?>
			  									</label>
		  									</center>
		  								</td>
		  								<td width="80%" style="border-bottom:1px solid #fff!important"> 
		  									<div class="flex-row">
			  									<?php 
			  										$get_no=$con->query("SELECT subsys_name FROM sub_system WHERE main_id = '$row[main_id]'");
			  										$rows_no = $get_no->num_rows;
			  										$rows=$rows_no/3; 
			  										$index=0;
			  										for($x=0;$x<$rows;$x++) { 
			  										$sql1 = $con->query("SELECT subsys_name, sub_id FROM sub_system WHERE main_id = '$row[main_id]' LIMIT $index,3");
			  									?>
		  										<div class="col-md-2">
		  											<?php
					  									while($fetch = $sql1->fetch_array()){ 
				  										$sname='';
						  								$subname=explode(" ",$fetch['subsys_name']);
						  								$subct=count($subname);
						  								//echo $subct;
						  								if($subct<=2){
						  									$sname=$fetch['subsys_name'];
						  								} 
						  								else {
						  									for($a=0;$a<$subct;$a++){
							  									if($a<2){
							  										$sname .= $subname[$a] . " "; 
							  									} else if($a==2) {
							  										$sname .= " <br>". $subname[$a] . " "; 
							  									} else {
							  										$sname .= $subname[$a]; 
							  									}
						  									}
						  								} 
								  					?>
				  									<input type="radio" id="items" name="items" class="sub" value = "<?php echo $fetch['sub_id']; ?>"> 
						  							<label><?php echo $sname; ?></label><br>
										  			<?php $count++; } ?>
				  								</div>	
				  								<?php $index+=3; } ?>
		  									</div>
		  								</td>
		  							</tr>
		  							<?php } } ?>
		  						</table>
					  			<br>				  			
					  			<br>
					  			<hr>
					  			<div id="button">
					  			<center>
					  				<input style="background-color:#337ab7!important;border-color:#2e6da4!important;width:100%;font-size:30px;font-weight:700;" class="btn btn-primary btn-lg" type="submit" value="CORRECT ?" > 
					  			</center>
				  			</div>
				  		</div>
			  		</form>	
				</div>
        	</div>
		</div> 
    </div> 
</div> <!-- /container -->
<?php	include 'footer.php';?>       
</body>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<script src="js/gijgo.min.js" type="text/javascript"></script>
<!-- <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
	$(document).ready(function(){
		//document.getElementById("category").style.display = "none";	
		document.getElementById("button").style.display = "none";	

		//for(x=1;x<=6;x++){	

	    $("#dgval1").click(function(){
	    	var id = document.getElementById("dgval1").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $("#dgval2").click(function(){
	    	var id = document.getElementById("dgval2").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $("#dgval3").click(function(){
	    	var id = document.getElementById("dgval3").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $("#dgval4").click(function(){
	    	var id = document.getElementById("dgval4").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $("#dgval5").click(function(){
	    	var id = document.getElementById("dgval5").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $("#dgval6").click(function(){
	    	var id = document.getElementById("dgval6").value;
	       window.location = "enternew.php?unit="+id;
	    });
	    $(".sub").click(function(){
	        document.getElementById("button").style.display = "block";
	    });
	});
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
    function generate(){
           var df = $('#date_from').val();
           var dt = $('#date_to').val();
            $('#btn_gen').attr('href','view_records.php?from='+df+'&to='+dt);  
    }
    function chooseUnit(){
    	document.getElementById("dg1").removeClass("btn-green").addClass("btn-black");
    	// document.getElementById("demo").innerHTML = "Hello World";
    }
   
</script>
</html>
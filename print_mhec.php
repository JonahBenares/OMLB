<?php 
	include 'includes/connection.php';
	include 'includes/functions.php';
	if(isset($GET['id'])){
        $id = $GET["id"];
    } 
    else{
        $id = $_GET["id"];
       
    }
?>
<!DOCTYPE html>
<style type="text/css">
	body{
		font-family: Arial, Helvetica, sans-serif;
	}
	small{
		margin-left:5px;
		font-size: 10px;
	}
	h5{
		margin:0px;
		font-weight: ;
	}
	tbody{
		padding: 20px!important;
	}
	.table-bordered>tbody>tr>td, 
	.table-bordered>tbody>tr>th, 
	.table-bordered>tfoot>tr>td, 
	.table-bordered>tfoot>tr>th, 
	.table-bordered>thead>tr>td, 
	.table-bordered>thead>tr>th {
    	border: 1px solid #000!important;
	}
	.table-condensed>tbody>tr>td, 
	.table-condensed>tbody>tr>th, 
	.table-condensed>tfoot>tr>td, 
	.table-condensed>tfoot>tr>th, 
	.table-condensed>thead>tr>td, 
	.table-condensed>thead>tr>th {
	    padding: 0px!important;
	}
	.table-bordered1 {
	    border: 2px solid #444!important;
	}
	.logo-sty{
		margin-top: 10px;
		width:15%;
	}
	.company-name{
		margin:1px 0px 1px 0px;
	}
	.name-sheet{
		margin:5px 0px 5px 0px;
	}
	.table-main{
		border:2px solid black;
	}
	.table-secondary{
		border:2px solid black;border-top:0px;
	}
	.paded-20{
		padding:20px;
	}
	.paded-top-10{
		padding-top:10px;
	}
	.paded-top-20{
		padding-top:20px;
	}
	.paded-top-30{
		padding-top:30px;
	}
	.undline-tab{
		border-bottom:1px solid black;
	}
	.marg-under{
		margin-bottom:10px;
	}
	.xs-small {
	    font-size: 60%;
	}
</style>
<head>
	<meta charset="UTF-8">
	<title>Print</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div style="margin-top:10px"></div>
	<div class="container">
		<table width="100%" class="table-main">			
			<tr>
				<td width='40%'>
					<center>
						<img class="logo-sty" src="images/mhec.png" style='float:right; width:90px;margin-top: 0px;'>
					</center>
				</td>
				<td width='60%'>
					<p class="company-name" style="font-size:16px"><strong>MINDORO HARVEST ENERGY CO. INC.</strong></p>
					<p style="margin:0px">9.7MW PINAMALAYAN DIESEL POWER PLANT</P>
					<small style="margin: 0px;">Nabuslot, Pinamalayan, Oriental Mindoro</small>
				</td>
			</tr>
		</table>
		<table class="table-secondary" width="100%">
			<tr>
				<td>
					<center>
						<h4 class="name-sheet">DAILY WORK ORDER</h4>
					</center>
				</td>
			</tr>
		</table>
		<table class="table-secondary"  width="100%" >
			<tr>
				<td class="paded-20">
					<table width="100%">
						<!--1st row fill out-->
						<tr>
							<?php 
				                $sql = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
				                $row = mysqli_fetch_array($sql);
				            ?>
							<td width="15%">
								<small>Equipment:</small>
							</td>
							<td class="undline-tab" width="40%">
								<small><?php echo getInfo($con, "unit_name", "unit", "unit_id", $row['unit']).', '.getInfo($con, "system_name", "main_system", "main_id", $row['main_system']).', '.getInfo($con, "subsys_name", "sub_system", "sub_id", $row['sub_system']); ?></small>
							</td>
							<td width="5%" align="right">
								<small>Date:</small>
							</td>
							<td class="undline-tab" width="40%">
								<small><?php echo $row['date_requested']?></small>
							</td>
						</tr>
						<tr>
							<td width="15%">
								<small>Equipment Type/Model:</small>
							</td>
							<td class="undline-tab marg-under" width="40%">
								<small><?php echo $row['equip_type_model']?></small>
							</td>
							<td class="marg-under" width="5%" align="right">
								<small>WO#:</small>
							</td>
							<td class="undline-tab marg-under" width="40%">
								<small></small>
							</td>
						</tr>

						<!--2nd row fill out-->
						<tr >
							<td class="paded-top-10" width="10%">
								<small >From:</small>
							</td>
							<td class="paded-top-10" width="40%">
								<table width="100%" >
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Operations</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Electrical & Instrumentation Maintenance</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Mechanical Maintenance</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Administration</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Civil & Special Projects</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>ECMG</small>
										</td>
									</tr>
								</table>
							</td>
							<td class="paded-top-10"  width="10%">
								<small >To:</small>
							</td>
							<td class="paded-top-10" width="40%">
								<table width="100%" >
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Operations</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Electrical & Instrumentation Maintenance</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Mechanical Maintenance</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Administration</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>Civil & Special Projects</small>
										</td>
									</tr>
									<tr>
										<td width="10%" style="border:1px solid black;">
											<small></small>
										</td>
										<td width="90%">
											<small>ECMG</small>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<!--3rd row fill out-->
						<tr>
							<td colspan="4" class="paded-top-10">
								<table width="100%" class="table table-bordered  table-condensed">
									<tr>
										<td width="10%"><center><small><strong>Item#</strong></small></center></td>
										<td width="50%"><center><small><strong>Description</strong></small></center></td>
										<td width="15%"><center><small><strong>Date/Time Performed</strong></small></center></td>
										<td width="15%"><center><small><strong>Date/Time Finished</strong></small></center></td>
										<td width="10%"><center><small><strong>Remarks</strong></small></center></td>
									</tr>
									<tr>
										<?php 
											$count = 1;
							                $sql1 = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
							                while($row1 = mysqli_fetch_array($sql1)){
							            ?>
											<td><small><?php echo $count;?></small></td>
											<td><small><?php echo $row1['prob_find'];?></small></td>
											<td><small><?php echo $row1['date_performed'].' '.$row1['time_performed'];?></small></td>
											<td><small><?php echo $row1['date_finished'].' '.$row1['time_finished'];?></small></td>
											<td><small></small></td>
										<?php } ?>
									</tr>
								</table>
							</td>
						</tr>

						<!--4th row fill out-->
						<tr>
							<td colspan="4">
								<table width="100%">
									<tr>
										<td width="60%"><small><strong>Work Activities Done:</strong> (To Filled out by Requested Department)</small></td>
										<td width="10%" class="table-bordered1"><small> </small></td>
										<td width="10%" class="table-bordered1"><small> </small></td>
										<td width="10%" class="table-bordered1"><small> </small></td>
										<td width="10%" class="table-bordered1"><small> </small></td>
									</tr>
									<tr>
										<td width="60%"></td>
										<td width="10%"><center><p class="xs-small">PPE</p></center></td>
										<td width="10%"><center><p class="xs-small">HOTWORK</p></center></td>
										<td width="10%"><center><p class="xs-small">CONFINED SPACE</p></center></td>
										<td width="10%"><center><p class="xs-small">FALL PROTECTION</p></center></td>
									</tr>
								</table>
							</td>								
						</tr>

						<!--4th row fill out-->
						<tr>
							<td colspan="4"	>
								<table width="100%">
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
									</tr>
								</table>
							</td>
						</tr>

						<!--5th row fill out-->
						<tr>
							<td colspan="4"	>
								<table width="100%">
									<tr>
										<td width="25%"><small>Work Activities Performed by:</small></td>
										<td class="undline-tab"><small></small></td>
									</tr>
									<tr>
										<td class="undline-tab"><small></small></td>
										<td class="undline-tab"><small></small></td>
									</tr>									
								</table>
								<!-- <table width="100%">
									<tr>
										<td width="15%"><small>Date:</small></td>
										<td width="20%" class="undline-tab"><small></small></td>
										<td width="65%" ><small></small></td>
									</tr>
									<tr>
										<td width="15%"><small>Recieved by:</small></td>
										<td width="20%" class="undline-tab"><small></small></td>
										<td width="65%" ><small></small></td>
									</tr>
								</table> -->
							</td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<!--6th row fill out-->
						<tr>
							<td colspan="4" class="paded-top-20">
								<table width="100%">
									<tr>
										<td width="2%"><small></small></td>
										<td width="30%"><small>Prepared by:</small></td>
										<td width="2%"><small></small></td>
										<td width="30%"><small>Checked by:</small></td>
										<td width="2%"><small></small></td>
										<td width="30%"><small>Noted by:</small></td>
									</tr>
									<tr>
										<td></td>
										<td class="undline-tab"></td>
										<td align="right"></td>
										<td class="undline-tab"></td>
										<td align="right"></td>
										<td class="undline-tab"></td>
									</tr>
									<tr>
										<td></td>
										<td><center><small>Department Supervisor</small></center></td>
										<td></td>
										<td><center><small>Planning Department</small></center></td>
										<td></td>
										<td><center><small>Safety Officer</small></center></td>
									</tr>
								</table>
								<div style="margin-top:30px"></div>
								<table width="100%">
									<tr>
										<td width="2%"></td>
										<td width="30%"><small>Received by:</small></td>
										<td width="2%"></td>
										<td width="30%"><small>Approved by:</small></td>
										<td width="2%"></td>
										<td width="30%"><small>Recommending Approval:</small></td>
									</tr>
									<tr>
										<td align="right"><small></small></td>
										<td class="undline-tab"></td>
										<td align="right"><small></small></td>
										<td class="undline-tab"></td>
										<td align="right"><small></small></td>
										<td class="undline-tab"></td>
									</tr>
									<tr>
										<td align="right"></td>
										<td class="undline-tab"><small>Date:</small></td>
										<td></td>
										<td><center><small>Plant Superintendent</small></center></td>
										<td></td>
										<td><center><small>Technical Director</small></center></td>
									</tr>
								</table>
								<!-- <table width="100%">
									<tr>
										
										<td width="15%" align="right"><small>Approved by:</small></td>
										<td width="30%" class="undline-tab"></td>
										<td width="25%" align="right"><small>Recommending Approval:</small></td>
										<td width="25%" class="undline-tab"></td>
										<td width="5%"></td>
									</tr>
									<tr>
										
										<td width="15%"><small></small></td>
										<td width="30%"><center><small>Power Delivery & Technical Manager</small></center></td>
										<td width="25%"><small></small></td>
										<td width="25%"><center><small>Technical Director</small></center></td>
										<td width="5%"><small></small></td>
									</tr>
								</table> -->
							</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
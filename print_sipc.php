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
						<img class="logo-sty" src="images/calapan.png" style='float:right; width:60px'>
					</center>
				</td>
				<td width='60%'>
					<p class="company-name"><strong>Sta. Isabel Power Corporation</strong></p>
						<small><strong>Sta. Isabel, Calapan City, Oriental Mindoro</strong></small>
				</td>
			</tr>
		</table>
		<?php 
	            $sql = mysqli_query($con,"SELECT * FROM log_head WHERE log_id = '$id'");
	            $row = mysqli_fetch_array($sql);
	            $count_notes = substr_count($row['notes'], "-");
	            $notes=explode("-",$row['notes']);
	     ?>
		<table class="table-secondary" width="100%" border='1' style='text-align: center; font-size: 12px'>
			<tr>
				<td style='width:150px'>Department:</td>
				<td style='width:200px'></td>
				<td rowspan="2"><center><strong>WORK ORDER</strong></center></td>
				<td style='width:150px'>Work Order N.</td>
				<td style='width:200px'></td>
			</tr>
			<tr>	
				<td style='width:150px'>Requested By:</td>
				<td style='width:200px'></td>
				<td style='width:150px'>Date:</td>
				<td style='width:200px'><?php echo date('d-M-Y', strtotime($row['date_performed'])); ?></td>
			</tr>
			<tr>
				<td>Purpose:</td>
				<td colspan='4'></td>
			</tr>	
		</table>
		<table class="table-secondary"  width="100%" border='1' style='font-size: 12px'>
			<tr>
				<th><center>Item</center></th>
				<th><center>Scope of Work</center></th>
				<th><center>Materials</center></th>
				<th><center>Urgent <br> Yes/No</center></th>
				<th><center>Man</center></th>
				<th><center>Hour</center></th>
				<th><center>Total MH</center></th>
				<th><center>Remarks</center></th>
			</tr>
			<?php
	            for($x=1;$x<=$count_notes;$x++){ 
	            	$add=$x-1;?>
	            	<tr>
	            		<td><center><?php echo $x; ?></center></td>
	            		<td><?php echo $notes[$x]; ?></td>
	            		<td></td>
	            		<td></td>
	            		<td></td>
	            		<td></td>
	            		<td></td>
	            		<td></td>
	            	</tr>
	            <?php } ?>
		</table>
		<table class="table-secondary"  width="100%" style='font-size: 12px'>
			<tr>
				<td style='width:25%; font-weight: bold'>Requested By:</td>
				<td style='width:25%; font-weight: bold'>Verified By:</td>
				<td style='width:25%; font-weight: bold'>Noted By:</td>
				<td style='width:25%; font-weight: bold'>Approved By:</td>
			</tr>
			<tr>
				<td style='height:30px'></td>
				<td style='height:30px'></td>
				<td style='height:30px'></td>
				<td style='height:30px'></td>
			</tr>
			<tr>
				<td style='width:25%'><center>Operation Superintendent</center></td>
				<td style='width:25%'><center>Mechanical Foreman</center></td>
				<td style='width:25%'><center>O&M Manager</center></td>
				<td style='width:25%'><center>Plant Manager</center></td>
			</tr>
		</table>

	</div>
</body>
</html>
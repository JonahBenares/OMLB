<?php
include 'includes/connection.php'; 
include 'includes/functions.php'; 

$sql="SELECT * FROM log_head";

if(!empty($_GET)){
	$sql .= " WHERE"; 
	if(!empty($_GET['date_from'])){
		if(!empty($_GET['date_to'])){
			$sql .= " date_performed BETWEEN '$_GET[date_from]' AND '$_GET[date_to]' AND";
		}else{
			$sql .= " date_performed BETWEEN '$_GET[date_from]' AND '$_GET[date_from]' AND";
			
		}
	}

/*	if(!empty($_GET['duefrom'])){
		if(!empty($_GET['dueto'])){
			$sql .= " due_date BETWEEN '$_GET[duefrom]' AND '$_GET[dueto]' AND";
		}else{
			$sql .= " due_date BETWEEN '$_GET[duefrom]' AND '$_GET[duefrom]' AND";
			
		}
	}*/

	if(!empty($_GET['unit'])){
		$sql .= " unit =  '$_GET[unit]' AND";
	}
/*	if(!empty($_GET['system_name'])){
		$sql .= " main_system =  '$_GET[system_name]' AND";
		//$url.="system_name=".$_GET['system_name'];
	}*/
	if(!empty($_GET['sub_system'])){
		$sql .= " sub_system =  '$_GET[sub_system]' AND";
	
	}
	if(!empty($_GET['status'])){
		$sql .= " status =  '$_GET[status]' AND";
	
	}
}
$q = substr($sql,-3);
if($q == 'AND'){
	$sql = substr($sql,0,-3);
} else {
	$sql = substr($sql,0,-5);
}


require_once 'js/phpexcel/Classes/PHPExcel/IOFactory.php';
$exportfilename="export//allreports.xlsx";
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "OMLB Summary Report");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',"Period Covered: $_GET[date_from] ". to ." $_GET[date_to]");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date Performed");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Time Performed");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Date Finished");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Time Finished");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "Unit");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "Sub Category");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "Equipment Type/Model");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "Problem/Findings");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Action Taken");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "Parts Replaced");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "Performed by");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y3', "Status");

$num=4;
$q = $con->query($sql);
while($fetch = $q->fetch_array()){
	//$datetime = $fetch['date_performed'] . " " . $fetch['time_performed'];
	$unit=getInfo($con, 'unit_name', 'unit', 'unit_id',  $fetch['unit']);
	// $main=getInfo($con, 'system_name', 'main_system', 'main_id',  $fetch['main_system']);
	$sub=getInfo($con, 'subsys_name', 'sub_system', 'sub_id',  $fetch['sub_system']);
	// $loggedby=getInfo($con, 'fullname', 'users', 'user_id',  $fetch['logged_by']);
	// $finishby = getInfo($con, "fullname", "users", "user_id", $fetch['finished_by']);
	$status = $fetch['status'];
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $fetch['date_performed']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $fetch['time_performed']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $fetch['date_finished']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $fetch['time_finished']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $unit);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $sub);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $fetch['equip_type_model']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $fetch['prob_find']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $fetch['act_taken']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$num, $fetch['parts_replaced']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $fetch['performed_by']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$num, $fetch['status']);
	

	/*$updates = $con->query("SELECT * FROM update_logs WHERE log_id = '$fetch[log_id]'");
	$update_rows = $updates->num_rows;
	if($update_rows > 0){

		while($fetchup = $updates->fetch_array()){
			$num++;
			$datetime_up = $fetchup['date_performed'] . " " . $fetchup['time_performed'];
			$loggedby_up=getInfo($con, 'fullname', 'users', 'user_id',  $fetchup['logged_by']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, 'UPDATES:');
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$num.':C'.$num);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getFont()->setBold(true);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $datetime_up);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $fetchup['notes']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$num, $fetchup['performed_by']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $loggedby_up);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $fetchup['logged_date']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $fetchup['status']);
		}
	}*/

	$objPHPExcel->getActiveSheet()->mergeCells('A'.$num.":B".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('J'.$num.":L".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":O".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":R".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('S'.$num.":U".$num);
	$objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":X".$num);
	$num++;
}
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:Y2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:Y3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:Y1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:Y2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
$objPHPExcel->getActiveSheet()->mergeCells('D3:E3');
$objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
$objPHPExcel->getActiveSheet()->mergeCells('J3:L3');
$objPHPExcel->getActiveSheet()->mergeCells('M3:O3');
$objPHPExcel->getActiveSheet()->mergeCells('P3:R3');
$objPHPExcel->getActiveSheet()->mergeCells('S3:U3');
$objPHPExcel->getActiveSheet()->mergeCells('V3:X3');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
if (file_exists($exportfilename))
		unlink($exportfilename);
$objWriter->save($exportfilename);
unset($objPHPExcel);
unset($objWriter);   
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="allreports.xlsx"');
readfile($exportfilename);

?>
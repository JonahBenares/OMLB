<?php
include 'includes/connection.php';
include 'includes/functions.php';

/*$today =date('Y-m-d');*/
$today='2018-04-16';
$dt='2018_04_16';

require_once 'js/phpexcel/Classes/PHPExcel/IOFactory.php';
$exportfilename="export//report_logbook.xlsx";
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Logged Date");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Logged By");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Count of Logs");
$num=2;

$get = $con->query("SELECT count(log_id) AS ct, logged_by FROM log_head WHERE logged_date LIKE '$today%' GROUP BY logged_by");
while($fetch = $get->fetch_array()){
	$user = getInfo($con, 'fullname', 'users', 'user_id', $fetch['logged_by']);
	$count=$fetch['ct'];
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $today);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $user);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $count);

	$num++;
}
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
if (file_exists($exportfilename))
		unlink($exportfilename);
$objWriter->save($exportfilename);
unset($objPHPExcel);
unset($objWriter);   
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="report_logbook.xlsx"');
readfile($exportfilename);
?>
	
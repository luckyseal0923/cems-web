<?
require("../_inc.php");

$Keywords = SqlFilter($_REQUEST["Keywords"],"str");

$strF = 1;
if ($Keywords != "" && $Keywords != "請輸入課程名稱或報名者姓名關鍵字搜尋"){
	if ($strF == 1){$Cond1 = " (Locate('".SqlFilter($Keywords,"str")."',strName)> 0) Or (Locate('".SqlFilter($Keywords,"str")."',strID)> 0) ";}
	$strF = 0;
}

if ($strF == 1)
	$Cond = "";
else
	$Cond = " Where ".$Cond1;

$objPHPExcel = new PHPExcel();  //調用PHPExcel class
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  //調用Excel 2003以下的版本
$objPHPExcel->setActiveSheetIndex(0);  //設定動作Sheet       
$objPHPExcel->getActiveSheet()->setCellValue('A1', '訂單編號');  		//指定A1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('B1', '會員名稱');		//指定B1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('C1', '課程名稱');  		//指定C1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('D1', '報名狀態');		//指定D1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('E1', '報名日期');		//指定E1儲存格內容
$i = 1; 
$sql = "Select * From apply $Cond Order By dtDate Desc";
$rs = new recordset($sql);
while (! $rs->eof){
	$i++;
	$applyStatus = "未繳費";
	if ( $rs->field("Flag") == 1 ){ $applyStatus = "已繳費,報名成功";}
	
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i,$rs->field("OrderNo"),PHPExcel_Cell_DataType::TYPE_STRING);  	//指定A{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$i,$rs->field("Member_Name"),PHPExcel_Cell_DataType::TYPE_STRING);	//指定B{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$i,$rs->field("Course_Name"),PHPExcel_Cell_DataType::TYPE_STRING); //指定C{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$i,$applyStatus,PHPExcel_Cell_DataType::TYPE_STRING);  			//指定D{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$i,$rs->field("dtDate"),PHPExcel_Cell_DataType::TYPE_STRING);  	//指定E{$i}儲存格內容

    $rs->movenext();
}
	   
$objPHPExcel->getActiveSheet()->setTitle('memberData');  //指定Sheet名稱
//$objWriter->save('member.xls');  //另存Excel檔案

//*************************************
//输出内容
//
//$outputFileName = '../Upload/order'.date("Ymd").'.xls';
//到文件
//$objWriter->save($outputFileName);
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header('Content-Disposition:inline;filename=Apply'.date("Ymd").'.xls');
header("Content-Transfer-Encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
$objWriter->save('php://output');
exit;
?>

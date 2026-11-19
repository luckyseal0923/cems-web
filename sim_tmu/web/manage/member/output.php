<?
require("../_inc.php");

$Keywords = SqlFilter($_REQUEST["Keywords"],"str");

$strF = 1;
if ($Keywords != "" && $Keywords != "請輸入姓名或帳號關鍵字搜尋"){
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
$objPHPExcel->getActiveSheet()->setCellValue('A1', '會員姓名');  		//指定A1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('B1', '會員Email');		//指定B1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('C1', '會員帳號');  		//指定C1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('D1', '會員密碼');		//指定D1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('E1', '會員暱稱');		//指定E1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('F1', '會員英文名');		//指定F1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('G1', '學號或員工編號');	//指定G1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('H1', '聯絡電話');  		//指定H1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('I1', '聯絡地址(中)');  	//指定I1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('J1', '聯絡地址(英)');  	//指定J1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('K1', '會員身份');  		//指定K1儲存格內容
$objPHPExcel->getActiveSheet()->setCellValue('L1', '加入日期');  		//指定L1儲存格內容
$i = 1; 
$sql = "Select * From member $Cond Order By dtDate Desc";
$rs = new recordset($sql);
while (! $rs->eof){
	$i++;
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i,$rs->field("strName"),PHPExcel_Cell_DataType::TYPE_STRING);  			//指定A{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$i,$rs->field("Email"),PHPExcel_Cell_DataType::TYPE_STRING);  				//指定B{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$i,$rs->field("strID"),PHPExcel_Cell_DataType::TYPE_STRING);  				//指定C{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$i,$rs->field("strPW"),PHPExcel_Cell_DataType::TYPE_STRING);  				//指定D{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$i,$rs->field("strNickName"),PHPExcel_Cell_DataType::TYPE_STRING);  		//指定E{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$i,$rs->field("strEName"),PHPExcel_Cell_DataType::TYPE_STRING);  			//指定F{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$i,$rs->field("strNo"),PHPExcel_Cell_DataType::TYPE_STRING);  				//指定G{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$i,$rs->field("strTel"),PHPExcel_Cell_DataType::TYPE_STRING);  				//指定H{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$i,$rs->field("strAddress"),PHPExcel_Cell_DataType::TYPE_STRING);  		//指定I{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$i,$rs->field("strEAddress"),PHPExcel_Cell_DataType::TYPE_STRING);  		//指定J{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$i,Member_Type($rs->field("strType")),PHPExcel_Cell_DataType::TYPE_STRING);  			//指定K{$i}儲存格內容
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$i,Date_EN($rs->field("dtDate"),1),PHPExcel_Cell_DataType::TYPE_STRING);	//指定L{$i}儲存格內容

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
header('Content-Disposition:inline;filename=member'.date("Ymd").'.xls');
header("Content-Transfer-Encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
$objWriter->save('php://output');
exit;
?>

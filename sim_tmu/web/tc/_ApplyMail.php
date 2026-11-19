<?php
	require("_inc.php");
	
	/***參數解碼(報名PKey)***/
	if ($_REQUEST["PKey"] <> ""){
		
		$apply_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		/*取得報名資料*/
		$SQL = "Select * From apply Where PKey=".SqlFilter($apply_PKey,"int");
		$rs = new recordset($SQL);
		if (! $rs->eof){
			$OrderNo = $rs->field("OrderNo");
			$Member_Name = $rs->field("Member_Name");
			$dtDate = $rs->field("dtDate");
			$Course_Name = $rs->field("Course_Name");
			$Course_PKey = $rs->field("Course_PKey");
		}
		
		/*取得課程資料*/
		$SQL = "Select OpenDate,EndDate,dtCourse_time,strTeacher,Price From course Where PKey=".SqlFilter($Course_PKey,"int");
		$rs = new recordset($SQL);
		if (! $rs->eof){
			$OpenDate = $rs->field("OpenDate");
			$EndDate = $rs->field("EndDate");
			$strTime = $rs->field("dtCourse_time");
			$strTeacher = $rs->field("strTeacher");
			$Price = $rs->field("Price");
			/*課程開始顯示判斷*/
			if ( strtotime($OpenDate) == strtotime($EndDate) ){
				$CourseDate = $OpenDate;
			}else{
				$CourseDate = Date_EN($OpenDate,1)."~".Date_EN($EndDate,1);
			}
		}		
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>臺北醫學大學醫學模擬教育中心-報名確認信‏</title>

<style type="text/css">
<!--
body {background-color: #f4f4f4; font-family:"微軟正黑體", "新細明體"; font-size:12pt;}
h1{  font-weight:bold; font-size:16pt; color:#000; text-align:center;}
p{ margin:0px; padding:0px;}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><p><img src="<? echo RootURL($_SERVER['PHP_SELF'])?>/images/all/logo.jpg"></p>
      <hr /></td>
  </tr>
  <tr>
    <td height="50">
        <p><font color="#FF0000">※※※※※※※※※　注意　※※※※※※※※※</font></p>
        <p><font color="#FF0000">此信為系統發出，請勿直接回覆</font></p>
        <p><font color="#FF0000">※※※※※※※※※※※※※※※※※※※※※</font></p>
    </td>
  </tr>
  <tr>
    <td>
    <br><br>
    <p><? echo $Member_Name?>您好！<br>感謝您於 <? echo $dtDate?> 報名課程：</p>
    <p>以下是您報名的課程資訊</p>
    
    <table border="1" cellspacing="0" cellpadding="0" width="900">
      <tr>
        <th>課程名稱</th>
        <td colspan="3"><? echo $Course_Name?></td>
        </tr>
        <th>訂單編號</th>
        <td><? echo $OrderNo?></td>
        <th>報名日期</th>
        <td><? echo Date_EN($dtDate,1)?></td>
      </tr>
      <tr>
        <th>上課日期</th>
        <td><? echo $CourseDate?></td>
        <th>授課講師</th>
        <td><? echo $strTeacher?></td>
      </tr>
      <tr>
        <th>上課時間</th>
        <td><? echo $strTime?></td>
        <th>報名費用</th>
        <td><? echo number_format($Price,0)?>元</td>          
      </tr>
    </table>
    <p>請於三個工作天內至本校出納組繳費並回傳繳費收據，逾期未繳者，本中心得逕予取消報名紀錄，不得異議。</p>
    <br />
    <br />
    <!--<p style="text-align:center;">臺北醫學大學醫學模擬教育中心  網路管理部 <a href="mailto:XXX@gmail.com">XXX@gmail.com</a>  敬啟</p>-->
    <p style="text-align:center;">臺北醫學大學醫學模擬教育中心  網路管理部  敬啟</p>
    <p><img src="<? echo RootURL($_SERVER['PHP_SELF'])?>/images/p4/mail_footer.jpg"></p></td>
    </td>
  </tr>
</table>    
    </td>
  </tr>
</table>
</body>
</html>
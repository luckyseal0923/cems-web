<?php
	require("_inc.php");
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Rental_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		$SQL = "Select * From rental Where PKey=".SqlFilter($Rental_PKey,"int");
		$rs = new recordset($SQL);
		
		if (! $rs->eof){
			$classroom_PKey = $rs->field("classroom_PKey");
			$rental_date = $rs->field("Rental_Date");
			$rental_time = $rs->field("Rental_time");
			$rental_unit = $rs->field("Rental_unit");
			$rental_name = $rs->field("Rental_name");
			$rental_email = $rs->field("rental_email");
			$rental_tel = $rs->field("rental_tel");
			$rental_message = $rs->field("rental_message");
			$charge = $rs->field("charge");
			$dtDate = $rs->field("dtDate");
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>《臺北醫學大學-醫學模擬教育中心》 申請場地租借通知信</title>

<style type="text/css">
<!--
body {background-color: #f4f4f4; font-family:"微軟正黑體", "新細明體"; font-size:12pt;}
h1{  font-weight:bold; font-size:16pt; color:#000; text-align:center;}
p{ margin:0px; padding:0px;}
-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p><img src="<? echo RootURL($_SERVER['PHP_SELF'])?>/images/all/logo.jpg"></p>
      <hr /></td>
  </tr>
  <tr>
    <td align="center"><p><font color="#FF0000">※※※※※※※※※　注意　※※※※※※※※※</font></p>
      <p><font color="#FF0000">此信為系統發出，請勿直接回覆</font></p>
      <p><font color="#FF0000">※※※※※※※※※※※※※※※※※※※※※※</font></p></td>
  </tr>
  <tr>
    <td><p><? echo $rental_name?>您好！<br>
      感謝您於<? echo $dtDate?> 租借教室</p>
      <p>以下是您租借教室的資訊<br>
      </p></td>
  </tr>
  <tr>
    <td><h4><br>
      臺北醫學大學醫學模擬教育中心-場地租借</h4>
      <table border="1" cellspacing="0" cellpadding="0" width="100%" bordercolor="#cccccc">
        <tr>
          <td width="25%" bgcolor="#dadada">租借教室</td>
          <td colspan="3"><? echo Classroom_Type($classroom_PKey)?></td>
        </tr>
        <tr>
          <td width="25%" bgcolor="#dadada">租借日期</td>
          <td width="25%"><? echo Date_EN($rental_date,3)?></td>
          <td width="25%" bgcolor="#dadada">租借時段</td>
          <td width="25%"><? echo Rental_Time($rental_time)?></td>
        </tr>
        <tr>
          <td width="25%" bgcolor="#dadada">單位</td>
          <td width="25%"><? echo $rental_unit?></td>
          <td width="25%" bgcolor="#dadada">聯絡人</td>
          <td width="25%"><? echo $rental_name?></td>
        </tr>
        <tr>
          <td width="25%" bgcolor="#dadada">E-mail</td>
          <td width="25%"><? echo $rental_email?></td>
          <td width="25%" bgcolor="#dadada">電話</td>
          <td width="25%"><? echo $rental_tel?></td>
        </tr>
        <tr>
          <td width="25%" bgcolor="#dadada">說明</td>
          <td width="25%"><? echo $rental_message?></td>
          <td width="25%" bgcolor="#dadada">費用</td>
          <td width="25%"><? echo $charge?></td>
        </tr>
      </table>
      <p>請於三個工作天內至本校出納組繳費並回傳繳費收據，逾期未繳者，本中心得逕予取消報名紀錄，不得異議。</p>
      <br />
      <br />
      <p style="text-align:center;">臺北醫學大學醫學模擬教育中心  網路管理部 <a href="mailto:XXX@gmail.com">XXX@gmail.com</a> 敬啟</p>
      <p><img src="<? echo RootURL($_SERVER['PHP_SELF'])?>/images/p4/mail_footer.jpg"></p></td>
  </tr>
</table>
</body>
</html>
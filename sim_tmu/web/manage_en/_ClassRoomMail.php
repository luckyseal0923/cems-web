<?php
	require("_inc.php");
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Rental_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		$SQL = "Select email,strPW,strName From rental_p Where PKey=".SqlFilter($Member_PKey,"int");
		$rs = new recordset($SQL);
		
		if (! $rs->eof){
			$Rental_name = $rs->field("Rental_name");
			$Rental_date = $rs->field("Rental_date");
			$Rental_time = Rental_Time($rs->field("Rental_timt"));
			$Classroom_PKey = Classroom_Type($rs->field("classroom_PKey"));
			$Rental_unit = $rs->field("Rental_unit");
			$Rental_tel = $rs->field("Rental_tel");
			$Rental_email = $rs->field("Rental_email");
			$Rental_message = $rs->field("Rental_message");
			$email = $rs->field("email");
			$password = $rs->field("strPW");
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>臺北醫學大學醫學模擬教育中心-場地租借</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<p><img src="images/all/logo.jpg"></p>
<hr />
<h4>臺北醫學大學醫學模擬教育中心-場地租借</h4>
<table border="1" cellspacing="0" cellpadding="0" width="100%" bordercolor="#cccccc">
  <tr>
  	<td align="center">
    	<p><font color="#FF0000">※※※※※※※※※　注意　※※※※※※※※※</font></p>
        <p><font color="#FF0000">此信為系統發出，請勿直接回覆</font></p>
        <p><font color="#FF0000">※※※※※※※※※※※※※※※※※※※※※※</font></p>
    </td>
  </tr>
    <tr>
  	<td><p><? echo $Rental_name?>您好！<br>感謝您於 <? echo $Rental_date?> <? echo $Rental_time?> 租借教室</p>
	<p>以下是您租借教室的資訊</p>
	</td>
  </tr>
  <tr>
    <td bgcolor="#dadada">租借教室</td>
    <td colspan="3"><? echo $Classroom_PKey?></td>
    </tr>
  <tr>
    <td bgcolor="#dadada">租借日期</td>
    <td><? echo $Rental_date?></td>
    <td bgcolor="#dadada">租借時段</td>
    <td><? echo $Rental_time?></td>
  </tr>
  <tr>
    <td bgcolor="#dadada">單位</td>
    <td><? echo $Rental_unit?></td>
    <td bgcolor="#dadada">聯絡人</td>
    <td><? echo Rental_name?></td>
  </tr>
  <tr>
    <td bgcolor="#dadada">E-mail</td>
    <td><? echo $Rental_email?></td>
    <td bgcolor="#dadada">電話</td>
    <td><? echo $Rental_tel?></td>
  </tr>
  <tr>
    <td bgcolor="#dadada">說明</td>
    <td colspan="3"><? echo $Rental_message?></td>
  </tr>
</table>

<br />
<br />
<p><img src="images/p4/mail_footer.jpg"></p>
    </td>
  </tr>
</table>
</body>
</html>

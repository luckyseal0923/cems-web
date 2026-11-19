<?php
$SQL = "Select * From member Where PKey =".SqlFilter($_SESSION["Member_PKey"],"int");
$rs = new recordset($SQL);
if (! $rs->eof){	
	$Member_PKey = $rs->field("PKey");
	$strID = $rs->field("strID");
	$strPW = $rs->field("strPW");
	$strName = $rs->field("strName");
	$strNickName = $rs->field("strNickName");
	$strEName = $rs->field("strEName");
	$strNo = $rs->field("strNo");
	$strTel = $rs->field("strTel");
	$EMail = $rs->field("EMail");
	$Address = $rs->field("strAddress");
	$EAddress = $rs->field("strEAddress");
	$strType = $rs->field("strType");
}else{
	echo "<script language=\"javascript\">" ;
	echo "alert('您尚未登入,請重新登入帳號密碼!');" ;
	echo "location.href='p4_login.php';" ;
	echo "</script>" ;
	exit() ;
} 
?>
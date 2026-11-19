<?php
	require("_inc.php");
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Member_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		$SQL = "Select strID, strPW, strName From member Where PKey=".SqlFilter($Member_PKey,"int");
		$rs = new recordset($SQL);
		
		if (! $rs->eof){
			$strName = $rs->field("strName");
			$strID = $rs->field("strID");
			$strPW = $rs->field("strPW");
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>臺北醫學大學醫學模擬教育中心-忘記密碼通知信‏</title>

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
        <p><font color="#FF0000">※※※※※※※※※※※※※※※※※※※※※※</font></p>
    </td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="20" cellpadding="0" bgcolor="#FFFFFF"  >
      <tr>
        <td valign="top">
          <p class="pad1"><? echo $strName?>您好!<br>
            <br>          
            請使用下列資訊登入臺北醫學大學醫學模擬教育中心會員中心並妥善保管您的帳號密碼！<br>
            登入帳號：<? echo $strID?><br>登入密碼：<? echo $strPW?><br>
            <br>
            <br />
           <!--<p style="text-align:center;">臺北醫學大學醫學模擬教育中心  網路管理部 <a href="mailto:XXX@gmail.com">XXX@gmail.com</a>  敬啟</p>-->
           <p style="text-align:center;">臺北醫學大學醫學模擬教育中心  網路管理部  敬啟</p>
		   <p><img src="<? echo RootURL($_SERVER['PHP_SELF'])?>/images/p4/mail_footer.jpg"></p></td>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
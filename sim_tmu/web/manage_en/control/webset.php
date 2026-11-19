<?php
require_once("../_inc.php");
$mainitem="m6";
$subitem="m6";
$subname=$m6.$mgw1;
$unitprocess=$url_link.$m_home.$mgw1.$icon.$m6.$mgw1; //單元路徑列
$ModuleNo = 6;
if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('無進入[".$m6."]權限!');";
	ECHO "location.href='../index.php';";
	ECHO "</script>";
}

if ($_REQUEST["Submit"] == "送出"){
	$MSG = "";

	if ($MSG == ""){
		$SQL_U = " update webset set ";
		$SQL_U .= " Limit_Price = '".SqlFilter($_POST['Limit_Price'],"int")."',";
		$SQL_U .= " Charge1 = '".SqlFilter($_POST['Charge1'],"int")."',";
		$SQL_U .= " Charge2 = '".SqlFilter($_POST['Charge2'],"int")."',";
		$SQL_U .= " OrderMail = '".SqlFilter($_POST['OrderMail'],"tab")."',";
		$SQL_U .= " ContactMail = '".SqlFilter($_POST['ContactMail'],"tab")."',";
		$SQL_U .= " FlowMail = '".SqlFilter($_POST['FlowMail'],"tab")."',";
		$SQL_U .= " Contents = '".SqlFilter($_POST['Contents'],"tab")."',";
		$SQL_U .= " OrderNote = '".SqlFilter($_POST['OrderNote'],"tab")."',";
		$SQL_U .= " FlowNote = '".SqlFilter($_POST['FlowNote'],"tab")."',";
		$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
		$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."'";
		execute_sql($SQL_U);
		$show = "修改成功!";

		//組合導回參數
		$str = "?Send=".urlencode("搜尋");
		if (SqlFilter($_REQUEST["Page"],"int") > 0)
			$str .= "&Page=".SqlFilter($_REQUEST["Page"],"int");
		if ($_REQUEST["Q_Keywords"] != "")
			$str .= "&Keywords=".urlencode(SqlFilter($_REQUEST["Q_Keywords"],"str"));
		//清除Session變數
		unset($_SESSION["Pkey_".$ModuleNo]);
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('".$show."');";
		ECHO "location.href='".$_SERVER["PHP_SELF"]."';" ;
		ECHO "</script>";
		exit;
	}
	Else{
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
		ECHO "location.href='javascript:history.back()';";
		ECHO "</script>";
		exit;
	}
}
$SQL = "Select * From webset";
$DR1 = new recordset($SQL);
if (! $DR1->eof){
	$PKey = $DR1->field("PKey");
	$Limit_Price = $DR1->field("Limit_Price");
	$Charge1 = $DR1->field("Charge1");
	$Charge2 = $DR1->field("Charge2");
	$Contents = $DR1->field("Contents");
	$OrderNote = $DR1->field("OrderNote");
	$FlowNote = $DR1->field("FlowNote");
	$OrderMail = $DR1->field("OrderMail");
	$ContactMail = $DR1->field("ContactMail");
	$FlowMail = $DR1->field("FlowMail");
	$dtUDate = $DR1->field("dtUDate");
	$UserID = $DR1->field("UserID");
}else{
	$sql  = "insert into webset set" ;
	$sql .= " UserID='Admin',";		
	$sql .= " dtUDate= '".strftime("%Y-%m-%d %H:%M:%S")."',";
	$sql .= " dtDate='".strftime("%Y/%m/%d %H:%M:%S")."'";
	execute_sql($sql);	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle1.$pageTitle2 ?></title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<?php require_once("../_in-script.php") ?>
<!--載入網頁編輯器-->
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript">
//偵測Form裡的各欄位----^_^
function login(theForm) 
 {
	theForm.submit()
  }
  
function fieldCheck0(theForm) {
  if (theForm.ContactMail.value == ""){
    alert("【客服信件】請勿空白"); 
	theForm.ContactMail.focus();
	return false; }
	
  if (theForm.OrderMail.value == ""){
    alert("【訂單通知】請勿空白"); 
	theForm.OrderMail.focus();
	return false; }
	
  if (theForm.FlowMail.value == ""){
    alert("【訂單狀態更改】請勿空白"); 
	theForm.FlowMail.focus();
	return false; }

	if (isNaN(parseInt(theForm.Limit_Price.value))){
	alert("【免運費門檻】不是數字!!"); 
	theForm.Limit_Price.focus();
	return false;
	}
	
	if (isNaN(parseInt(theForm.Charge2.value))){
	alert("【運費】不是數字!!"); 
	theForm.Charge2.focus();
	return false;
	}  
return true;
}
</script>
</head>

<body>
<div id="wrapper">
  <?php require_once("../_header.php"); ?>
  <p class="clear"></p>
  <div id="inside1">
    <?php require_once("../_menu.php"); ?>
    <div id="contentpage">
      <div id="title">
        <div class="float-l">
          <h1>
            <div class="float-l"><img src="../images/title-left.jpg" /></div>
            <div class="tt-r"><?php echo $subname;?></div>
          </h1>
        </div>
        <div id="nav" align="right"><?php echo $unitprocess;?></div>
        <p class="clear"></p>
      </div>
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="form1" id="form1" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
        <div id="mainpage">
          <table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>
              <td align="right" class="line-d0"><span class="red">*</span>客服信件</td>
              <td class="line-d">
                <input name="ContactMail" type="text" id="ContactMail" value="<?php echo $ContactMail?>" size="60" maxlength="255" />
               <span class="red">(請輸入E-mail，多個收件者請用分號(;)區分) </span></td>
            </tr>
            <tr>
              <td align="right" class="line-d0"><span class="red">*</span>訂單通知</td>
              <td class="line-d">
                <input name="OrderMail" type="text" id="OrderMail" value="<?php echo $OrderMail?>" size="60" maxlength="255" />
 <span class="red">(請輸入E-mail，多個收件者請用分號(;)區分) </span></td>
            </tr>
            <tr>
              <td align="right" class="line-d0"><span class="red">*</span>訂單狀態更改</td>
              <td class="line-d">
                <input name="FlowMail" type="text" id="FlowMail" value="<?php echo $FlowMail?>" size="60" maxlength="255" />
 <span class="red">(請輸入E-mail，多個收件者請用分號(;)區分) </span></td>
            </tr>
            <tr>
              <td width="80" align="right" class="line-d0"><span class="red">*</span>免運費門檻</td>
              <td class="line-d">
                <input name="Limit_Price" type="text" id="Limit_Price" value="<?php echo $Limit_Price ?>" size="10" />
                限輸入數字</td>
            </tr>
            <tr >
              <td align="right" class="line-d0"> <span class="red">*</span>運費</td>
              <td class="line-d">
                <input name="Charge2" type="text" id="Charge2" value="<?php echo $Charge2 ?>" size="10" />
                限輸入數字</td>
            </tr>
            <tr>
              <td align="right" valign="top" class="line-d0">首頁區塊</td>
              <td class="line-d">
                <textarea name="Contents" id="Contents" class="ckeditor"><?php echo $Contents?></textarea>
              </td>
            </tr>
            <tr>
              <td align="right" valign="top" class="line-d0">訂單完成<br>通知信備註</td>
              <td class="line-d">
                <textarea name="OrderNote" id="OrderNote" class="ckeditor"><?php echo $OrderNote?></textarea>
              </td>
            </tr>
            <tr>
              <td align="right" valign="top" class="line-d0">已出貨<br>通知信備註</td>
              <td class="line-d">
                <textarea name="FlowNote" id="FlowNote" class="ckeditor"><?php echo $FlowNote?></textarea>
              </td>
            </tr>
            <tr>
              <td align="right" class="line-d0">更新日期</td>
              <td align="left" class="line-d">
                <!--#include file="_modify.asp"-->
                <?php require("../_modify.php") ?>
              </td>
            </tr>
          </table>
          <?php require("../_submit.php") ?>
          <!--main end-->
        </div>
      </form>
      <!--contentpage end-->
    </div>
    <!--inside1 end-->
  </div>
  <?php require_once("../_footer.php"); ?>
  <!--wrapper end-->
</div>
</body>
</html>
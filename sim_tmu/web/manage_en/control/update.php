<?php
require_once("../_inc.php");

$mainitem    = "s2";
$subitem     = "s2";
$subname     = $s2."－".$s2.$mgw2;
$unitprocess = $m_home.$icon."<a href=\"list.php\">".$s2.$mgw1."</a>".$icon.$mgw2.$s2; //單元路徑列

$ModuleNo = 99;
if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('無進入[".$s2."]權限!');";
	ECHO "location.href='../index.php';";
	ECHO "</script>";
}

//參數解碼
if ($_REQUEST["PKey"] <> ""){
	$_SESSION["PKey_".$ModuleNo] = authcode($_REQUEST["PKey"],'DECODE');
	$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
}

if ($_REQUEST["Submit"] == "送出"){
	$MSG = "";

	//表單檔案驗證
	$MSG = "";

	if (strLen($_POST["strName"]) == 0)
	{$MSG .= "【姓名】為空白\\n";}

	$regexp = "/^[A-Za-z0-9]{0,20}$/"; //13位的英文字符和數字串
	if (! preg_match($regexp,$_REQUEST["strID"]))
	{$MSG .= "【帳號】英文或數字0~20碼\\n";}

	if (! preg_match($regexp,$_REQUEST["strPW"]))
	{$MSG .= "【密碼】英文或數字0~20碼\\n";}
	
	if (count($_POST["FunctionName"]) == 0)
	{$MSG .= "【權限】請選擇\\n";}
	else
	{
		$F_Name = "";
		$F_ID = "";
		for ($i = 0; $i <= count($_POST["FunctionName"])-1; $i++) {
			//組合模組代碼和名稱

			$II = explode("|",$_POST["FunctionName"][$i]);
			$F_ID .= $II[0].',';
			$F_Name .= $II[1].',';
		}

	}
	if ($MSG == ""){
		$SQL_U = "update webcontrol Set ";
		$SQL_U .= " strID = '".SqlFilter($_POST['strID'],"tab")."',";
		$SQL_U .= " strPW = '".SqlFilter($_POST['strPW'],"tab")."',";
		$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
		$SQL_U .= " FunctionName = '".SqlFilter($F_Name,"str")."',";
		$SQL_U .= " FunctionID = '".SqlFilter($F_ID,"str")."',";
		$SQL_U .= "dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
		$SQL_U .= "dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
		$SQL_U .= "UserID ='".SqlFilter($_SESSION['Login_ID'],"str")."'";
		$SQL_U .= " Where PKey =".SqlFilter($Update_PKey,"int");
		execute_sql($SQL_U);
		$show = "修改成功!";

		//清除Session變數
		unset($_SESSION["PKey_".$ModuleNo]);
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('".$show."');";
		ECHO "location.href='list.php';";
		ECHO "</script>";
	}
	Else{
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('查無要修改資料!');" ;
		ECHO "location.href='list.php';" ;
		ECHO "</script>" ;
		exit() ;
	}
}

$SQL = "Select * From webcontrol Where PKey =".SqlFilter($Update_PKey,"int");
$DR1 = new recordset($SQL);
if ($DR1->field("PKey") != ""){
	$strID = $DR1->field("strID");
	$strName = $DR1->field("strName");
	$strPW = $DR1->field("strPW");
	$M1 = explode(",",$DR1->field("FunctionID"));
	$dtUDate = $DR1->field("dtUDate");
	$UserID = $DR1->field("UserID");
}
else{
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('查無要修改資料!');" ;
	ECHO "location.href='".$ModuleLink[$ModuleNo-1]."';" ;
	ECHO "</script>" ;
	exit() ;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require("../_in_code_head.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle1.$pageTitle2 ?></title>
<?php require("../_in_javascript.php"); ?>
<script language="JavaScript" type="text/javascript">
//偵測Form裡的各欄位----^_^
function login(theForm) 
 {
	theForm.submit()
  }
  
function fieldCheck0(theForm) {
	
  if (theForm.strName.value == ""){
    alert("【姓名】請勿空白"); 
	theForm.strName.focus();
	return false; }	
		
	var reg = /^[a-z0-9]{6,20}$/ig;
	if (!reg.test(theForm.strID.value)){
	alert("【帳號】英文或數字6~20碼"); 
	theForm.strID.focus();
	return false;
	}
	
	var reg = /^[a-z0-9]{6,20}$/ig;
	if (! reg.test(theForm.strPW.value)){
	alert("【密碼】英文或數字6~20碼"); 
	theForm.strPW.focus();
	return false;
	}
    
	var obj = document.getElementsByName("FunctionName[]");
	var flag = false;

	for (var i = 0; i < obj.length; i++){
		if(obj[i].checked){
			flag = true;
			break;
		}
	}
	if(flag == false){
		alert("【權限】請選擇"); 
	    return false; }	
return true;

}
</script>
</head>
<body>
<?php require("../_top.php"); ?>
<div id="m-wrapper">
  <div class="m-container narrow">
    <?php require("../_sidebar.php"); ?>
    <div class="m-main">
      <?php require("../_banner.php"); ?>
      <div class="m-content">
        <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
        <h2 class="pageTitle"> <?php echo $subname ?> </h2>
        <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
          <table cellspacing="0" cellpadding="0" width="100%" border="0" class="m-tables">
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 姓名</td>
              <td>
                <input type="text" name="strName" id="strName" value="<?php echo $strName?>" class="m-input" size="20" maxlength="20" />
              </td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 帳號</td>
              <td>
                <input type="text" name="strID" id="strID" value="<?php echo $strID?>" class="m-input" size="20" maxlength="20" />
                (英文或數字6~20碼) </td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 密碼</td>
              <td>
                <input type="password" name="strPW" id="strPW" value="<?php echo $strPW?>" class="m-input" size="20" maxlength="20" />
                (英文或數字6~20碼) </td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 權限範圍</td>
              <td>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="1|<?php echo $m1.$mgw1;?>" <?php if (in_array('1',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m1.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="2|<?php echo $m2.$mgw1;?>" <?php if (in_array('2',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m2.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="3|<?php echo $m3.$mgw1;?>" <?php if (in_array('3',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m3.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="4|<?php echo $m4.$mgw1;?>" <?php if (in_array('4',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m4.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="5|<?php echo $m5.$mgw1;?>" <?php if (in_array('5',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m5.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="6|<?php echo $m6.$mgw1;?>" <?php if (in_array('6',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m6.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="7|<?php echo $m7.$mgw1;?>" <?php if (in_array('7',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $m7.$mgw1;?></div>
                <div class="item_list">
                  <input name="FunctionName[]" type="checkbox" value="99|<?php echo $s2.$mgw1;?>" <?php if (in_array('99',$M1)) {echo "checked=\"checked\"";}?> />
                  <?php echo $s2.$mgw1;?></div>
              </td>
            </tr>
            <tr>
              <td class="column-th">更新日期</td>
              <td>
                <? require_once("../_modify.php") ?>
              </td>
            </tr>
          </table>
          <?php require("../_submit.php") ?>
        </form>
      </div>
      <!--m-content-->
      <?php require("../_footer.php"); ?>
    </div>
    <!--m-main-->
  </div>
  <!--m-container-->
</div>
<!--m-wrapper-->
<?php require("../_in_code_bottom.php"); ?>
</body>
</html>
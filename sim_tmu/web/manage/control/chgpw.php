<?php
	require_once("../_inc.php");
	
	$page_list    = "list.php";
	$page_detail  = "edit.php";
	
	$mainitem    = "s1";
	$subitem     = "s10";
	$subname     = $s1."－".$s1.$mgw1;
	$unitprocess = $m_home.$icon.$s1; //單元路徑列

if ($_REQUEST["Submit"] == "送出"){
	$MSG = "";
	if ($_REQUEST["oldpw"] != ""){
		$SQL = "Select strPW From webcontrol Where strID = '".SqlFilter($_SESSION["Login_ID"],"str")."' AND strPW = '".SqlFilter($_REQUEST["oldpw"],"str")."' ";
		$DR1 = new recordset($SQL);
		if ($DR1->field("strPW") == "")
		{$MSG .= "【原登入密碼】錯誤\\n";}
		}
	else
		{$MSG .= "【原登入密碼】請勿空白\\n";}
	
	$regexp = "/^[A-Za-z0-9]{6,20}$/"; //13位的英文字符和數字串
	if (! preg_match($regexp,$_REQUEST["newpw"]))
	{$MSG .= "【新密碼】英文或數字6~20碼\\n";}
	
	if (! preg_match($regexp,$_REQUEST["repw"]))
	{$MSG .= "【確認新密碼】英文或數字6~20碼\\n";}
	
	if ($_REQUEST["repw"] != $_REQUEST["newpw"])
	{$MSG .= "【新密碼和確認新密碼】不符\\n";}

	if ($MSG == ""){
		$SQL_U = "update webcontrol set ";
		$SQL_U .= " strPW = '".SqlFilter($_POST['newpw'],"str")."',";
		$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
		$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."'";
		$SQL_U .= " Where strID = '".SqlFilter($_SESSION["Login_ID"],"str")."'";
		execute_sql($SQL_U);
		/*echo $SQL_U;
		exit;*/
		//清除Session變數
		unset($_SESSION["Pkey_".$ModuleNo]); 
		
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('密碼成功更新，下次請用新密碼登入');";
		ECHO "location.href='".$_SERVER["PHP_SELF"]."';" ;
		ECHO "</script>";
	
	}
	Else{
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
		ECHO "location.href='javascript:history.back()';";
		ECHO "</script>";}	
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

  if (theForm.oldpw.value == ""  ){
	alert("【原登入密碼】請勿空白"); 
	theForm.oldpw.value = "";
	theForm.oldpw.focus();
	return false; }		

	var reg = /^[a-z0-9]{6,20}$/ig;
	if (!reg.test(theForm.newpw.value)){
	alert("【新密碼】英文或數字6~20碼"); 
	theForm.newpw.focus();
	return false;
	}
	
  var reg = /^[a-z0-9]{6,20}$/ig;
  if (! reg.test(theForm.repw.value)){
	alert("【確認新密碼】英文或數字6~20碼"); 
	theForm.repw.focus();
	return false;
	}

  if (theForm.repw.value !=theForm.repw.value ){
    alert("【新密碼和確認新密碼】不同"); 
	theForm.repw.value = "";
	theForm.repw.focus();
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
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="form1" id="form1" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
          <input type="hidden" name="u" value="ok" />
          <div class="panel">
            <table cellspacing="0" cellpadding="0" width="100%" border="0" class="m-tables">
              <tr>
                <td class="column-th">管理者名稱<i class="fa fa-asterisk"></i></td>
                <td>admin</td>
              </tr>
              <tr>
                <td class="column-th">原登入密碼<i class="fa fa-asterisk"></i></td>
                <td>
                  <input type="text" name="oldpw" id="oldpw" value="" class="m-input" maxlength="20" />
                </td>
              </tr>
              <tr>
                <td class="column-th">新密碼<i class="fa fa-asterisk"></i></td>
                <td>
                  <input type="text" name="newpw" id="newpw" value="" class="m-input" maxlength="20" />
                  <span class="ex">（英文或數字6~20碼）</span></td>
              </tr>
              <tr>
                <td class="column-th">確認新密碼<i class="fa fa-asterisk"></i></td>
                <td>
                  <input type="text" name="repw" id="repw" value="" class="m-input" maxlength="20" />
                </td>
              </tr>
            </table>
          </div>
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
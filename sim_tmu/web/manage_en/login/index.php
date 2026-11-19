<?php
require_once("../_inc.php");

if (strtolower($_REQUEST['Action']) == 'logout'){
	session_destroy();
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('你已執行登出動作!!');";
	ECHO "location.href='index.php';";
	ECHO "</script>";
	}

	$sql = "select * From webcontrol Where strID = 'Admin'";	
	$rs = new recordset($sql);
	if ($rs->eof){
		$sql  = "insert into webcontrol set" ;
		$sql .= " strName='網站管理者',";		
		$sql .= " strID='Admin',";		
		$sql .= " strPW='123456',";		
		$sql .= " FunctionID='1,2,3,4,5,6,7,8,9,10,11,12,13,14,15',";		
		$sql .= " UserID='Admin',";		
		$sql .= " dtUDate= '".strftime("%Y-%m-%d %H:%M:%S")."',";
		$sql .= " dtDate='".strftime("%Y/%m/%d %H:%M:%S")."'";
		execute_sql($sql);
	}

If ( $_SESSION['Manage'] == 'Yes' && strlen($_SESSION["Login_ID"]) > 0 && $_SESSION["CoName"] == "cem" ){
	 location_href("login.php");
	 exit();
} 

//帳號傳值
$strID = SqlFilter($_REQUEST["strID"],"str");

//密碼傳值
$strPW = SqlFilter($_REQUEST["strPW"],"str");

if ($_REQUEST['Submit'] == '送出'){

	$sql = "select * from webcontrol Where strID='$strID' ";
	$rs = new recordset($sql);

	if (! $rs->eof){
		if ($rs->field("strPW") == $strPW){
			$_SESSION["Manage"] = "Yes";//是否登入
			$_SESSION["UserName"] = $rs->field("strName"); //姓名		
			$_SESSION["Login_ID"] = $rs->field("strID"); //޲帳號
			$_SESSION["FunctionID"] = $rs->field("FunctionID"); //޲權限
			$_SESSION["CoName"] = "cem"; //޲公司代表英文名
			location_href("login.php");
			exit();}
		else
		{			
			Echo "<script language=\"javascript\">" ;
			Echo "alert('密碼不符!!');";
			Echo "location.href='".$_SERVER['PHP_SELF']."';";
			Echo "</script>";
			exit();
		}
			
	}else{			
		Echo "<script language=\"javascript\">" ;
		Echo "alert('帳號不符!!');";
		Echo "location.href='".$_SERVER['PHP_SELF']."';";
		Echo "</script>";
		exit();
	}

}

$mainitem="index";
$subname=$pageTitle2; 
$is_list="1";
$unitprocess=$pageTitle2;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require("../_in_code_head.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle1.$pageTitle2 ?></title>
<?php require("../_in_javascript.php"); ?>
<script language="JavaScript">
//偵測Form裡的各欄位----^_^
function sbForm(){
	if(fieldCheck0()){
	  document.form1.submit();
	}
}
  
function fieldCheck0(theForm) {
  var theForm = document.form1;	
  if (theForm.strID.value == ""  ){
	alert("【帳號】請勿空白"); 
	theForm.strID.focus();
	return false; }		

  if (theForm.strPW.value == ""  ){
    alert("【密碼】請勿空白"); 
	theForm.strPW.focus();
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
        <form class="form-signin" role="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="form1" id="form1" onsubmit='if(fieldCheck0(this)){return true; login(this);} else {return false;}'>
          <h2 class="form-signin-heading">管理者登入</h2>
          <p>
            <label for="strID">帳號 Account</label>
            <input autofocus="autofocus" name="strID" type="text" class="m-input" id="strID" />
          </p>
          <p>
            <label for="strPW">密碼 Password</label>
            <input name="strPW" type="password" class="m-input" id="strPW" />
          </p>
          <button class="btn-red1" type="submit">LOGIN</button>
          <input name="Submit" type="hidden" id="Submit" value="送出" />
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
<?PHP
require_once("_inc.php");
if (strtolower($_REQUEST['Action']) == 'logout'){
	session_destroy();
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('你已執行登出動作!!');";
	ECHO "location.href='login/index.php';";
	ECHO "</script>";
	exit;
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
			location_href("login/login.php");
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

If ($_SESSION['Manage'] == 'Yes' && strlen($_SESSION["Login_ID"]) > 0){
	location_href("login/login.php");
	exit();
} else{
	location_href("login/index.php");
	exit();
}


$mainitem="index";
$subname=$pageTitle2; 
$is_list="1";
$unitprocess=$url_link.$pageTitle2;
?>
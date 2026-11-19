<?
session_start();  //啟動 session
@header("Cache-Control: no-cache, must-revalidate");
@header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Taipei');

require_once(dirname(dirname(__FILE__))."/include/Conn.php");//引入文件
require_once(dirname(dirname(__FILE__))."/include/Function.php");//引入文件
// *** Include the class 載入縮圖元件
require_once(dirname(dirname(__FILE__)).'/include/resize.image.class.php');

$ImageTypeLimit=".GIF.JPG.PNG";
$FileTypeLimit=".JPG.GIF.PNG.PDF.DOC.DOCX.PPT.XLS.XLSX.TXT.ZIP.RAR";
$ProductLimit=".CSV.TXT";
$pageTitle1="台北醫學大學 醫學模擬教育中心";
$pageTitle2 = "後端管理系統";
$meta_d="";
$meta_k="";
$m_home="<a href=login.php >後端管理系統</a>";
$url_link="";
$icon="&nbsp;&#187;&nbsp;";
$line_color="#f7f7f7" ;
$mgw1="管理";
$mgw2="新增/修改";
$mgw3="預覽";
$mgw4="設定";

$m1 = "最新消息";
	$m11 = "類別";
	$m12 = "項目";

$m2 = "課程";
	$m21 = "類別";
	$m22 = "課程";
	$m23 = "報名資料";

$m3 = "會員資料";

$m4 = "場地租借";

$m5 = "FAQ";

$m6 = "檔案下載";
	$m61 = "類別";
	$m62 = "項目";
	
$m7 = "相關連結";
	$m71 = "項目";

/*權限管理s2*/
$s2="員工權限";
$s1="變更密碼";
$divview="none";

$today=date("Y/m/d");
$years = date("Y"); //用date()函式取得目前年份格式0000
$months = date("m"); //用date()函式取得目前月份格式00
$days = date("d"); //用date()函式取得目前日期格式00
$day = date("Y/m/d",mktime(0,0,0,$months+1,$days,$years));

$Keywords = "";
$Action = "";
$remark_pic="<div class=red>&#187;圖檔格式只接受JPG,GIF,PNG的檔案，檔案大小限600KB以內 </div>";
$remark_save="<div class=red>&#187;檔案名稱請以英數字字元命名(不接受中文檔名及特殊字元)。</div>";
$remark_save2="<div class=red>&#187;檔案名稱請以英數字字元命名(不接受中文檔名及特殊字元)，檔案大小限3MB以內。</div>";
$remark_webupload="<br><div class=red>&#187;若選擇Web上傳模式，檔案大小限3MB以內</div>";
$remark_file1="<div class=red>&#187;檔案格式只接受JPG,GIF,PDF,DOC,PPT,XLS,TXT,ZIP,RAR的檔案</div>";
$remark_file2="<div class=red>&#187;檔案格式只接受PDF。</div>";

if (($_SESSION["Manage"] != "Yes" OR strlen($_SESSION["Login_ID"]) == 0) AND ! stristr($_SERVER["PHP_SELF"],"index.php")) {
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert(\"請先登入管理帳號!!\");";
	ECHO "location.href=\"../index.php\";";
	ECHO "</script>";}
	

//echo $_SESSION['IsAuthorized']	;
?>
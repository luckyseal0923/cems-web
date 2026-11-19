<?php
session_start();  //啟動 session
@header("Cache-Control: no-cache, must-revalidate");
@header('Content-type: text/html; charset=utf-8');

error_reporting(E_ALL ^ E_NOTICE);//忽略提醒
date_default_timezone_set('Asia/Taipei');
// *** Include the class 載入縮圖元件
require_once(dirname(dirname(__FILE__)).'/include/Function.php');
require_once(dirname(dirname(__FILE__)).'/include/Conn.php');
//------------------------------------------------------------------------
$pageTitle     = "台北醫學大學-醫學模擬教育中心";
$pageTitle2     = "台北醫學大學-醫學模擬教育中心";
$m_description = "";
$m_keywords    = "";
//------------------------------------------------------------------------
//$bodytxt = "onDragStart='return false' oncontextmenu='return false' onSelectStart='return false'";
$showDiv = "none";
//------------------------------------------------------------------------
//通知信
$m_title     = "台北醫學大學-醫學模擬教育中心";//主旨
$m_from_mail = "haoyu68@tmu.edu.tw"; //寄件者及收件者 --測試站，請勿改掉寄件者信箱
$m_to_mail   = "hungchen@tmu.edu.tw;haoyu68@tmu.edu.tw;shani@tsg.com.tw"; //收件者
$m_cc_mail   = ""; //CC
$m_bcc_mail  = ""; //BCC

//$m_smtp      = "bulk.tmu.edu.tw";

$m_SMTPAuth  = false;//true 啟動smtp認證，false關閉
$m_username  = "";//SMTP驗證帳號
$m_password  = "";//SMTP驗證密碼

$icon   = "&nbsp;&#62;&nbsp;";
$web_mail    = "";
$this_url = $_SERVER['PHP_SELF'];
//------------------------------------------------------------------------
$home="首頁";
$p1   = "最新消息";
$p1_1 = "中心活動 ";
	$p1_1_1   = "中心教學課程";
	$p1_1_2   = " 中心參訪活動";
	$p1_1_3   = "師資培訓課程";
	$p1_1_4   = "國際醫學研討";
	$p1_1_5   = "受邀校外講課";
$p1_2 = " 活動訊息";
	$p1_2_1   = "最新活動訊息";

$p2   = "中心介紹";
$p2_1 = "中心介紹";
$p2_2 = "大事紀";
$p2_3 = "中心成員";
$p2_4 = "中心位置";
$p2_5 = "中心宗旨";
$p2_6 = "榮耀與活動";

$p3   = "課程資訊";
$p3_1   = "課程資訊";
  $p3_1_1   = "模擬教育課程介紹";
	$p3_1_1_1   = "身體檢查評估與檢驗判讀";
	$p3_1_1_2   = "預防老人吸入性肺炎";	
  $p3_1_2   = "模擬課程";
	$p3_1_2_1   = "醫學系五年級基礎臨床技能";
	$p3_1_2_2   = "藥學系身體診查與藥事照護";	
  $p3_1_3   = "護理模擬課程";
  $p3_1_4   = " 師資培訓課程";	
$p3_2   = "中心課程";
  $p3_2_1   = "師資培訓課程";
	$p3_2_1_1   = "醫學模擬教育師資培育課程";
	$p3_2_1_2   = "OSCE考官資格認證課程";	

$p4   = "會員專區";
$p4_1 = "會員登入";
$p4_2 = "加入會員";
$p4_3 = "基本資料管理";
$p4_4 = "報名記錄查詢";
$p4_5 = "忘記帳號密碼";
$p4_6 = "會員登出";
$p4_7 = "報名確認";


$p5   = "場地租借";
$p5_1   = "租借管理辦法";
$p5_2   = "場地介紹/收費辦法";
$p5_3   = "場地租借";
$p6   = "器材租借";
$p7   = "下載專區";
	$p7_1   = "場地及模具借用單、繳費單";
	$p7_2   = "法規專區";
	$p7_3   = "標準化病人儲備課程教案";
	$p7_4   = "法規";
	
$p8   = "常見問題";
	$p8_1   = "常見問題類別1";
	$p8_2   = "常見問題類別2";
$p9   = "聯絡我們";
$p10   = "網站地圖";
$p11   = "相關連結";


//------------------------------------------------------------------------

$PageView = 0;
$sql = 'select PageView from count ';
$rs = new recordset($sql);
if(! $rs->eof){
	$PageView = $rs->field('PageView')+1;
}
$pagename = basename($_SERVER['PHP_SELF']);
if($pagename=='index.php'){
	$sql_u = 'update count set PageView='.$PageView;
	execute_sql($sql_u);	
}
?>

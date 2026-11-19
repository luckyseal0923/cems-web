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
$m_to_mail   = "summer@tsg.com.tw"; //收件者 hungchen@tmu.edu.tw;haoyu68@tmu.edu.tw;shani@tsg.com.tw
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
$home="Home";
$p1   = "News";
$p1_1 = "Center activities";
	$p1_1_1   = "Teaching course";
	$p1_1_2   = "Visit activities";
	$p1_1_3   = "Teacher training";
	$p1_1_4   = "International Medical Seminar";
	$p1_1_5   = "Invited lecture outside school";
$p1_2 = "Event message";
	$p1_2_1   = "Latest events";

$p2   = "About CEMS"; //中心介紹
$p2_1 = "History & Mission";
$p2_2 = "Milestones";
$p2_3 = "CEMS Members";
$p2_4 = "Location";
$p2_5 = "Vision & Task";
$p2_6 = "Honors & Awards";

$p3   = "Curriculum";
$p3_1   = "課程資訊";//課程資訊
  $p3_1_1 ="模擬教育課程介紹";//模擬教育課程介紹
  $p3_1_2 ="模擬課程";//模擬課程
  $p3_1_3 ="護理模擬課程";//護理模擬課程
  $p3_1_4 ="師資培訓課程";//師資培訓課程

$p4   = "Member";
$p4_1 = "Login";
$p4_2 = "Join Us";
$p4_3 = "Member Profile";
$p4_4 = "Registration Record";
$p4_5 = "Forgot password";
$p4_6 = "Logout";
$p4_7 = "報名確認";


$p5   = "Space Rental";
$p5_1   = "Rental Measures";
$p5_2   = "Venue & fee";
$p5_3   = "Space Rental";
$p6   = "Facility Rental";
$p7   = "Download";
	$p7_1   = "場地及模具借用單、繳費單";
	$p7_2   = "法規專區";
	$p7_3   = "標準化病人儲備課程教案";
	$p7_4   = "法規";
	
$p8   = "Q&A TMU";
	$p8_1   = "常見問題類別1";
	$p8_2   = "常見問題類別2";
$p9   = "Contact us";
$p10   = "Sitemap";
$p11   = "Link";


//------------------------------------------------------------------------
?>

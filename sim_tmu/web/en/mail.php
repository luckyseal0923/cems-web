<?php
	
	require_once("_inc.php");
	require_once("../include/Function.php");
	require_once("_code_public.php");
	
	//echo "code_check=".$_SESSION["code_check"]."<br>";
	//echo "Code=".$_POST['Code'];

	if (strLen($_POST["strName"]) == 0)
	{$MSG .= "【聯絡人】空白\\n";}
	
	if (strLen($_POST["Tel"]) == 0)
	{$MSG .= "【電話】空白\\n";}
	
	if (!CheckMail($_POST["EMail"]))
	{$MSG .= "【信箱】空白或格式錯誤\\n";}
	
	if (strLen($_POST["Message"]) == 0)
	{$MSG .= "【留言】空白\\n";}
	
	if($_SESSION["code_check"] != $_POST['Code'] )
	{$MSG .= "【驗證碼】錯誤\\n";}
	 
	 
if ($MSG == ""){
	
	$mail_subject = $m_title."-聯絡我們"; 
	
	//郵件內容
	$BODY = "<html><head>";
	$BODY .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
	$BODY .= "</head><style type=\"text/css\">";
	$BODY .= ".font1 { font-size: 15px; color: #333333; font-weight: bold;}";
	$BODY .= "</style><body bgcolor=\"#FFFFFF\">";
	$BODY .= "<p>&nbsp;&nbsp;</p><div >";
	$BODY .= "<center>";
	$BODY .= "<table width=\"70%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"border-collapse: collapse\" bordercolor=\"#C6C6C6\" align=\"center\">";
	$BODY .= "<tr><td colspan=\"2\" bgcolor=\"#1488DE\" align=\"center\">";
	$BODY .= "<font color=\"#ffffff\" font size=\"5\"  font-weight: bold ><b>".$mail_subject."</b></font></td>";
	$BODY .= "</tr>";
	
	$BODY .= "<tr>";
	$BODY .= "<td class=\"font1\" width=\"30%\">單位</td>";
	$BODY .= "<td>".$_POST["Company"]."</td>";
		
	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\" width=\"30%\">聯絡人</td>";
	$BODY .= "<td>".$_POST["strName"].$_POST["Sex"]."</td>";

	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\">電話</td>";
	$BODY .= "<td>".$_POST["Tel"]."</td>";

	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\">傳真</td>";
	$BODY .= "<td>".$_POST["Fax"]."</td>";

	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\">電子信箱</td>";
	$BODY .= "<td>".$_POST["EMail"]."</td>";

	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\">地址</td>";
	$BODY .= "<td>".$_POST["Address"]."</td>";

	$BODY .= "</tr><tr>";
	$BODY .= "<td class=\"font1\">留言</td>";
	$BODY .= "<td>".nl2br($_POST["Message"])."</td></tr>";

	$BODY .= "</table></center></div></body></html>";
		
	//連到遠端主機發送信件 Open
	$base_url = 'http://webmail.tsg.com.tw/mail.php';
	$data = array(
		'WebUrl' => $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"],//主機
		'FromName' => $m_title,//寄件者
		'FromMail' => $m_from_mail,//寄件信箱
		'toName' => $m_title,//收件者
		'toMail' => $m_to_mail,//收件信箱，要發送到多組信箱時，mail請使用;分隔
		'Subject' => $mail_subject,//主旨
		'MailBody' => $BODY//內文
	);

	$header = array('Content-Type: application/json');
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $base_url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, true);
	$result = curl_exec($curl);
	curl_close($curl);	
	//連到遠端主機發送信件 End
	
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('謝謝您的來信，我們將儘速為您服務。');" ;
	ECHO "location.href='index.php';" ;
	ECHO "</script>" ;
	exit() ;	
}
else{
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
	ECHO "location.href='javascript:history.back()';";
	ECHO "</script>";
}
?>
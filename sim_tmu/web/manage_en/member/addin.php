<? require_once("../_inc.php");?>
<?
	$ModuleNo = 3;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	//表單檔案驗證
	if ($_REQUEST['Submit'] == "送出"){

		$MSG = "";
		
		/*判斷帳號*/
		if (strLen($_POST['strID']) == 0){
			$MSG .= "【帳號】請勿空白!\\n";
		}
		
		/*判斷密碼*/
		if (strLen($_POST['strPW']) == 0){
			$MSG .= "【密碼】請勿空白!\\n";
		}
		
		/*判斷確認密碼*/
		if ( $_POST['strPW'] != $_POST['strPW2'] ){
			$MSG .= "【確認密碼不同】\\n";
		}
		
		/*判斷暱稱*/
		if (strLen($_POST['strNickName']) == 0){
			$MSG .= "【暱稱】請勿空白!\\n";
		}
		
		/*判斷姓名*/
		if (strLen($_POST['strName']) == 0){
			$MSG .= "【姓名】請勿空白!\\n";
		}
		
		/*判斷聯絡電話*/
		if (strLen($_POST['strTel']) == 0){
			$MSG .= "【聯絡電話】請勿空白!\\n";
		}
		
		/*判斷聯絡地址(中)*/
		if (strLen($_POST['strAddress']) == 0){
			$MSG .= "【聯絡地址(中)】請勿空白!\\n";
		}
		
		/*電子郵件*/
		if (!CheckMail($_POST["EMail"])){
			$MSG .= "【電子郵件】空白或格式錯誤!\\n";
		}
		
		if ($MSG == ""){
			$SQL = "Select * From member Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$Member_PKey = $DR1->field("PKey");
				$SQL_U = " Update member set ";
				$SQL_U .= " strID = '".SqlFilter($_POST['strID'],"tab")."',";
				$SQL_U .= " strPW = '".SqlFilter($_POST['strPW'],"tab")."',";
				$SQL_U .= " strNickName = '".SqlFilter($_POST['strNickName'],"tab")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " strEName = '".SqlFilter($_POST['strEName'],"tab")."',";
				$SQL_U .= " strNo = '".SqlFilter($_POST['strNo'],"tab")."',";
				$SQL_U .= " strTel = '".SqlFilter($_POST['strTel'],"tab")."',";
				$SQL_U .= " strAddress = '".SqlFilter($_POST['strAddress'],"tab")."',";
				$SQL_U .= " strEAddress = '".SqlFilter($_POST['strEAddress'],"tab")."',";
				$SQL_U .= " Email = '".SqlFilter($_POST['EMail'],"tab")."',";
				$SQL_U .= " strType = '".SqlFilter($_POST['strType'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where Pkey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}
			else{
				
				/*判斷ID是否已有人使用*/
				$SQL = "Select * From member Where strID = '".SqlFilter($_POST['strID'],"tab")."'";
				$rschk = new recordset($SQL);
				if (! $rschk->eof ){
					echo "<script language=\"javascript\">" ;
					echo "alert('此帳號已有人使用!');";
					echo "history.back();;";
					echo "</script>";
					exit;
				}
				
				/*取得寄信mail及姓名*/
				$ToName = SqlFilter($_POST['strName'],"tab");
				$ToEmail = SqlFilter($_POST['EMail'],"tab");
				
				$SQL_U = "Insert Into member Set ";
				$SQL_U .= " strID = '".SqlFilter($_POST['strID'],"tab")."',";
				$SQL_U .= " strPW = '".SqlFilter($_POST['strPW'],"tab")."',";
				$SQL_U .= " strNickName = '".SqlFilter($_POST['strNickName'],"tab")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " strEName = '".SqlFilter($_POST['strEName'],"tab")."',";
				$SQL_U .= " strNo = '".SqlFilter($_POST['strNo'],"tab")."',";
				$SQL_U .= " strTel = '".SqlFilter($_POST['strTel'],"tab")."',";
				$SQL_U .= " strAddress = '".SqlFilter($_POST['strAddress'],"tab")."',";
				$SQL_U .= " strEAddress = '".SqlFilter($_POST['strEAddress'],"tab")."',";
				$SQL_U .= " Email = '".SqlFilter($_POST['EMail'],"tab")."',";
				$SQL_U .= " strType = '".SqlFilter($_POST['strType'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				//取出主鍵值
				$Member_PKey = execute_sql($SQL_U);
				$show = "新增成功!";
				
				//發送通知信
				$URL = RootURL($_SERVER['PHP_SELF'])."_MemberMail.php?PKey=".authcode($Member_PKey,"ENCODE");
				$BODY = getUrlContent($URL);
				
				//To User
				SendMail($ToName,$ToEmail,"臺北醫學大學-醫學模擬教育中心","queena@tsg.com.tw"," 《臺北醫學大學-醫學模擬教育中心》 加入會員通知信", $BODY);//(收件者,收件信箱,寄件者,寄件信箱,主旨,內文)
			}
	
			//清除Session變數
			unset($_SESSION["Pkey_".$ModuleNo]);
	
			echo "<script language=\"javascript\">" ;
			echo "alert('".$show."');";
			echo "location.href='list.php';";
			echo "</script>";
			exit;
		}
		else{
			echo "<script language=\"javascript\">" ;
			echo "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			}
	}
?>
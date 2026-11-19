<? require_once("../_inc.php");?>
<?
	$ModuleNo = 1;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***表單檔案驗證***/
	if ($_REQUEST['Submit'] == "送出"){

		$MSG = "";
	
		/*判斷租借教室*/
		if (strLen($_POST['classroom']) == ""){
			$MSG .= "【租借教室】請選擇!\\n";
		}
			
		/*判斷租借日期-年*/
		if (strLen($_POST['Year']) == ""){
			$MSG .= "【租借日期-年】請選擇!\\n";
		}
	
		/*判斷租借日期-月*/
		if (strLen($_POST['Month']) == ""){
			$MSG .= "【租借日期-月】請選擇!\\n";
		}

		/*判斷租借日期-日*/
		if (strLen($_POST['Day']) == ""){
			$MSG .= "【租借日期-日】請選擇!\\n";
		}
		
		/*組合租借日期*/
		$Rental_Date = $_POST['Year']."-".$_POST['Month']."-".$_POST['Day'];
		
		/*判斷租借日期是否小於今天*/
		if ( strtotime($Rental_Date) < strtotime(date("Y-m-d")) ){
			$MSG .= "租借日期不可小於今日!\\n";
		}

		/*判斷租借時間*/
		if (strLen($_POST['Time']) == ""){
			$MSG .= "【租借時間】請選擇!\\n";
		}
		
		/*取得目前時間區間*/
		if ( date("H") >= 8 && date("H") <= 10 ){ $NowH = 1;}
		if ( date("H") >= 10 && date("H") <= 12 ){ $NowH = 2;}
		if ( date("H") >= 12 && date("H") <= 14 ){ $NowH = 3;}
		if ( date("H") >= 14 && date("H") <= 16 ){ $NowH = 4;}
		if ( date("H") >= 16 && date("H") <= 18 ){ $NowH = 5;}
		if ( date("H") >= 18 && date("H") <= 20 ){ $NowH = 6;}
		
		if ( (strtotime($Rental_Date) == strtotime(date("Y-m-d"))) && $_POST['Time'] != $NowH ){
			$MSG .= "【租借時間】錯誤!\\n";
		}

		/*判斷租借單位*/
		if (strLen($_POST['runit']) == ""){
			$MSG .= "【租借單位】請勿空白!\\n";
		}		
		
		/*判斷聯絡人*/
		if (strLen($_POST['name']) == ""){
			$MSG .= "【聯絡人】請勿空白!\\n";
		}		
		
		/*判斷電子郵件*/
		if (!CheckMail($_POST["EMail"])){
			$MSG .= "【電子郵件】空白或格式錯誤!\\n";
		}

		/*判斷聯絡電話*/
		if (strLen($_POST['tel']) == ""){
			$MSG .= "【電話】請勿空白!\\n";
		}		

		/*判斷說明*/
		if (strLen($_POST['message']) == ""){
			$MSG .= "【說明】請勿空白!\\n";
		}
		
		/***判斷資料是否存在(是-更新；否-新增)及圖片處理程式***/
		if ($MSG == ""){
			$SQL = "Select * From rental_p Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			
			if ($DR1->field("PKey")!=""){
				$Ralten_PKey = $DR1->field("PKey");
				$SQL_U = " Update rental_p set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " classroom_PKey = '".SqlFilter($_POST['classroom'],"tab")."',";
				$SQL_U .= " Rental_year = '".SqlFilter($_POST['Year'],"tab")."',";
				$SQL_U .= " Rental_month = '".SqlFilter($_POST['Month'],"tab")."',";
				$SQL_U .= " Rental_day = '".SqlFilter($_POST['Day'],"tab")."',";
				$SQL_U .= " Rental_Date = '".SqlFilter($Rental_Date,"tab")."',";
				$SQL_U .= " Rental_time = '".SqlFilter($_POST['Time'],"tab")."',";
				$SQL_U .= " Rental_unit = '".SqlFilter($_POST['runit'],"tab")."',";
				$SQL_U .= " Rental_name = '".SqlFilter($_POST['name'],"tab")."',";
				$SQL_U .= " Rental_email = '".SqlFilter($_POST['EMail'],"tab")."',";
				$SQL_U .= " Rental_tel = '".SqlFilter($_POST['tel'],"tab")."',";
				$SQL_U .= " Rental_message = '".SqlFilter($_POST['message'],"tab")."',";
				$SQL_U .= " Rental_Status = '".SqlFilter($_POST['Rental_Status'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where Pkey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}
			else{
				$SQL_U = "Insert Into rental_p Set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " classroom_PKey = '".SqlFilter($_POST['classroom'],"tab")."',";
				$SQL_U .= " Rental_year = '".SqlFilter($_POST['Year'],"tab")."',";
				$SQL_U .= " Rental_month = '".SqlFilter($_POST['Month'],"tab")."',";
				$SQL_U .= " Rental_day = '".SqlFilter($_POST['Day'],"tab")."',";
				$SQL_U .= " Rental_Date = '".SqlFilter($Rental_Date,"tab")."',";
				$SQL_U .= " Rental_time = '".SqlFilter($_POST['Time'],"tab")."',";
				$SQL_U .= " Rental_unit = '".SqlFilter($_POST['runit'],"tab")."',";
				$SQL_U .= " Rental_name = '".SqlFilter($_POST['name'],"tab")."',";
				$SQL_U .= " Rental_email = '".SqlFilter($_POST['EMail'],"tab")."',";
				$SQL_U .= " Rental_tel = '".SqlFilter($_POST['tel'],"tab")."',";
				$SQL_U .= " Rental_message = '".SqlFilter($_POST['message'],"tab")."',";
				$SQL_U .= " Rental_Status = '".SqlFilter($_POST['Rental_Status'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				/*取主鍵值*/
				$Ralten_PKey = execute_sql($SQL_U);
				$show = "新增成功!";
			}
			
			/*寄信給申請人*/
//			if ( SqlFilter($_POST['Rental_Status'],"tab") == "Yes" ){
//				
//				/*送信資訊*/
//				$ToEmail = SqlFilter($_POST['EMail'],"tab");
//				$ToName = SqlFilter($_POST['name'],"tab");
//				
//				//發送通知信
//				$URL = RootURL($_SERVER['PHP_SELF'])."_ClassRoomMail.php?PKey=".authcode($Member_PKey,"ENCODE");
//				$BODY = getUrlContent($URL);
//				//To User
//				SendMail($ToName,$ToEmail,"臺北醫學大學醫學模擬教育中心","queena@tsg.com.tw","臺北醫學大學醫學模擬教育中心-租借教室通知信", $BODY);//(收件者,收件信箱,寄件者,寄件信箱,主旨,內文)
//			}
	
			//清除Session變數
			unset($_SESSION["Pkey_".$ModuleNo]);
	
			echo "<script language=\"javascript\">" ;
			echo "alert('".$show."');";
			echo "location.href='list.php';";
			echo "</script>";
		}
		else{
			echo "<script language=\"javascript\">" ;
			echo "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			}
	}
?>
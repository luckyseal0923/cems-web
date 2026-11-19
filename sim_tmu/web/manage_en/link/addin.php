<? require_once("../_inc.php");?>
<?
	$ModuleNo = 1;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	//表單檔案驗證
	if ($_REQUEST['Submit'] == "送出"){

		$MSG = "";
	
		//連結文字
		if (strLen($_POST['strName']) == ""){
			$MSG .= "【連結文字】請選擇!\\n";
		}
			
		//連結網址
		if (strLen($_POST['strUrl']) == ""){
			$MSG .= "【連結網址】請選擇!\\n";
		}
		
		//判斷資料是否存在(是-更新；否-新增)及圖片處理程式
		if ($MSG == ""){
			$SQL = "Select * From link_item Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			
			if ($DR1->field("PKey")!=""){
				$Ralten_PKey = $DR1->field("PKey");
				$SQL_U = " Update link_item set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"tab")."',";
				$SQL_U .= " strUrl = '".SqlFilter($_POST['strUrl'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where Pkey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}
			else{
				$SQL_U = "Insert Into link_item Set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"tab")."',";
				$SQL_U .= " strUrl = '".SqlFilter($_POST['strUrl'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				execute_sql($SQL_U);				
				$show = "新增成功!";
			}
			
			//清除Session變數
			unset($_SESSION["PKey_".$ModuleNo]);
			
			/*組合導回參數*/
			$str = "?Send=0";
			if ( SqlFilter($_REQUEST["Page"],"int") > 0 )
				$str .= "&Page=".SqlFilter($_REQUEST["Page"],"int");
				
			if ( $_REQUEST["Q_Keywords"] != "" )
				$str .= "&Keywords=".urlencode(SqlFilter($_REQUEST["Q_Keywords"],"str"));
	
			echo "<script language=\"javascript\">" ;
			echo "alert('".$show."');";
			echo "location.href='list.php".$str."';";
			echo "</script>";
			exit;
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
	}
?>
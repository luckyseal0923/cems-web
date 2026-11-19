<?
	require_once("../_inc.php");
	$ModuleNo = 1;
	
	/***參數解碼(類別PKey)***/
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}

	/***表單檔案驗證***/
	if ($_REQUEST['Submit'] == "送出"){
		
		$MSG = "";
	
		/*判斷順序*/
		if ( is_numeric(SqlFilter($_POST['Sort'],"int")) == false ){
			$MSG .= "【順序】空白或非數字格式!\\n";
		}
		
		/*判斷主類別*/
		if (strLen($_POST['class1']) == 0){
			$MSG .= "【類別名稱】請勿空白!\\n";
		}
	
		/*判斷類別名稱*/
		if (strLen($_POST['strName']) == 0){
			$MSG .= "【類別名稱】請勿空白!\\n";
		}

		/***判斷資料是否存在(是-更新；否-新增)***/
		if ($MSG == ""){
			$SQL = "Select * From course_class2 Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$SQL_U = "update course_class2 set ";
				$SQL_U .= " intLang = '1',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " class1_PKey = '".SqlFilter($_POST['class1'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION["Login_ID"],"tab")."'";
				$SQL_U .= " Where Pkey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}
			else{
				$SQL_U = "Insert Into course_class2 Set ";
				$SQL_U .= " intLang = '1',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " class1_PKey = '".SqlFilter($_POST['class1'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION["Login_ID"],"tab")."'";
				execute_sql($SQL_U);
				$show = "新增成功!";
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
			echo "alert('發生錯誤，請確認下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
	}
?>
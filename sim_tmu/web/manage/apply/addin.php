<? require_once("../_inc.php");?>
<? require_once("../../_inc.php");?>
<?
	$ModuleNo = 2;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***表單檔案驗證***/
	if ($_REQUEST['Submit'] == "送出"){
		
		//$apply_PKey = $_POST["apply_PKey"];
		
		/*判斷課程是否額滿*/
//		$SQL = "Select PeopleNumber2,PeopleNumber1 From course Where PKey = ".SqlFilter($Course_PKey,"int");
//		$rschk = new recordset($SQL);
//		if (! $rschk->eof ){
//			if ( $rschk->field("PeopleNumber2") =< $rschk->field("PeopleNumber1") ){
//				echo "<script language=\"javascript\">" ;
//				echo "alert('報名人數已滿!');";
//				echo "location.href='p3-course.php';";
//				echo "<//script>";
//				exit;
//			}
//		}

		/*取得會員email*/
		$SQL = "Select * From apply Where PKey = ".SqlFilter($Update_PKey,"int");
		$rs = new recordset($SQL);
		if (! $rs->eof ){
			
			$Course_Name = $rs->field("Course_Name");
			
			/*member*/
			$SQL = "Select strName,Email From member Where PKey = ".SqlFilter($rs->field("member_PKey"),"int");
			$rs1 = new recordset($SQL);
			if (! $rs1->eof ){
				$ToName = $rs1->field("strName");
				$ToEmail = $rs1->field("Email");
			}
		}

		$SQL_U = " Update apply Set ";
		$SQL_U .= " Flag = '".SqlFilter($_POST['Flag'],"int")."'";
		$SQL_U .= " Where PKey =".SqlFilter($Update_PKey,"int");
		execute_sql($SQL_U);
		
		/*發送通知信*/
		$URL = RootURL($_SERVER['PHP_SELF'])."_ApplyMail1.php?PKey=".authcode($Update_PKey,"ENCODE");
		$BODY = getUrlContent($URL);
		
		/*To User*/
		SendMail($ToName,$ToEmail,$m_title,$m_from_mail,$m_title.$Course_Name." 繳費報名成功通知信", $BODY);//(收件者,收件信箱,寄件者,寄件信箱,主旨,內文)
		
		//清除Session變數
		unset($_SESSION["Pkey_".$ModuleNo]);

		echo "<script language=\"javascript\">" ;
		echo "alert('報名狀態更新成功!');";
		echo "location.href='list.php';";
		echo "</script>";
		exit;
	}
?>
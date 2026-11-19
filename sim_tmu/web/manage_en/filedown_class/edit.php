<?
	require_once("../_inc.php");
	$mainitem    = "m6";
	$subitem     = "m61";
	$subname     = $m6.$icon.$m61.$mgw2;
	$unitprocess = $m_home.$icon.$m6.$icon.$m61.$mgw2; //單元路徑列
	$ModuleNo    = 6;
	
	/***參數解碼***/
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***表單檔案驗證***/
	if ($_REQUEST['Submit'] == "送出"){

		$MSG = "";
		
		/*判斷項目順序*/
		if ( is_numeric($_POST['Sort']) == false ){
			$MSG .= " 【類別順序】空白或非數字格式!\\n";
		}
		
		/*判斷項目標題*/
		if (strLen($_POST['strName']) == 0){
			$MSG .= "【類別標題】請勿空白!\\n";
		}
		
		if ($MSG == ""){
			$SQL = "Select * From filedown_class1 Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$Faq_PKey = $DR1->field("PKey");
				$SQL_U = " Update filedown_class1 set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where PKey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}else{
				$SQL_U = "Insert Into filedown_class1 Set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				//取出主鍵值
				$Faq_PKey = execute_sql($SQL_U);
				$show = "新增成功!";
			}
			
			/*組合導回參數*/
			$str = "?Send=0";
			if ( SqlFilter($_REQUEST["Page"],"int") > 0 )
				$str .= "&Page=".SqlFilter($_REQUEST["Page"],"int");
				
			if ( SqlFilter($_REQUEST["Q_Upload"],"tab") != "" )
				$str .= "&Upload=".SqlFilter($_REQUEST["Q_Upload"],"tab");
				
			if ( $_REQUEST["Q_Keywords"] != "" && $_REQUEST["Q_Keywords"] != "請輸入標題搜尋" )
				$str .= "&Keywords=".urlencode(SqlFilter($_REQUEST["Q_Keywords"],"str"));
	
			/*清除Session變數*/
			unset($_SESSION["Pkey_".$ModuleNo]);
			echo "<script language=\"javascript\">" ;
			echo "alert('".$show."');";
			echo "location.href='list.php".$str."';";
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

	/***取得明細資料***/
	$SQL = "Select * From filedown_class1 Where PKey=".SqlFilter($Update_PKey,"int");
	$rsUD = new recordset($SQL);
	if (! $rsUD->eof){
		$PKey = $rsUD->field("PKey");
		$Sort = $rsUD->field("Sort");
		$strName = $rsUD->field("strName");
		$Upload = $rsUD->field("Upload");
		$UserID = $rsUD->field("UserID");
		$dtUDate = $rsUD->field("dtUDate");		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $pageTitle1.$pageTitle2 ?></title>
<? require_once("../_in_javascript.php") ?>
<script language="JavaScript" src="../js/area.js"></SCRIPT>
<script language="JavaScript" type="text/javascript">

	/***判斷表單欄位***/
	function login(theForm){
		theForm.submit();
	}
	
	function fieldCheck0(theForm) {
		
		/*判斷順序*/
		if ( isNaN(parseInt(theForm.Sort.value)) ){
			alert("【類別順序】格式錯誤"); 
			theForm.Sort.value = "";
			theForm.Sort.focus();
			return false;}

		/*判斷會員暱稱*/
		if (theForm.strName.value == ""){
			alert("【類別標題】請勿空白!");
			theForm.strName.focus();
			return false;}
			
		return true;
	}
</script>
</head>
<body>
<?php require("../_top.php"); ?>
<div id="m-wrapper">
  <div class="m-container narrow">
    <?php require("../_sidebar.php"); ?>
    <div class="m-main">
      <?php require("../_banner.php"); ?>
      <div class="m-content">
        <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
        <h2 class="pageTitle"> <?php echo $subname ?> </h2>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
          <table width="100%" cellspacing="0" cellpadding="0" class="m-tables">
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 類別順序</td>
              <td width="1399" class="line-d"><input name="Sort" type="text" class="m-input" id="Sort" size="3" value="<? echo AddZero($Sort)?>"/>
                <span class="red">( 限輸入數字 , </span><span class="orange">可填0 ,可重覆</span><span class="red"> )</span></td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 類別標題</td>
              <td><input name="strName" type="text" class="m-input" id="strName" value="<?php echo $strName?>" size="60" /></td>
            </tr>
            <tr>
              <td class="column-th">上下架</td>
              <td><select name="Upload" id="Upload" class="m-select">
                <option value="Yes" <? if ($Upload=="Yes"){ echo "selected=\"selected\"";}?>>上架</option>
                <option value="No" <? if ($Upload=="No"){ echo "selected=\"selected\"";}?>>下架</option>
              </select></td>
            </tr>
            <?php require("../include2/_in_up_info.php") ?>
          </table>
          <?php require("../_submit.php") ?>
        </form>
      </div>
      <!--m-content-->
      <?php require("../_footer.php"); ?>
    </div>
    <!--m-main-->
  </div>
  <!--m-container-->
</div>
<!--m-wrapper-->
<?php require("../_in_code_bottom.php"); ?>
</body>
</html>
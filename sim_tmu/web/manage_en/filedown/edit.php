<?
	require_once("../_inc.php");
	$mainitem    = "m6";
	$subitem     = "m62";
	$subname     = $m6.$icon.$m62.$mgw1;
	$unitprocess = $m_home.$icon.$m6.$icon.$m62.$mgw1; //單元路徑列
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
			$MSG .= " 【項目順序】空白或非數字格式!\\n";
		}
		
		/*判斷項目標題*/
		if (strLen($_POST['strName']) == 0){
			$MSG .= "【項目標題】請勿空白!\\n";
		}
		
		/*****文檔檢查程式(1文)*****/
		
		// 上傳檔將存入此路徑裡的 uploads 資料夾
		$upload_dir = "../../Upload/filedown/";
		//檔案前置名
		$ForderName = "filedown_";
		// 上傳檔總數
		$total_uploads = 1;
		// 上傳檔大小限制，此處限制為3MB
		$size_bytes = 3000 * 1024;
		// 副檔名限制
		$limitedext = array(".gif",".jpg",".png",".pdf",".doc",".docx",".ppt",".xls",".xlsx",".txt",".zip",".rar");
	
		// 用迴圈讀取上傳檔案資料
		for ($i = 1; $i <= $total_uploads; $i++) {
		   $new_file = $_FILES['Photo'.$i];
		   // 讀取上傳檔名
		   $file_name = $new_file['name'];
			// 把檔名中的空格替換成 "_"
		   $file_name = str_replace(' ', '_', $file_name);
		   // 存入暫存區的檔名
		   $file_tmp = $new_file['tmp_name'];
		   // 檔案大小
		   $file_size = $new_file['size'];
		   // 判斷檔案是否指定上傳檔案…
		   if (is_uploaded_file($file_tmp)) {
			// 若有上傳檔，則取出該檔案的副檔名
			 $ext = strrchr($file_name,'.');
			 // 判斷副檔名是否符合預期
			 if (!in_array(strtolower($ext),$limitedext)) {
				// 不符合預期，顯示錯誤訊息。
				$MSG .="檔案 $i: ($file_name) 的檔案副檔名有誤（只允許GIF和JPEG檔） <br />";
			 }else{
				// 檢查檔案是否太大
				
			   if ($file_size > 1024000){
					$FileSize = number_format($file_size / 1024000,2)."MB";
			   }else{
					$FileSize = number_format($file_size / 1024,0) ."KB";
			   }

				
			   if ($file_size > $size_bytes){
				   $MSG .="檔案 $i: ($file_name) 無法上傳，請檢查檔案是否小於 ". $size_bytes / 1024 ." KB。<br />";
			   }else{
	
					$file_name = $ForderName. strftime("%Y%m%d%H%M%S").$i.$ext;      //更改上傳的圖檔名稱.
	
					// 放入陣列
					$Photo[$i] = $file_name;       //存入資料庫的 檔案存取路徑
				   if (move_uploaded_file($file_tmp,$upload_dir.$file_name)) {
						// 取得上傳圖片
						$src = getimagesize($upload_dir.$file_name);
						// 取得來源圖片長寬
						$PhotoW[$i] = $src[0];
						$PhotoH[$i] = $src[1];
				   }
			   }
			 }
		   }
		}
		
		if ($MSG == ""){
			$SQL = "Select * From filedown Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$PKey = $DR1->field("PKey");
				$SQL_U = " Update filedown set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Class1_PKey = '".SqlFilter($_POST['Class1'],"int")."',";
				$SQL_U .= " intLink = '".SqlFilter($_POST['intLink'],"int")."',";
				$SQL_U .= " strLink = '".SqlFilter($_POST['strLink'],"tab")."',";
				$SQL_U .= " FileSize = '".SqlFilter($FileSize,"tab")."',";
				for ($i = 1; $i <= $total_uploads; $i++) {
					if (strLen($Photo[$i]) > 10){
						//刪除原始圖檔
						DelFile($upload_dir.$DR1->field("FileName"));
						$SQL_U .= "FileName= '".SqlFilter($Photo[$i],"tab")."',";
					}
				}
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where PKey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}else{
				$SQL_U = "Insert Into filedown Set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " Class1_PKey = '".SqlFilter($_POST['Class1'],"int")."',";
				$SQL_U .= " intLink = '".SqlFilter($_POST['intLink'],"int")."',";
				$SQL_U .= " strLink = '".SqlFilter($_POST['strLink'],"tab")."',";
				$SQL_U .= " FileSize = '".SqlFilter($FileSize,"tab")."',";
				for ($i = 1; $i <= $total_uploads; $i++) {
					if (strLen($Photo[$i]) > 10){
						//刪除原始圖檔
						$SQL_U .= "FileName= '".SqlFilter($Photo[$i],"tab")."',";
					}
				}
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				execute_sql($SQL_U);
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
	$SQL = "Select * From filedown Where PKey=".SqlFilter($Update_PKey,"int");
	$rsUD = new recordset($SQL);
	if (! $rsUD->eof){
		$PKey = $rsUD->field("PKey");
		$Sort = $rsUD->field("Sort");
		$Class1_PKey = $rsUD->field("Class1_PKey");
		$strName = $rsUD->field("strName");
		$intLink = $rsUD->field("intLink");
		$FileName = $rsUD->field("FileName");
		$strLink = $rsUD->field("strLink");
		$Upload = $rsUD->field("Upload");
		$UserID = $rsUD->field("UserID");
		$dtUDate = $rsUD->field("dtUDate");
	}
	
	/***刪除選取的文檔***/
	if ( $_REQUEST["motion"] == "fdel" And is_numeric($_REQUEST["imgNo"]) ){
		
		/*取出圖檔路徑*/
		$SQL = "Select * From filedown Where PKey=".SqlFilter($_REQUEST["imgNo"],"int");
		$DR1 = new recordset($SQL);
		
		if ( $DR1->field("PKey") != "" ){
			$PKey = authcode($DR1->field("PKey"),'ENCODE');			
			/*刪除實體檔案*/
			DelFile("../../Upload/filedown/".$DR1->field("FileName"));
			/*刪除圖檔*/
			$SQL = " Update filedown Set FileName='',FileSize=0 Where PKey = ".$DR1->field("PKey");
			execute_sql($SQL);
		}
		echo "<script language=\"javascript\">" ;
		echo "alert('成功刪除!');" ;
		echo "location.href='".$_SERVER["PHP_SELF"]."?PKey=".$PKey."';" ;
		echo "</script>" ;
		exit() ;
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
			alert("【項目順序】格式錯誤"); 
			theForm.Sort.value = "";
			theForm.Sort.focus();
			return false;}

		/*判斷會員暱稱*/
		if (theForm.strName.value == ""){
			alert("【項目標題】請勿空白!");
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
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 項目順序</td>
              <td width="1399" class="line-d"><input name="Sort" type="text" class="m-input" id="Sort" size="3" value="<? echo AddZero($Sort)?>"/>
                <span class="red">( 限輸入數字 , </span><span class="orange">可填0 ,可重覆</span><span class="red"> )</span></td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 項目類別</td>
              <td>
              <select name="Class1" class="m-select">
              	<option value="">請選擇</option>
                <?php /***取得現有分類***/
					$SQL = "Select PKey,strName From filedown_class1 where intLang = 2 Order By Sort";
					$rs = new recordset($SQL);
					while (! $rs->eof ){				
				?>
						<option value="<?php echo $rs->field("PKey")?>" <?php if ( $Class1_PKey == $rs->field("PKey")){ echo "selected";} ?>><?php echo $rs->field("strName")?></option>
                <?php
                		$rs->movenext();
					}
				?>
              </select>
              </td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 項目標題</td>
              <td><input name="strName" type="text" class="m-input" id="strName" value="<?php echo $strName?>" size="60" /></td>
            </tr>
            
            <!--內容1-->
            <tr>
              <td valign="middle" class="column-th">檔案型態</td>
              <td align="left" class="line-d"><input name="intLink" type="radio" id="intLink" value="1" checked="checked" <?php if ( $intLink == 1 ){?>checked="checked"<?php }?>/>
                連結路徑
                <input name="strLink" type="text" class="m-input" id="strLink" value="<?php echo $strLink?>" size="100" maxlength="500" onchange="document.all.intLink[0].checked=true;"/>
                <span class="red">(請輸入完整路徑：http://www.abc.com...)</span><br />
                <input type="radio" name="intLink" id="intLink" value="2" <?php if ( $intLink == 2 ){?>checked="checked"<?php }?>/>
                選擇檔案
                <input name="Photo1" type="file" class="m-input" id="Photo1" size="30" onchange="document.all.intLink[1].checked=true;"/>
                ---
                <?php if(strLen($FileName) > 0){?>
                [<a href="javascript:window.open('../../Upload/filedown/<?php echo $FileName?>','_blank');" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=fdel&amp;imgNo=<?php echo $Update_PKey?>';};" class="red">刪</a>]
                <?php
                        }else{ echo "[無檔案]";}
                ?></td>
            </tr>
            <tr>
              <td class="column-th">上傳說明</td>
              <td><? echo $remark_file1;?></td>
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
<?
	require_once("../_inc.php");
	$mainitem    = "m5";
	$subitem     = "m5";
	$subname     = $m5.$mgw1;
	$unitprocess = $m_home.$icon.$m5.$mgw1; //單元路徑列
	$ModuleNo    = 5;
	
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
		
		/*****圖片檢查程式(4圖)*****/
		
		// 上傳檔將存入此路徑裡的 uploads 資料夾
		$upload_dir = "../../Upload/faq/";
		//檔案前置名
		$ForderName = "faq_";
		// 上傳檔總數
		$total_uploads = 4;
		// 上傳檔大小限制，此處限制為600KB
		$size_bytes = 600 * 1024;
		// 副檔名限制
		$limitedext = array(".gif",".jpg",".jpeg",".png");
	
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
			$SQL = "Select * From faq Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$Faq_PKey = $DR1->field("PKey");
				$SQL_U = " Update faq set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " contents1 = '".SqlFilter($_POST['contents1'],"tab")."',";
				$SQL_U .= " contents2 = '".SqlFilter($_POST['contents2'],"tab")."',";
				$SQL_U .= " contents3 = '".SqlFilter($_POST['contents3'],"tab")."',";
				$SQL_U .= " contents4 = '".SqlFilter($_POST['contents4'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where PKey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}else{
				$SQL_U = "Insert Into faq Set ";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " contents1 = '".SqlFilter($_POST['contents1'],"tab")."',";
				$SQL_U .= " contents2 = '".SqlFilter($_POST['contents2'],"tab")."',";
				$SQL_U .= " contents3 = '".SqlFilter($_POST['contents3'],"tab")."',";
				$SQL_U .= " contents4 = '".SqlFilter($_POST['contents4'],"tab")."',";
				$SQL_U .= " Upload = '".SqlFilter($_POST['Upload'],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";	
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				//取出主鍵值
				$Faq_PKey = execute_sql($SQL_U);

				$show = "新增成功!";
			}
			
			/***寫入圖檔***/
			for ($i = 1; $i <= $total_uploads; $i++) {
				if (strLen($Photo[$i]) > 10){
					$SQL = "Select * From faq_img Where Faq_PKey=".SqlFilter($Faq_PKey,"int")." And Sort =".$i;
					$rs = new recordset($SQL);
					if (!$rs->eof){
						/***刪除原始圖檔***/
						DelFile($upload_dir.$rs->field("Photo1"));
						$SQL_U = " Update faq_img set ";
						$SQL_U .= " Faq_PKey = '".SqlFilter($Faq_PKey,"int")."',";
						$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
						$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',";
						$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',";
						$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
						$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
						$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
						$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
						$SQL_U .= " Where PKey =".$rs->field("PKey");
					}else{
						$SQL_U = " Insert into faq_img set ";
						$SQL_U .= " Faq_PKey = '".SqlFilter($Faq_PKey,"int")."',";
						$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
						$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',";
						$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',";
						$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
						$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
						$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
						$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
					}
					execute_sql($SQL_U);
				}
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
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
	}

	/***取得明細資料***/
	$SQL = "Select * From faq Where PKey=".SqlFilter($Update_PKey,"int");
	$rsUD = new recordset($SQL);
	if (! $rsUD->eof){
		$Faq_PKey = $rsUD->field("PKey");
		$Sort = $rsUD->field("Sort");
		$strName = $rsUD->field("strName");
		$contents1 = $rsUD->field("contents1");
		$contents2 = $rsUD->field("contents2");
		$contents3 = $rsUD->field("contents3");
		$contents4 = $rsUD->field("contents4");
		$Upload = $rsUD->field("Upload");
		$UserID = $rsUD->field("UserID");
		$dtUDate = $rsUD->field("dtUDate");
		
		/*取得項目圖片*/
		$Photo = array();
		$PhotoP = array();
		$PhotoW = array();
		$PhotoH = array();
		for ($i=1;$i<=4;$i++){
			$SQL = "Select * From faq_img Where Faq_PKey=".SqlFilter($Faq_PKey,"int")." And Sort=".$i;
			$rsImg = new recordset($SQL);
			if (! $rsImg->eof){
				array_push($Photo,$rsImg->field("Photo1"));
				array_push($PhotoP,$rsImg->field("PKey"));
				array_push($PhotoW,$rsImg->field("PhotoW1"));
				array_push($PhotoH,$rsImg->field("PhotoH1"));
			}else{			
				array_push($Photo,'');
				array_push($PhotoP,'');
				array_push($PhotoW,0);
				array_push($PhotoH,0);
			}
		}
	}
	
	/***刪除選取的圖檔***/
	if ( $_REQUEST["motion"] == "del" And is_numeric($_REQUEST["imgNo"]) ){
		
		/*取出圖檔路徑*/
		$SQL = "Select * From faq_img Where PKey=".SqlFilter($_REQUEST["imgNo"],"int");
		$DR1 = new recordset($SQL);
		
		if ( $DR1->field("PKey") != "" ){
			$PKey = authcode($DR1->field("faq_PKey"),'ENCODE');			
			/*刪除實體檔案*/
			DelFile("../../Upload/faq/".$DR1->field("Photo1"));
			/*刪除圖檔*/
			$SQL = " Update faq_img Set Photo1='',PhotoW1=0,PhotoH1=0 Where PKey = ".$DR1->field("PKey");
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
              <td class="column-th"><i class="fa fa-asterisk"></i> 項目標題</td>
              <td><input name="strName" type="text" class="m-input" id="strName" value="<?php echo $strName?>" size="60" /></td>
            </tr>
            
            <!--內容1-->
            <tr>
              <td class="column-th">項目內容(1)</td>
              <td><textarea name="contents1" id="contents1" class="ckeditor"><?php echo $contents1?></textarea></td>
            </tr>
            
            <!--內容2-->
            <tr>
              <td class="column-th">項目內容(2)</td>
              <td><textarea name="contents2" id="contents2" class="ckeditor"><?php echo $contents2?></textarea></td>
            </tr>
            
            <!--內容3-->
            <tr>
              <td class="column-th">項目內容(3)</td>
              <td><textarea name="contents3" id="contents3" class="ckeditor"><?php echo $contents3?></textarea></td>
            </tr>
            
            <!--內容4-->
            <tr>
              <td class="column-th">項目內容(4)</td>
              <td><textarea name="contents4" id="contents4" class="ckeditor"><?php echo $contents4?></textarea></td>
            </tr>
            
            <!--項目圖片-->
            <?php for ($i=1;$i<=4;$i++){?>
                <tr>
                  <td valign="top" class="column-th">項目圖片(<?php echo $i?>)</td>
                  <td class="line-d">
                    <input name="Photo<?php echo $i?>" type="file" class="m-input" id="Photo<?php echo $i?>" size="30" />&nbsp;---
                    <?php if(strLen($Photo[$i-1]) > 4){?>
                        [<a href="javascript:MM_openBrWindow('../../Upload/faq/<?php echo $Photo[$i-1] ?>','news','width=<?php echo $PhotoW[$i-1]?>'+',height=<?php echo $PhotoH[$i-1] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[$i-1]?>';};" class="red">刪</a>]
                    <?php
                        }else{ echo "[無圖]";}
                    ?>
                  </td>
                </tr>
            <?php }?>
            <tr>
              <td height="32" valign="top" class="column-th">圖片上傳說明</td>
              <td class="line-d"><?php echo $remark_pic;?>
                <div class="red"> &#187;圖片(1).(4)尺寸建議：(寬)690px X (高)300px<br />
                &#187;圖片(2).(3)尺寸建議：(寬)280px X (高)120px </div></td>
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
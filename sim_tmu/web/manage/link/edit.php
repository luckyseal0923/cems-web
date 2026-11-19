<?
	require_once("../_inc.php");
	$mainitem    = "m7";
	$subitem     = "m7";
	$subname     = $m7.$mgw1;
	$unitprocess = $m_home.$icon.$m7.$mgw1; //單元路徑列
	$ModuleNo    = 7;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		//取得明細
		$SQL = "Select * From link_item Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$link_PKey = $rsUD->field("PKey");
			$strName = $rsUD->field("strName");
			$Sort = $rsUD->field("Sort");
			$strUrl = $rsUD->field("strUrl");
			$Upload = $rsUD->field("Upload");
			$UserID = $rsUD->field("UserID");
			$dtUDate = $rsUD->field("dtUDate");
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('查無修改資料!');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
	}
	
	/***刪除選取的圖檔***/
	if ( $_REQUEST["motion"] == "del" And is_numeric($_REQUEST["imgNo"]) ){
		
		/*取出圖檔路徑*/
		$SQL = "Select * From news_img Where PKey=".SqlFilter($_REQUEST["imgNo"],"int");
		$DR1 = new recordset($SQL);
		
		if ( $DR1->field("PKey") != "" ){
			
			$PKey = authcode($DR1->field("news_PKey"),'ENCODE');
			
			/*刪除實體檔案*/
			DelFile("../../Upload/news/".$DR1->field("Photo1"));
			DelFile("../../Upload/news/s_".$DR1->field("Photo1"));
			
			/*刪除圖檔*/
			$SQL = " Delete From news_img Where PKey = ".$DR1->field("PKey");
			execute_sql($SQL);
		}
		echo "<script language=\"javascript\">" ;
		echo "alert('成功刪除!');" ;
		echo "location.href='".$_SERVER["PHP_SELF"]."?PKey=".$PKey."';" ;
		echo "</script>" ;
		exit() ;
	}
	
	/***判斷Sort value***/
	if ( $Sort == "" ){ $Sort = "0"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $pageTitle1.$pageTitle2 ?></title>
<? require_once("../_in_javascript.php") ?>
<script type="text/JavaScript" src="../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript">

	/***判斷表單欄位***/	
	function sbForm(){
		var theForm = document.chkForm;
		if(fieldCheck0(theForm)){
		  theForm.submit();
		}
	}

	function fieldCheck0(theForm) {
		
		//連結文字
		if (theForm.strName.value == "" ){
			alert("【連結文字】請勿空白!"); 
			theForm.strName.focus();
		return false;}
		
		//連結網址
		if (theForm.strUrl.value == "" ){
			alert("【連結網址】請勿空白!"); 
			theForm.strUrl.focus();
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
        <form action="addin.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
          <table width="100%" border="0" cellpadding="2" cellspacing="1" class="m-tables">
            <tr>
                <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 項目順序</td>
                <td class="line-d"><input name="Sort" type="text" class="m-input" id="Sort" size="3" value="<? echo AddZero($Sort)?>"/>
                    <span class="red">( 限輸入數字 , </span><span class="orange">可填0 ,可重覆</span><span class="red"> )</span></td>
            </tr>
            <tr>
                <td width="132" valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 連結文字</td>
                <td align="left" class="line-d"><input name="strName" type="text" class="m-input" id="strName" value="<?php echo $strName?>" size="80" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 連結網址</td>
              <td class="line-d"><input name="strUrl" type="text" class="m-input" id="strUrl" value="<?php echo $strUrl?>" size="80" /></td>
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
      <?php require("../_footer.php"); ?>
    </div>
  </div>
</div>
<?php require("../_in_code_bottom.php"); ?>
</body>
</html>
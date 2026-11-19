<?
	require_once("../_inc.php");
	$mainitem    = "m1";
	$subitem     = "m12";
	$subname     = $m1.$mgw1." » ".$m12.$mgw4;
	$unitprocess = $m_home.$icon.$m1.$mgw1.$icon.$m12.$mgw4; //單元路徑列
	$ModuleNo    = 1;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		//取得明細
		$SQL = "Select * From news Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$News_PKey = $rsUD->field("PKey");
			$Class1 = $rsUD->field("class1_PKey");
			$Class2 = $rsUD->field("class2_PKey");
			$OpenDate = $rsUD->field("OpenDate");
			$EndDate = $rsUD->field("EndDate");
			$NoEndDate = $rsUD->field("NoEndDate");
			$Sort = $rsUD->field("Sort");
			$strName = $rsUD->field("strName");
			$showIndex = $rsUD->field("showIndex");
			$contents1 = $rsUD->field("contents1");
			$youtubeID = $rsUD->field("youtubeID");
			$UserID = $rsUD->field("UserID");
			$dtUDate = $rsUD->field("dtUDate");
			
			//取得新聞圖片
			$Photo = array();
			$PhotoP = array();
			$PhotoW = array();
			$PhotoH = array();
			for ($i=1;$i<=2;$i++){
				$SQL = "Select * From news_img Where News_PKey=".$News_PKey." And Sort=".$i;
				$rs = new recordset($SQL);
				if (! $rs->eof){
					array_push($Photo,$rs->field("Photo1"));
					array_push($PhotoP,$rs->field("PKey"));
					array_push($PhotoW,$rs->field("PhotoW1"));
					array_push($PhotoH,$rs->field("PhotoH1"));
				}else{			
					array_push($Photo,'');
					array_push($PhotoP,'');
					array_push($PhotoW,0);
					array_push($PhotoH,0);
				}
			}
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

	function login(theForm){
		theForm.submit()
	}
	
	function fieldCheck0(theForm){
		
		/*判斷上下架日期*/
		if (theForm.OpenDate.value == "" && ! theForm.NoOpenDate[0].checked){
			alert("【刊登日期】請勿空白");
			theForm.OpenDate.value = "";
			theForm.OpenDate.focus();
			return false;
		}
	
		if (theForm.EndDate.value == "" && ! theForm.NoEndDate[0].checked){
			alert("【下架日期】請勿空白");
			theForm.EndDate.value = "";
			theForm.EndDate.focus();
			return false;
		}
	
		var OpenDate = new Date(theForm.OpenDate.value);
		var EndDate = new Date(theForm.EndDate.value);
		var eDT = new Date();
		
	  	if (OpenDate.dateDiff("d",EndDate) < 0){
			alert("【下架日期必需大於刊登日期】");
			theForm.EndDate.focus();
			return false;
		}

		/*判斷順序*/
		if (isNaN(parseInt(theForm.Sort.value))){
			alert("【順序】為空白或非數字型態!"); 
			theForm.Sort.value = "";
			theForm.Sort.focus();
			return false;
		}
		
		/*判斷類別*/
		if (theForm.Class1.value == ""){
			alert("【主要類別】請選擇!");
			theForm.Class1.focus();
			return false;
		}
		
		if (theForm.Class2.value == ""){
			alert("【類別】請選擇!");
			theForm.Class2.focus();
			return false;
		}
		
		/*判斷標題*/
		if (theForm.strName.value == ""){
			alert("【標題】請勿空白!");
			theForm.strName.focus();
			return false;
		}
		
		//----------看圖片類型是否合法
		var temparr;
		<?php for($i=1;$i<=2;$i++){?>
		if(theForm.Photo<?php echo $i?>.value.length > 0)
		{
			temparr= theForm.Photo<?php echo $i?>.value.split(".");
			if("<?php echo $ImageTypeLimit ?>".toUpperCase().indexOf(temparr[temparr.length-1].toUpperCase())<0)
			{
				self.alert("圖檔上傳限制 <?php echo $ImageTypeLimit ?>");
				theForm.Photo<?php echo $i?>.focus();
				return false;
			}
		}
		<?php }?>
		
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
              <td width="132" class="column-th"><i class="fa fa-asterisk"></i>刊登日期</td>
              <td width="1474" align="left" class="line-d"><input name="NoOpenDate" type="radio" value="0" <?php if(strLen($OpenDate) == 0) {echo "checked=\"checked\"";}?> />
                馬上刊登
                <input name="NoOpenDate" type="radio" value="1" <?php if(strLen($OpenDate) > 0) {echo "checked=\"checked\"";}?> />
                <input name="OpenDate" type="text" class="m-input" id="OpenDate" size="10" value="<?php echo $OpenDate; ?>" onchange="document.all.NoOpenDate[1].checked=true;" />
                <img src="../images/img.gif" alt="<?php echo $pageTitle."-";?>上架日期" width="20" height="14" align="absmiddle" id="BTN1" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
				<script type="text/javascript">
                    Calendar.setup({
                    inputField     :    "OpenDate",  //input元件主題
                    ifFormat       :    "%Y/%m/%d",//輸出日期格式
                    showsTime      :    false, //日曆是否要在底訲顯示時間
                    button         :    "BTN1", //啟動日曆的按鈕id
                    singleClick    :    true, //是否需要雙擊按鈕才能啟動
                    steo           :    1 //上一年及次一年,年份間格,預設2
                    });
                </script>
              </td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i>下架日期</td>
              <td align="left" class="line-d"><input name="NoEndDate" type="radio" value="0" <?php if($NoEndDate != 1) {echo "checked=\"checked\"";}?> />
                永不下架
                <input type="radio" value="1" name="NoEndDate" <?php if($NoEndDate == 1) {echo "checked=\"checked\"";}?> />
                <input name="EndDate" type="text" class="m-input" id="EndDate" size="10" value="<?php echo $EndDate; ?>" onchange="document.all.NoEndDate[1].checked=true;"/>
                <img src="../images/img.gif" alt="<?php echo $pageTitle."-";?>上架日期" width="20" height="14" align="absmiddle" id="BTN2" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
				<script type="text/javascript">
					Calendar.setup({
					inputField     :    "EndDate",  //input元件主題
					ifFormat       :    "%Y/%m/%d",//輸出日期格式
					showsTime      :    false, //日曆是否要在底訲顯示時間
					button         :    "BTN2", //啟動日曆的按鈕id
					singleClick    :    true, //是否需要雙擊按鈕才能啟動
					steo           :    1 //上一年及次一年,年份間格,預設2
					});
                </script>
			  </td>
            </tr>
            <tr>
              <td width="132" valign="top" class="column-th"><i class="fa fa-asterisk"></i> 順序</td>
              <td class="line-d"><input name="Sort" type="text" class="m-input" id="Sort" size="5" value="<? echo AddZero($Sort)?>"/>&nbsp;限輸入數字</td>
            </tr>
            <tr>
              <td valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 主要類別</td>
              <td align="left" class="line-d">
              <select name="Class1" id="Class1" class="m-select">
              	<option value="">請選擇</option>
				<?php
                	/***取得主要類別資料***/
                    $SQL = "Select PKey, strName From news_class1 Where Upload='Yes'";
                    $rsc1 = new recordset($SQL);
                    while (! $rsc1->eof){?>
                    	<option value="<? echo $rsc1->field("PKey")?>" <?php if ( strval($Class1) == strval($rsc1->field("PKey")) ){ echo "selected";}?>><? echo $rsc1->field("strName")?></option>
                <?php
                		$rsc1->movenext();
					}
				?>
              </select>
              </td>
            </tr>
            <tr>
              <td valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 類別</td>
              <td align="left" class="line-d">
              <select name="Class2" id="Class2" class="m-select">
              	<option value="">請選擇</option>
                <?php
					/***取得類別資料***/
					$SQL = " Select PKey, strName From news_class2 Where class1_PKey=".SqlFilter($Class1,"int")." Order By Sort";
					$rsc1 = new recordset($SQL);
					while(!$rsc1->eof){?>
                    	<option value="<?php echo $rsc1->field("PKey")?>"  <?php if ( strval($Class2) == strval($rsc1->field("PKey")) ) echo "selected";?>><?php echo $rsc1->field("strName")?></option>
                <?php
						$rsc1->movenext();
					}
				?>
			  </select>
              </td>
            </tr>
            <tr>
              <td width="132" valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 標題</td>
              <td align="left" class="line-d"><input name="strName" type="text" class="m-input" id="strName" value="<? echo $strName?>" size="80" maxlength="80" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">首頁顯示</td>
              <td class="line-d"><input name="showIndex" type="checkbox" value="1" <?php if ($showIndex==1){echo "checked";}?>/>
                是，首頁顯示 </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內容 1</td>
              <td class="line-d"><p>
                  <textarea name="contents1" id="contents1" class="ckeditor"><?php echo $contents1?></textarea>
                </p></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖 1</td>
              <td class="line-d">
                  <input name="Photo1" type="file" class="m-input" id="Photo1" size="30" />
                    ---
                    <?php if(strLen($Photo[0]) > 4){?>
                        [<a href="javascript:MM_openBrWindow('../../Upload/news/<?php echo $Photo[0] ?>','news','width=<?php echo $PhotoW[0]?>'+',height=<?php echo $PhotoH[0] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[0]?>';};" class="red">刪</a>]
                <?php
                        }else{ echo "[無圖]";}
                    ?></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖 2</td>
              <td class="line-d">
                  <input name="Photo2" type="file" class="m-input" id="Photo2" size="30" />
                    ---
                    <?php if(strLen($Photo[1]) > 4){?>
                        [<a href="javascript:MM_openBrWindow('../../Upload/news/<?php echo $Photo[1] ?>','news','width=<?php echo $PhotoW[1]?>'+',height=<?php echo $PhotoH[1] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[1]?>';};" class="red">刪</a>]
                <?php
                        }else{ echo "[無圖]";}
                    ?></td>
            </tr>
            <tr>
              <td height="32" valign="top" class="column-th">圖片上傳說明</td>
              <td class="line-d"><?php echo $remark_pic.$remark_save;?>
              <div class="red"> &#187;圖片尺寸建議：(寬)690px X (高)300px</div>
              </td>
            </tr>
            <tr>
              <td class="column-th">影音連結</td>
              <td bordercolor="#111111"><p> https://www.youtube.com/watch?v=
                <input name="youtubeID" type="text" id="youtubeID" class="m-input" size="20" maxlength="20" value="<? echo $youtubeID?>"/>
              </p>
                <p> (Youtube連結例：https://www.youtube.com/watch?v=<span class="red">rRBlFrN_h8o</span>) </p></td>
            </tr>
            <tr>
              <td height="32" valign="top" class="column-th">前端版型示意圖</td>
              <td class="line-d"><img src="../images/m1_demo.jpg" width="150" height="184" /></td>
            </tr>
            <tr>
              <td class="column-th">更新日期</td>
              <td align="left" class="line-d"><?php require_once("../_modify.php"); ?></td>
            </tr>
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
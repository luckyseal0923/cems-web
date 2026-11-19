<?
	require_once("../_inc.php");
	$mainitem    = "m2";
	$subitem     = "m22";
	$subname     = $m2.$mgw1." » ".$m22.$mgw4;
	$unitprocess = $m_home.$icon.$m2.$mgw1.$icon.$m22.$mgw4; //單元路徑列
	$ModuleNo    = 2;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		/*取得明細*/
		$SQL = "Select * From course Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$course_PKey = $rsUD->field("PKey");
			$Class1 = $rsUD->field("class1_PKey");			/*主要類別*/
			$Class2 = $rsUD->field("class2_PKey");			/*次要類別*/
			$OpenDate = Date_EN($rsUD->field("OpenDate"),1);/*課程開始日期*/
			$EndDate = Date_EN($rsUD->field("EndDate"),1);	/*課程結束日期*/
			$CourseTime = $rsUD->field("dtCourse_time");	/*課程時間*/
			$Sort = $rsUD->field("Sort");					/*課程排序*/
			$strName = $rsUD->field("strName");				/*課程名稱*/
			$strTeacher = $rsUD->field("strTeacher");		/*講師姓名*/
			$intro = $rsUD->field("intro");					/*課程簡介*/
			$PayExp = $rsUD->field("PayExp");				/*報名截止日期*/
			$strPrice = $rsUD->field("Price");				/*報名費用*/
			$showIndex = $rsUD->field("showIndex");			/*首頁顯示*/
			$contents1 = $rsUD->field("contents1");			/*課程內容*/
			$contents2 = $rsUD->field("contents2");			/*課程內容*/
			$contents3 = $rsUD->field("contents3");			/*課程內容*/
			$contents4 = $rsUD->field("contents4");			/*課程內容*/
			$contents5 = $rsUD->field("contents5");			/*課程內容*/
			$strPeople = $rsUD->field("PeopleNumber1");		/*可報名人數*/
			$youtubeID = $rsUD->field("youtubeID");			/*youtubdID*/
			$intLink = $rsUD->field("intLink");				/*檔案上傳類別	*/
			$strLink = $rsUD->field("strLink");				/*檔案上傳路徑*/
			$FileName = $rsUD->field("FileName");			/*檔案名稱*/
			$UserID = $rsUD->field("UserID");				/*修改人員*/
			$dtUDate = $rsUD->field("dtUDate");				/*修改日期*/	
			
			/*取得課程圖片*/
			$Photo = array();
			$PhotoP = array();
			$PhotoW = array();
			$PhotoH = array();
			for ($i=1;$i<=8;$i++){
				$SQL = "Select * From course_img Where course_PKey=".SqlFilter($course_PKey,"int")." And Sort=".$i;
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
		$SQL = "Select * From course_img Where PKey=".SqlFilter($_REQUEST["imgNo"],"int");
		$DR1 = new recordset($SQL);
		
		if ( $DR1->field("PKey") != "" ){
			
			$PKey = authcode($DR1->field("course_PKey"),'ENCODE');
			
			/*刪除實體檔案*/
			DelFile("../../Upload/course/".$DR1->field("Photo1"));
			DelFile("../../Upload/course/s_".$DR1->field("Photo1"));
			
			/*刪除圖檔*/
			$SQL = "Delete From course_img Where PKey = ".$DR1->field("PKey");
			execute_sql($SQL);
		}
		echo "<script language=\"javascript\">" ;
		echo "alert('成功刪除!');" ;
		echo "location.href='".$_SERVER["PHP_SELF"]."?PKey=".$PKey."';" ;
		echo "</script>" ;
		exit() ;
	}
	
	/***刪除選取的文檔***/
	if ( $_REQUEST["motion"] == "fdel" And is_numeric($_REQUEST["fileNo"]) ){
		
		/*取出文檔路徑*/
		$SQL = "Select * From course Where PKey=".SqlFilter($_REQUEST["fileNo"],"int");
		$DR1 = new recordset($SQL);
		
		if ( $DR1->field("PKey") != "" ){
			
			$PKey = authcode($DR1->field("PKey"),'ENCODE');
			
			/*刪除實體檔案*/
			DelFile("../../Upload/files/".$DR1->field("FileName"));
			
			/*更新資料庫欄位*/
			$SQL = "Update course Set intLink=0,FileName='',FileSize=0 Where PKey = ".$DR1->field("PKey");
			execute_sql($SQL);
		}
		echo "<script language=\"javascript\">" ;
		echo "alert('成功刪除!');" ;
		echo "location.href='".$_SERVER["PHP_SELF"]."?PKey=".$PKey."';" ;
		echo "</script>" ;
		exit() ;
	}
	
	/***判斷 Sort/People value***/
	if ( $Sort == "" ){ $Sort = "0"; }
	if ( $strPeople == "" ){ $strPeople = "0"; }
	if ( $strPrice =="" ){ $strPrice = "0"; }
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
		
		/*判斷順序*/
		if (isNaN(parseInt(theForm.Sort.value))){
			alert("【順序】為空白或非數字型態!"); 
			theForm.Sort.value = "";
			theForm.Sort.focus();
			return false;
		}
		
		/*判斷課程主要類別*/
		if (theForm.Course_Class1.value == ""){
			alert("【課程主要類別】請選擇!");
			theForm.Course_Class1.focus();
			return false;
		}

		/*判斷課程類別*/
		if (theForm.Course_Class2.value == ""){
			alert("【課程類別】請選擇!");
			theForm.Course_Class2.focus();
			return false;
		}
		
		/*判斷課程名稱*/
		if (theForm.strName.value == ""){
			alert("【課程名稱】請勿空白!");
			theForm.strName.focus();
			return false;
		}
		
		/*判斷講師姓名*/
		if (theForm.strTeacher.value == ""){
			alert("【講師姓名】請勿空白!");
			theForm.strTeacher.focus();
			return false;
		}
		
		/*若為中心課程時的判斷程式*/
		if (theForm.Course_Class1.value == "2"){
			/*判斷報名截止日期*/
			if ( theForm.PayExp.value == "" ){
				alert("【報名截止日期】請勿空白!");
				theForm.PayExp.focus();
				return false;
			}
			/*判斷報名費用*/
			if ( theForm.strPrice.value == 0 ){
				alert("【報名費用】請勿為0!");
				theForm.strPrice.focus();
				return false;
			}
			/*判斷報名費用*/
			if ( theForm.strPeople.value == 0 ){
				alert("【可報名人數】請勿為0!");
				theForm.strPeople.focus();
				return false;
			}
			/*判斷報名截止日期是否大於課程開始日期*/
			var ExpDate = new Date(theForm.PayExp.value);
			if (ExpDate.dateDiff("d",OpenDate) < 0){
				alert("【報名截止日期必需小於課程開始日期】");
				theForm.PayExp.focus();
				return false;
			}
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
              <td width="132" class="column-th">課程開始日期</td>
              <td width="1474" align="left" class="line-d"><input name="OpenDate" type="text" class="m-input" id="OpenDate" size="10" value="<?php echo $OpenDate; ?>">
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
              <td class="column-th">課程結束日期</td>
              <td align="left" class="line-d"><input name="EndDate" type="text" class="m-input" id="EndDate" size="10" value="<?php echo $EndDate; ?>">
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
              <td valign="top" class="column-th">課程時間</td>
              <td class="line-d">
              <select name="dtCourse_time" id="dtCourse_time" class="m-select">
                <option value="">請選擇</option>
                <option value="08:00 ~ 12:00 AM"<?php if ( $CourseTime == "08:00 ~ 12:00 AM" ){ echo " selected";}?>>08:00 ~ 12:00 AM</option>
                <option value="13:00 ~ 15:00 PM"<?php if ( $CourseTime == "13:00 ~ 15:00 PM" ){ echo " selected";}?>>13:00 ~ 15:00 PM</option>
                <option value="18:00 ~ 22:00 PM"<?php if ( $CourseTime == "18:00 ~ 22:00 PM" ){ echo " selected";}?>>18:00 ~ 22:00 PM</option>
              </select>
              </td>
            </tr>
            <tr>
              <td width="132" valign="top" class="column-th"><i class="fa fa-asterisk"></i> 順序</td>
              <td class="line-d"><input name="Sort" type="text" class="m-input" id="Sort" size="5" value="<? echo AddZero($Sort)?>"/>&nbsp;限輸入數字</td>
            </tr>
            <tr>
              <td valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 主要課程類別</td>
              <td align="left" class="line-d">
              <select name="Course_Class1" id="Course_Class1" class="m-select">
              	<option value="">請選擇</option>
				<?php
                	/***取得主要類別資料***/
                    $SQL = "Select PKey, strName From course_class1 Where Upload='Yes'";
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
              <td valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 課程類別</td>
              <td align="left" class="line-d">
              <select name="Course_Class2" id="Course_Class2" class="m-select">
              	<option value="">請選擇</option>
                <?php
					/***取得類別資料***/
					$SQL = " Select PKey, strName From course_class2 Where class1_PKey=".SqlFilter($Class1,"int")." Order By Sort";
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
              <td width="132" valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 課程名稱</td>
              <td align="left" class="line-d"><input name="strName" type="text" class="m-input" id="strName" value="<? echo $strName?>" size="80" maxlength="80" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 講師姓名</td>
              <td class="line-d"><input name="strTeacher" type="text" class="m-input" id="strTeacher" value="<? echo $strTeacher?>" size="20" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">報名人數</td>
              <td class="line-d"><input name="strPeople" type="text" class="m-input" id="strPeople" value="<? echo $strPeople?>" size="5" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">報名截止日期</td>
              <td class="line-d"><input name="PayExp" type="text" class="m-input" id="PayExp" size="10" value="<?php echo $PayExp ?>" />
                <img src="../images/img.gif" alt="<?php echo $pageTitle."-";?>報名截止日期" width="20" height="14" align="absmiddle" id="BTN3" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
                <script type="text/javascript">
					Calendar.setup({
					inputField     :    "PayExp",  //input元件主題
					ifFormat       :    "%Y/%m/%d",//輸出日期格式
					showsTime      :    false, //日曆是否要在底訲顯示時間
					button         :    "BTN3", //啟動日曆的按鈕id
					singleClick    :    true, //是否需要雙擊按鈕才能啟動
					steo           :    1 //上一年及次一年,年份間格,預設2
					});
                </script></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">課程費用</td>
              <td class="line-d"><input name="strPrice" type="text" class="m-input" id="strPrice" value="<? echo $strPrice?>" size="10" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">課程概述</td>
              <td class="line-d"><textarea name="intro" cols="80" rows="6" class="m-input" id="intro"><? echo $intro?></textarea>
              <span class="red">              (字數限制110字)</span></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">首頁顯示</td>
              <td class="line-d"><input name="showIndex" type="checkbox" value="1" <?php if ($showIndex==1){echo "checked";}?>/>
                是，首頁顯示 </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內文概述</td>
              <td class="line-d"><p>
                  <textarea name="contents1" id="contents1" class="ckeditor"><?php echo $contents1?></textarea>
                </p></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內容1 (上圖下文)</td>
              <td class="line-d"><textarea name="contents2" id="contents2" class="ckeditor"><?php echo $contents2?></textarea></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內容2 (左圖右文)</td>
              <td class="line-d"><textarea name="contents3" id="contents3" class="ckeditor"><?php echo $contents3?></textarea></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內容3 (右圖左文)</td>
              <td class="line-d"><textarea name="contents4" id="contents4" class="ckeditor"><?php echo $contents4?></textarea></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">內容4 (下圖上文)</td>
              <td class="line-d"><textarea name="contents5" id="contents5" class="ckeditor"><?php echo $contents5?></textarea></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖片 (上圖下文)</td>
              <td class="line-d"><input name="Photo5" type="file" class="m-input" id="Photo5" size="30" />---
				<?php if(strLen($Photo[4]) > 4){?>
                	[<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[4] ?>','news','width=<?php echo $PhotoW[4]?>'+',height=<?php echo $PhotoH[4] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[4]?>';};" class="red">刪</a>]
                <?php }else{ echo "[無圖]";}?>
              </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖片 (左圖右文)</td>
              <td class="line-d"><input name="Photo6" type="file" class="m-input" id="Photo6" size="30" />---
				<?php if(strLen($Photo[5]) > 4){?>
                	[<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[5] ?>','news','width=<?php echo $PhotoW[4]?>'+',height=<?php echo $PhotoH[5] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[5]?>';};" class="red">刪</a>]
                <?php }else{ echo "[無圖]";}?>
              </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖片 (右圖左文)</td>
              <td class="line-d"><input name="Photo7" type="file" class="m-input" id="Photo7" size="30" />---
				<?php if(strLen($Photo[6]) > 4){?>
                	[<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[6] ?>','news','width=<?php echo $PhotoW[6]?>'+',height=<?php echo $PhotoH[6] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[6]?>';};" class="red">刪</a>]
                <?php }else{ echo "[無圖]";}?>
              </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖片 (下圖上文)</td>
              <td class="line-d"><input name="Photo8" type="file" class="m-input" id="Photo8" size="30" />---
				<?php if(strLen($Photo[7]) > 4){?>
                	[<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[7] ?>','news','width=<?php echo $PhotoW[6]?>'+',height=<?php echo $PhotoH[7] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[7]?>';};" class="red">刪</a>]
                <?php }else{ echo "[無圖]";}?>
              </td>
            </tr>
            <tr>
              <td valign="top" class="column-th">圖 1</td>
              <td class="line-d">
                  <input name="Photo1" type="file" class="m-input" id="Photo1" size="30" />
                    ---
                    <?php if(strLen($Photo[0]) > 4){?>
                        [<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[0] ?>','news','width=<?php echo $PhotoW[0]?>'+',height=<?php echo $PhotoH[0] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[0]?>';};" class="red">刪</a>]
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
                        [<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[1] ?>','news','width=<?php echo $PhotoW[1]?>'+',height=<?php echo $PhotoH[1] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[1]?>';};" class="red">刪</a>]
                <?php
                        }else{ echo "[無圖]";}
                    ?></td>
            </tr>
            <tr>
              <td valign="top" class="column-th">首頁代表圖</td>
              <td class="line-d"><input name="Photo4" type="file" class="m-input" id="Photo4" size="30" />
                ---
                  <?php if(strLen($Photo[3]) > 4){?>
                [<a href="javascript:MM_openBrWindow('../../Upload/course/<?php echo $Photo[3] ?>','news','width=<?php echo $PhotoW[3]?>'+',height=<?php echo $PhotoH[3] ?>'+',top='+(screen.availHeight/2-250/2)+',left='+(screen.availWidth/2-108/2));" class="red">預覽</a>]&nbsp;[<a href="javascript:if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=del&amp;imgNo=<?php echo $PhotoP[3]?>';};" class="red">刪</a>]
                <?php
                        }else{ echo "[無圖]";}
                    ?></td>
            </tr>
            <tr>
              <td height="32" valign="top" class="column-th">圖片上傳說明</td>
              <td class="line-d"><?php echo $remark_pic.$remark_save;?>
              <div class="red"> &#187;圖片(上圖下文、下圖上文、圖1、圖2)尺寸建議：(寬)690px X (高)不限<br />
                &#187;圖片(左圖右文、右圖左文)尺寸建議：(寬)280px X (高)121px</div>
              </td>
            </tr>
            <tr>
              <td  class="column-th">檔案上傳</td>
              <td><input name="intLink" type="radio" value="1" <? if ($intLink ==1){ echo "checked=\"checked\"";}?> />
                連結路徑
                <input name="strLink" type="text" class="m-select" id="strLink" value="<?php echo $strLink?>" size="40" onclick="javascript:document.all.intLink[0].checked=true;"/>
                <br />
                <input name="intLink" type="radio" value="2" <? if ($intLink ==2){ echo "checked=\"checked\"";}?> />
                上傳檔案
                <input name="Photo3" type="file" class="m-input" id="Photo3" size="30" onclick="javascript:document.all.intLink[1].checked=true;"/>
                ---
                <?php if(strLen($FileName) > 4){?>
                [<a href="../../Upload/files/<?php echo $FileName ?>" target="_blank" class="red">預覽</a>][<a href="#" class="red" onclick="if(confirm('確定刪除嗎？')){location.href='<?php echo $_SERVER['PHP_SELF']?>?motion=fdel&amp;fileNo=<?php echo $course_PKey?>';}else{return false;}">刪</a>]
                <?php
				 }
				 else{ echo "[無檔案]";}
				?></td>
            </tr>
            <tr>
              <td class="column-th">影音連結</td>
              <td bordercolor="#111111"><p> https://www.youtube.com/watch?v=
                <input name="youtubeID" type="text" id="youtubeID" class="m-input" size="20" maxlength="20" value="<? echo $youtubeID?>"/>
              </p>
                <p> (Youtube連結例：https://www.youtube.com/watch?v=<span class="red">rRBlFrN_h8o</span>) </p></td>
            </tr>
            <tr>
              <td class="column-th">上下架</td>
              <td><select name="Upload" class="m-select" id="Upload">
                <option value="Yes" <?php if($Upload == 'Yes') {echo "selected=\"selecteded\"";}?>>上架</option>
                <option value="No" <?php if($Upload == 'No') {echo "selected=\"selecteded\"";}?>>下架</option>
              </select></td>
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
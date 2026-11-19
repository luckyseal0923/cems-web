<?
	require_once("../_inc.php");
	$mainitem    = "m4";
	$subitem     = "m4";
	$subname     = $m4.$mgw1;
	$unitprocess = $m_home.$icon.$m4.$mgw1; //單元路徑列
	$ModuleNo    = 4;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		//取得明細
		$SQL = "Select * From rental_p Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$Rental_PKey = $rsUD->field("PKey");
			$classroom_PKey = $rsUD->field("classroom_PKey");
			$Rental_Year = $rsUD->field("Rental_Year");
			$Rental_Month = $rsUD->field("Rental_Month");
			$Rental_Day = $rsUD->field("Rental_Day");
			$Rental_Time = $rsUD->field("Rental_Time");
			$Rental_unit = $rsUD->field("Rental_unit");
			$Rental_name = $rsUD->field("Rental_name");
			$Rental_email = $rsUD->field("Rental_email");
			$Rental_tel = $rsUD->field("Rental_tel");
			$Rental_message = $rsUD->field("Rental_message");
			$Rental_status = $rsUD->field("Rental_status");
			$Charge = $rsUD->field("charge");
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
		
		/*判斷租借教室*/	
		if (theForm.classroom.value == "" ){
			alert("【租借教室】請選擇!"); 
			theForm.classroom.focus();
		return false;}
		
		/*租借日期-年*/
		if (theForm.Year.value == "" ){
			alert("【租借日期-年】請選擇!"); 
			theForm.Year.focus();
		return false;}
		
		/*租借日期-月*/
		if (theForm.Month.value == "" ){
			alert("【租借日期-月】請選擇!"); 
			theForm.Month.focus();
		return false;}

		/*租借日期-日*/
		if (theForm.Day.value == "" ){
			alert("【租借日期-日】請選擇!"); 
			theForm.Day.focus();
		return false;}

		/*租借日期-時間*/
		if (theForm.Time.value == "" ){
			alert("【租借時間】請選擇!"); 
			theForm.Time.focus();
		return false;}
		
		/*單位*/
		if (theForm.runit.value == ""){
			alert("【單位】請勿空白!"); 
			theForm.runit.focus();
		return false;}	
		
		/*聯絡人*/
		if (theForm.name.value == ""){
			alert("【聯絡人】請勿空白!"); 
			theForm.name.focus();
		return false;}	

		/*電子郵件*/
		var reg = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+$/i;
		if (!reg.test(theForm.EMail.value)){
			alert("【電子信箱】空白或格式錯誤"); 
			theForm.EMail.focus();
		return false;}
		
		/*電話*/
		if (theForm.tel.value == ""){
			alert("【聯絡電話】請勿空白!"); 
			theForm.tel.focus();
		return false;}	
		
		/*費用*/
		if (theForm.charge.value == ""){
			alert("【租借費用】請勿空白!"); 
			theForm.tel.focus();
		return false;}	
		
		/*說明*/
		if (theForm.message.value == ""){
			alert("【說明】請勿空白!"); 
			theForm.message.focus();
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
              <td width="132" class="column-th"><i class="fa fa-asterisk"></i> 租借教室</td>
              <td width="1474" align="left" class="line-d"><select name="classroom" id="classroom" class="m-select">
                <option value="">請選擇</option>
                <?php for ($i=1;$i<=15;$i++){?>
                <option value="<? echo $i?>" <?php if ( $classroom_PKey == $i ){ echo "selected";}?>><? echo Classroom_Type($i)?></option>
                <?php }?>
              </select></td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 租借日期</td>
              <td align="left" class="line-d"><select name="Year" id="Year" class="m-select">
                <option value="">請選擇</option>
                <?php for ($i=date("Y");$i<=date("Y")+1;$i++){?>
                <option value="<? echo $i?>"<?php if ( $Rental_Year == $i ){ echo " selected";}?>><? echo $i?></option>
                <?php }?>
              </select>
                年
                <select name="Month" id="Month" class="m-select">
                  <option value="">請選擇</option>
                  <?php for ($i=1;$i<=12;$i++){?>
                  <option value="<? echo $i?>"<?php if ( $Rental_Month == $i ){ echo " selected";}?>><? echo $i?></option>
                  <?php }?>
                </select>
                月
                <select name="Day" id="Day" class="m-select">
                  <option value="">請選擇</option>
                  <?php for ($i=1;$i<=31;$i++){?>
                  <option value="<? echo $i?>"<?php if ( $Rental_Day == $i ){ echo " selected";}?>><? echo $i?></option>
                  <?php }?>
                </select>
                日 </td>
            </tr>
            <tr>
              <td width="132" valign="top" class="column-th"><i class="fa fa-asterisk"></i> 租借時間</td>
              <td class="line-d"><select name="Time" id="Time" class="m-select">
                <option value="">請選擇</option>
                <option value="1"<?php if ( $Rental_Time == 1 ){ echo " selected";}?>>08:00~10:00 AM</option>
                <option value="2"<?php if ( $Rental_Time == 2 ){ echo " selected";}?>>10:00~12:00 AM</option>
                <option value="3"<?php if ( $Rental_Time == 3 ){ echo " selected";}?>>12:00~14:00 PM</option>
                <option value="4"<?php if ( $Rental_Time == 4 ){ echo " selected";}?>>14:00~16:00 PM</option>
                <option value="5"<?php if ( $Rental_Time == 5 ){ echo " selected";}?>>16:00~18:00 PM</option>
                <option value="6"<?php if ( $Rental_Time == 6 ){ echo " selected";}?>>18:00~20:00 PM</option>
              </select></td>
            </tr>
            <tr>
              <td width="132" valign="middle" class="column-th"><i class="fa fa-asterisk"></i> 租借單位</td>
              <td align="left" class="line-d"><input name="runit" type="text" class="m-input" id="runit" value="<? echo $Rental_unit?>" size="50" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 聯絡人</td>
              <td class="line-d"><input name="name" type="text" class="m-input" id="name" value="<? echo $Rental_name?>" size="15" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 電子郵件</td>
              <td class="line-d"><p>
                <input name="EMail" type="text" class="m-input" id="EMail" value="<? echo $Rental_email?>" size="80" />
              </p></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 電話</td>
              <td class="line-d"><input name="tel" type="text" class="m-input" id="tel" value="<? echo $Rental_tel?>" size="20" /></td>
            </tr>
            <tr>
              <td valign="top" class="column-th"><i class="fa fa-asterisk"></i> 說明</td>
              <td class="line-d"><textarea name="message" cols="80" rows="5" class="m-input" id="message"><? echo $Rental_message?></textarea></td>
            </tr>
            <tr>
              <td class="column-th"><i class="fa fa-asterisk"></i> 租借費用</td>
              <td align="left" class="line-d"><input name="charge" type="text" class="m-input" id="charge" value="<? echo $Charge?>" size="15" /></td>
            </tr>
            <tr>
              <td class="column-th">租借狀態</td>
              <td align="left" class="line-d">
              <select name="Rental_Status" id="Rental_Status" class="m-select">
                <option value="">請選擇</option>
                <option value="Yes"<?php if ( $Rental_status == "Yes" ){ echo "selected";}?>>可租借</option>
                <option value="No"<?php if ( $Rental_status == "No" ){ echo "selected";}?>>不可租借</option>
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
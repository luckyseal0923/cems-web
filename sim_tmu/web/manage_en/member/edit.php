<?
	require_once("../_inc.php");
	$mainitem    = "m3";
	$subitem     = "m3";
	$subname     = $m3.$mgw2;
	$unitprocess = $m_home.$icon.$m3.$mgw2; //單元路徑列
	$ModuleNo    = 3;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		//取得明細
		$SQL = "Select * From member Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$Member_PKey = $rsUD->field("PKey");
			$strID = $rsUD->field("strID");
			$strPW = $rsUD->field("strPW");
			$strNickName = $rsUD->field("strNickName");
			$strName = $rsUD->field("strName");
			$strEName = $rsUD->field("strEName");
			$strNo = $rsUD->field("strNo");
			$strTel = $rsUD->field("strTel");
			$strAddress = $rsUD->field("strAddress");
			$strEAddress = $rsUD->field("strEAddress");
			$Email = $rsUD->field("Email");
			$strType = $rsUD->field("strType");
			$dtUDate = $rsUD->field("dtUDate");
			$UserID = $rsUD->field("UserID");
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('查無修改資料!');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
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
		
		/*判斷帳號*/
		if (theForm.strID.value == ""){
			alert("【帳號】請勿空白!");
			theForm.strID.focus();
			return false;
		}

		/*判斷密碼*/
		var reg = /^[a-z0-9]{6,20}$/ig;
		if (! reg.test(theForm.strPW.value)){
			alert("【密碼】英文或數字6~20碼");
			theForm.strPW.focus();
			return false;
		}
		
		/*判斷確認密碼*/
		if (theForm.strPW2.value != theForm.strPW.value){
			alert("【確認密碼不同】");
			theForm.strPW2.focus();
			return false;
		}

		/*判斷會員暱稱*/
		if (theForm.strNickName.value == ""){
			alert("【暱稱】請勿空白!");
			theForm.strNickName.focus();
			return false;
		}
		
		/*判斷會員姓名*/
		if (theForm.strName.value == ""){
			alert("【姓名】請勿空白!");
			theForm.strName.focus();
			return false;
		}

		/*判斷會員聯絡電話*/
		if (theForm.strTel.value == ""){
			alert("【聯絡電話】請勿空白!");
			theForm.strTel.focus();
			return false;
		}

		/*判斷會員聯絡地址*/
		if (theForm.strAddress.value == ""){
			alert("【聯絡地址(中)】請勿空白!");
			theForm.strAddress.focus();
			return false;
		}
		
		/*判斷電子郵件*/
		var reg = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+$/i;
		if (!reg.test(theForm.EMail.value)){
			alert("【電子信箱】空白或格式錯誤!"); 
			theForm.EMail.focus();
			return false;
		}
		  
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
          <table width="100%" cellspacing="0" cellpadding="0" class="m-tables">
            <tr >
              <td width="180" class="column-th">會員帳號 <i class="fa fa-asterisk"></i></td>
              <td><input name="strID" type="text" id="strID" size="20" value="<?php echo $strID?>" class="m-input" />
                <span class="red">(請注意：新增成功後,系統將會自動寄送通知信給該會員)</span></td>
            </tr>
            <tr>
              <td width="180" class="column-th">會員密碼 <i class="fa fa-asterisk"></i></td>
              <td width="1399"><input name="strPW" type="password" class="m-input" id="strPW" value="<?php echo $strPW?>" size="15" maxlength="12" />
              <span class="red">(限輸入英文或數字6~12碼)</span></td>
            </tr>
            <tr>
              <td class="column-th">確認會員密碼 <i class="fa fa-asterisk"></i></td>
              <td><input name="strPW2" type="password" class="m-input" id="strPW2" value="<?php echo $strPW?>" size="15" maxlength="12" /></td>
            </tr>
            <tr>
              <td width="180" class="column-th">會員暱稱 <i class="fa fa-asterisk"></i></td>
              <td><input name="strNickName" type="text" class="m-input" id="strNickName" value="<?php echo $strNickName?>" size="15" /></td>
            </tr>
            <tr>
              <td class="column-th">會員姓名 <i class="fa fa-asterisk"></i></td>
              <td><input name="strName" type="text" class="m-input" id="strName" value="<?php echo $strName?>" size="15" /></td>
            </tr>
            <tr>
              <td class="column-th">會員英文名</td>
              <td><input name="strEName" type="text" class="m-input" id="strEName" value="<?php echo $strEName?>" size="30" /></td>
            </tr>
            <tr>
              <td class="column-th">學號或員工編號</td>
              <td><input name="strNo" type="text" class="m-input" id="strNo" value="<?php echo $strNo?>" size="30" /></td>
            </tr>
            <tr >
              <td class="column-th">聯絡電話 <i class="fa fa-asterisk"></i></td>
              <td><input name="strTel" type="text" class="m-input" id="strTel" value="<?php echo $strTel?>" size="30" /></td>
            </tr>
            <tr >
              <td class="column-th">聯絡地址(中) <i class="fa fa-asterisk"></i></td>
              <td><input name="strAddress" type="text" class="m-input" id="strAddress" value="<?php echo $strAddress?>" size="50" /></td>
            </tr>
            <tr >
              <td class="column-th">聯絡地址(英)</td>
              <td><input name="strEAddress" type="text" class="m-input" id="strEAddress" value="<?php echo $strEAddress?>" size="50" /></td>
            </tr>
            <tr>
              <td class="column-th">電子郵件 <i class="fa fa-asterisk"></i></td>
              <td><input name="EMail" type="text" class="m-input" id="EMail" value="<?php echo $Email?>" size="25" maxlength="20" /></td>
            </tr>
            <tr >
              <td width="180" class="column-th">會員身份 <i class="fa fa-asterisk"></i></td>
              <td><select class="m-select" name="strType" id="strType">
                <option selected="selected" value="">請選擇</option>
                <option value="1"<?php if ( $strType == 1 ){ echo "selected";}?>>教師</option>
                <option value="2"<?php if ( $strType == 2 ){ echo "selected";}?>>博士班</option>
                <option value="3"<?php if ( $strType == 3 ){ echo "selected";}?>>碩士班</option>
                <option value="4"<?php if ( $strType == 4 ){ echo "selected";}?>>大學部</option>
                <option value="5"<?php if ( $strType == 5 ){ echo "selected";}?>>外系師生</option>
                <option value="9"<?php if ( $strType == 9 ){ echo "selected";}?>>其他</option>
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
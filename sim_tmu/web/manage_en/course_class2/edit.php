<?
	require_once("../_inc.php");
	$mainitem    = "m2";
	$subitem     = "m21";
	$subname     = $m2.$mgw1." » ".$m21.$mgw4;
	$unitprocess = $m_home.$icon.$m2.$mgw1.$icon.$m21.$mgw2; //單元路徑列
	$ModuleNo    = 2;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		//取得明細資料
		$SQL = "Select PKey, Sort, strName, Upload, dtUDate, UserID, class1_PKey From course_class2 Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$PKey = $rsUD->field("PKey");
			$Sort = $rsUD->field("Sort");
			$class1_PKey = $rsUD->field("class1_PKey");
			$strName = $rsUD->field("strName");
			$Upload = $rsUD->field("Upload");
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
	
	/***判斷Sort value***/
	if ( $Sort == "" ){ $Sort = "0"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $pageTitle1.$pageTitle2 ?></title>
<? require_once("../_in_javascript.php") ?>
<script language="JavaScript" type="text/javascript">
	
	/***判斷表單欄位***/
	
	function login(theForm){
		theForm.submit();
	}
	
	function fieldCheck0(theForm){
		
		/*判斷順序*/
		if (isNaN(parseInt(theForm.Sort.value))){
			alert("【順序】空白或非數字型態!"); 
			theForm.Sort.value = "";
			theForm.Sort.focus();
			return false;
		}

		/*判斷主類別項目*/
	  	if (theForm.class1.value == ""){
			alert("【主要類別】請選擇！");
			theForm.class1.focus();
			return false;
		}

		/*判斷類別名稱*/
	  	if (theForm.strName.value == ""){
			alert("【類別名稱】請勿空白！");
			theForm.strName.focus();
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
          <div id="mainpage">
            <!--main begin-->
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="m-tables">
              <tr>
                <td width="177" class="column-th"><i class="fa fa-asterisk"></i> 順序</td>
                <td width="1393"><span class="line-d">
                  <input name="Sort" type="text" class="m-input" id="Sort" size="6" value="<? echo AddZero($Sort)?>"/>
                  &nbsp;</span><span class="red">限輸入數字</span></td>
              </tr>
              <tr>
                <td class="column-th"><i class="fa fa-asterisk"></i> 主要類別</td>
                <td>
                	<select name="class1" id="class1" class="m-select">
                    	<option value="">請選擇</option>
                        <?php
                        	/***取得主(固定)類別資料***/
							$SQL = "Select PKey, strName From course_class1 Order By Sort";
							$rs = new recordset($SQL);
							while (! $rs->eof ){ ?>
                            <option value="<? echo $rs->field("PKey")?>"<?php if ( $class1_PKey == $rs->field("PKey") ){ echo " selected";}?>><? echo $rs->field("strName")?></option>
                        <?php
								$rs->movenext();
							}?>
                    </select>
                </td>
              </tr>
              <tr>
                <td class="column-th"><i class="fa fa-asterisk"></i> 類別名稱</td>
                <td><input name="strName" type="text" class="m-input" id="strName" size="30" value="<? echo $strName?>"/></td>
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
                <td><? require_once("../_modify.php") ?></td>
              </tr>
            </table>
            <? require_once("../_submit.php") ?>
            <!--main end-->
          </div>
        </form>
        <!--contentpage end-->
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
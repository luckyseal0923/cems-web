<?
require_once("../_inc.php");
$mainitem    = "m3";
$subitem     = "m3";
$subname     = $m3.$mgw1;
$unitprocess = $m_home.$icon.$m3.$mgw1; //單元路徑列
$ModuleNo    = 3;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	echo "<script language=\"javascript\">" ;
	echo "alert('無進入[".$m3."]權限!');";
	echo "location.href='../index.php';";
	echo "</script>";
}

//清除Session變數
unset($_SESSION["PKey_".$ModuleNo]);
unset($Keywords);

//刪除
if($_REQUEST["Action"] == "del"){
	$SQL = "Select * From member Where PKey IN (".implode(",",$_POST["nid"]).")";
	$DR1 = new recordset($SQL);
	while (! $DR1->eof){
		execute_sql ("delete From member Where PKey =".$DR1->field("PKey")) ;
		$DR1->movenext();
	}// while End

	echo "<script language=\"javascript\">" ;
	echo "alert('成功刪除!');" ;
	echo "location.href='".$_SERVER["PHP_SELF"]."';" ;
	echo "</script>" ;
	exit() ;
}

//判斷有無執行搜尋
$Cond = " where intLang = 1 ";
if ($_REQUEST["Submit"] == "搜尋" OR $_REQUEST["Send"] == "搜尋"){
	$Keywords = $_REQUEST["Keywords"];

	$strF = 1;
	if ($Keywords != "" && $Keywords != "請輸入姓名或帳號關鍵字搜尋" && $Item!="Address"){
		if ($strF == 1){$Cond1 = " (Locate('".SqlFilter($Keywords,"str")."',strName)> 0) Or (Locate('".SqlFilter($Keywords,"str")."',strID)> 0)";}
		$strF = 0;
	}
	
	if ($strF == 1)
		$Cond .= " ";
	else
		$Cond .= " and ".$Cond1.$Cond2.$Cond3.$Cond4.$Cond5.$Cond6.$Cond7.$Cond8;
}

if ($Keywords == "")
	$Keywords="請輸入姓名或帳號關鍵字搜尋";

//頁次程式
$SQL = "Select Count(PKey) as Total From member ".$Cond;
$DR1 = new recordset($SQL);
$Total = $DR1->field("Total");//取得資料的總數
//頁數
$tSum=1;
$tPageTotal=1;
$tPage = 1;
//每頁幾筆-----
$tPageSize=15;
//總頁數-----
$tPageTotal = ceil(($Total/$tPageSize));

//目前頁數

if (SqlFilter($_REQUEST["Page"],"int") > 0)
	$tPage = $_REQUEST["Page"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("../_in_code_head.php"); ?>
<title><?php echo $pageTitle1.$pageTitle2?></title>
<?php require("../_in_javascript.php"); ?>
<?php require_once("../_in-script.php"); ?>
<script language="JavaScript" type="text/javascript">
	$(function() {
			   
		/*匯出會員資料*/
		$("#OE").click(function(){
		var Keywords = $("#Keywords").val();
		MM_openBrWindow("output.php?Keywords="+Keywords);
		});
		
		/*匯出電子報名單*/
		$("#OE1").click(function(){
		MM_openBrWindow("output1.php");
		});
	});
</script>
</head>
<body>
<?php require("../_top.php"); ?>
<div id="m-wrapper">
  <div class="m-container narrow">
    <?php require("../_sidebar.php"); ?>
    <div class="m-main">
      <?php require("../_banner.php"); ?>
      <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onsubmit="document.form1.Page.value=1">
        <div class="m-content">
          <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
          <h2 class="pageTitle"><?php echo $subname ?></h2>
          <div class="m-search-bar"><span class="span-group">關鍵字：
            <input name="Keywords" type="text" class="m-input" value="<?php echo $Keywords?>" size="40" id="Keywords" onkeydown="if(event.keyCode==13){this.form.submit();}" onfocus="if (this.value == '<?php echo $Keywords?>') {this.value='';}" />
            <input name="Submit" type="submit" class="btn btn-default submit" value="搜尋" id="Submit" />
            </span>
            </p>
          </div>
          <!--search-bar-->
          <div class="m-btn-group">
            <? include("../_select.php")?>
            <input type="button" name="ADD" id="ADD" class="btn btn-warning add" value="新增" onclick="location.href='edit.php'"/>
          </div>
          <!--btn-group-->
          <table width="100%" cellspacing="0" cellpadding="0" class="m-tables">
            <tr>
              <th width="2%">&nbsp;</th>
              <th width="4%" align="center">&nbsp;</th>
              <th width="8%" align="center">會員身份</th>
              <th width="8%" align="center">會員姓名</th>
              <th width="10%" align="center">學號 / 員工編號</th>
              <th width="10%" align="center">會員帳號</th>
              <th width="0" align="left">聯絡電話</th>
              <th width="6%" align="center">加入日期</th>
              <th width="6%" align="center">編輯</th>
            </tr>
            <?php
				$tSum = 0;
				$sql = "Select * From member $Cond Order By dtDate Desc";
				$sql .= " limit " .($tPage - 1)*$tPageSize.",$tPageSize";//每頁顯示資料的 sql 語法,僅取出所需的資料筆數.
				$rs = new recordset($sql);
				if ($rs->field("PKey") == ""){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料</font></td></tr>";}
				while (! $rs->eof){
					$tSum++;
					$chk = "";
					/*若該會員有報名記錄，則不允許刪除*/
//					$SQL = "Select * From order_p Where Member_PKey=".$rs->field("PKey");
//					$rsOrder = new recordset($SQL);
//					if (!$rsOrder->eof){$chk = "disabled=\"disabled\"";}					
			  ?>
                    <tr onMouseOver='this.style.backgroundColor="#EFEFEF"' onMouseOut='this.style.backgroundColor=""'>
                      <td width="2%"><input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?>  /></td>
                      <td width="4%" align="center"><? echo Addzero($tSum) ?></td>
                      <td width="8%" align="center"><? echo Member_Type($rs->field("strType"))?></td>
                      <td width="8%" align="center"><? echo $rs->field("strName")?></td>
                      <td width="10%" align="center"><? echo $rs->field("strNo")?></td>
                      <td width="10%" align="center"><? echo $rs->field("strID")?></td>
                      <td width="0" align="left"><? echo $rs->field("strTel")?></td>
                      <td width="6%" align="center"><? echo Date_EN($rs->field("dtDate"),1) ?></td>
                      <td width="6%" align="center" valign="top"><input name="boton" type="button" class="btn btn-info" id="boton" onclick="Update('edit.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" /></td>
                    </tr>
            <?php
				$rs->movenext();
			}
		  ?>
          </table>
          <? require_once("../_page.php") ?>
          <input name="PKey" type="hidden" id="PKey" value="" />
          <ul class="notes css-radius">
            <li class="th">注意事項</li>
            <li>每15筆一頁。</li>
          	<li>排序欄位：加入日期 《由大到小》。</li>
          	<li class="red">若該會員帳號下有報名記錄，該會員資料不允許刪除。</li>
          	<li>會員資料　：<input type="button" name="OE" id="OE" class="btn btn-warning add" value="匯出Excel"/></li>
          </ul>
        </div>
      </form>
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
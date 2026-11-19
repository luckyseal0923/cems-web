<?
require_once("../_inc.php");
$mainitem    = "m1";
$subitem     = "m11";
$subname     = $m1.$mgw1." » ".$m11.$mgw4;
$unitprocess = $m_home.$icon.$m1.$mgw1.$icon.$m11.$mgw4; //單元路徑列
$ModuleNo    = 1;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	echo "<script language=\"javascript\">" ;
	echo "alert('無進入[".$m1."]權限!');";
	echo "location.href='../index.php';";
	echo "</script>";
	exit;
}

//清除Session變數
unset($_SESSION["PKey_".$ModuleNo]);
unset($Keywords);

/***刪除動作***/
if($_REQUEST["Action"] == "del"){
	$sql = "Select PKey From news_class2 Where PKey IN (".implode(",",$_POST["nid"]).")";
	$DR1 = new recordset($sql);
	while (! $DR1->eof){
		//執行刪除
		execute_sql ("delete From news_class2 Where PKey =".$DR1->field("PKey")) ;
		$DR1->movenext();
	}// while End
	
	echo "<script language=\"javascript\">" ;
	echo "alert('成功刪除!');" ;
	echo "location.href='".$_SERVER["PHP_SELF"]."';" ;
	echo "</script>" ;
	exit() ;
}

/***判斷有無執行搜尋***/
$Cond = " where intLang = 1 ";
if ($_REQUEST["Submit"] == "搜尋" OR $_REQUEST["Send"] == "搜尋"){
	$Keywords = $_REQUEST["Keywords"];
	$Class1 = SqlFilter($_REQUEST["Class1"],"int");
	
	$strF = 1;
	if ($Keywords != "" && $Keywords != "請輸入類別名稱搜尋"){
		if ($strF==1){$Cond1 = " (Locate('".SqlFilter($Keywords,"str")."',strName)> 0 )";}
		$strF = 0;
	}
	
	if ($Class1 > 0){
		if ($strF == 1)
		{$Cond2 = " (class1_PKey =".$Class1.")";}
		else
		{$Cond2 = " AND (class1_PKey =".$Class1.")";}
		$strF = 0;
	}

	if ($strF == 1)
		$Cond .= " ";
	else
		$Cond .= " and ".$Cond1.$Cond2;
}

if ($Keywords == "")
	$Keywords="請輸入類別名稱搜尋";

$SQL = "Select Count(PKey) as Total From news_class2 ".$Cond;
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
</head>
<body>
<?php require("../_top.php"); ?>
<div id="m-wrapper">
  <div class="m-container narrow">
    <?php require("../_sidebar.php"); ?>
    <div class="m-main">
      <?php require("../_banner.php"); ?>
      <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
        <div class="m-content">
          <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
          <h2 class="pageTitle"><?php echo $subname ?></h2>
          <!--search-bar-->
		  <div class="m-search-bar">主要類別：
          	<select name="Class1" id="Class1" class="m-select">
            	<option value="">請選擇</option>
                <?php
                	/***取得主要類別資料***/
					$SQL = "Select PKey,strName From news_class1 Where Upload='Yes' Order By Sort";
					$rsse = new recordset($SQL);
					while (! $rsse->eof){?>
                    	<option value="<? echo $rsse->field("PKey")?>" <?php if ( $Class1 == $rsse->field("PKey") ){ echo "selected";}?>><? echo $rsse->field("strName")?></option>
                <?php
                		$rsse->movenext();
					}
				?>
            </select>　
          	<span class="span-group">關鍵字：
            <input name="Keywords" type="text" class="m-input" value="<?php echo $Keywords?>" size="40" id="Keywords" onkeydown="if(event.keyCode==13){this.form.submit();}" onfocus="if (this.value == '<?php echo $Keywords?>') {this.value='';}" />
            <input name="Submit" type="submit" class="btn btn-default submit" value="搜尋" id="Submit" />
            </span>
            </p>
          </div>

          <div class="m-btn-group">
            <? include("../_select.php")?>
            <input type="button" name="add" id="add" class="btn btn-warning add" onclick="location.href='edit.php'" value="新增資料" />
          </div>
          <!--btn-group-->
          <table width="100%" cellspacing="0" cellpadding="0" class="m-tables">
            <tr>
              <th width="2%">&nbsp;</th>
              <th width="4%" align="center">順序</th>
              <th width="8%" align="center">主要類別</th>
              <th align="left">類別名稱</th>
              <th width="8%" align="center">更新日期</th>
              <th width="8%" align="center">上/下架</th>
              <th width="8%" align="center">編輯</th>
            </tr>
            <?php
			$SQL = "Select PKey, strName, dtUDate, Upload, Sort, class1_PKey From news_class2 $Cond Order By class1_PKey, Sort";
			$rs = new recordset($SQL);
			if ($rs->field("PKey") == ""){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料</font></td></tr>";}
			while (! $rs->eof){
				
				/*取得主要類別名稱*/
				$Class1Name = "";
				$SQL = "Select strName From news_class1 Where PKey=".SqlFilter($rs->field("class1_PKey"),"int");
				$rsC = new recordset($SQL);
				if (! $rsC->eof){
					$Class1Name = $rsC->field("strName");
				}
				
				/*判斷上下架*/
				$Upload = "上架";
				if ($rs->field("Upload")=="No"){$Upload="<span class=\"orange\">下架</span>";}
				
				/*判斷是否尚有新聞在分類下,是否可刪除*/
				$SQL = "Select * From news Where class2_PKey=".$rs->field("PKey");
				$rsN = new recordset($SQL);
				if ( $rsN->field("PKey") > 0 ){ $chk = "disabled=\"disabled\"";}
		  ?>
            <tr onMouseOver='this.style.backgroundColor="#EFEFEF"' onMouseOut='this.style.backgroundColor=""'>
              <td width="2%" align="center">
                <input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?> />
              </td>
              <td width="4%" align="center"><? echo AddZero($rs->field("Sort"))?></td>
              <td width="8%" align="center"><? echo $Class1Name?></td>
              <td><? echo $rs->field("strName")?></td>
              <td align="center"><? echo Date_EN($rs->field("dtUDate"),1)?></td>
              <td align="center"><? echo $Upload ?></td>
              <td align="center" valign="top">
                <input name="boton" type="button" class="btn btn-info" id="boton"  onclick="Update('edit.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" />
              </td>
            </tr>
            <?php
			$rs->movenext();
		}
	  ?>
          </table>
          <?php //require("../_page.php"); ?>
          <input name="PKey" type="hidden" id="PKey" value="" />
          <ul class="notes css-radius">
            <li class="th">注意事項</li>
            <li>不分頁。</li>
            <li>排序：主要類別&nbsp;→&nbsp;順序《由小到大》。</li>
            <li class="orange">若該分類下尚有最新消息資料,則該分類不可刪除。</li>
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
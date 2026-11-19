<?
require_once("../_inc.php");
$mainitem    = "m6";
$subitem     = "m61";
$subname     = $m6.$icon.$m61.$mgw1;
$unitprocess = $m_home.$icon.$m6.$icon.$m61.$mgw1; //單元路徑列
$ModuleNo    = 6;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	echo "<script language=\"javascript\">" ;
	echo "alert('無進入[".$m6."]權限!');";
	echo "location.href='../index.php';";
	echo "</script>";
}

/***清除Session變數***/
unset($_SESSION["PKey_".$ModuleNo]);
unset($Keywords);

/***列表頁變更順序用(show_chg_bt[1=顯示；0=不顯示])***/
$thisPageType = "list";
$show_chg_bt  = "1";
$DelDbName   = "faq";
$DelDbNameId = "PKey";
require("../include2/_list_chg.php");

//刪除
if($_REQUEST["Action"] == "del"){
	$SQL = "Select * From filedown_class1 Where PKey IN (".implode(",",$_POST["nid"]).")";
	$DR1 = new recordset($SQL);
	while (! $DR1->eof){
		execute_sql ("delete From filedown_class1 Where PKey =".$DR1->field("PKey")) ;
		$DR1->movenext();
	}// while End

	echo "<script language=\"javascript\">" ;
	echo "alert('成功刪除!');" ;
	echo "location.href='".$_SERVER["PHP_SELF"]."';" ;
	echo "</script>" ;
	exit() ;
}

/***判斷有無執行搜尋***/
$Cond = " where intLang = 2 ";

/*上下架*/
if ( $_REQUEST["Upload"] != "" ){
	$Upload = SqlFilter($_REQUEST["Upload"],"str");
	$Cond .= " AND ( Upload = '" . $Upload . "' ) ";
}
/*關鍵字*/
if ( $_REQUEST["Keywords"] != "" && $_REQUEST["Keywords"] != "請輸入類別標題搜尋" ){
	$Keywords = SqlFilter($_REQUEST["Keywords"],"str");
	$Cond .= " And (Locate('".SqlFilter($Keywords,"str")."',strName)> 0 )";
}
	
if ($Keywords == ""){ $Keywords="請輸入類別標題搜尋"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("../_in_code_head.php"); ?>
<title><?php echo $pageTitle1.$pageTitle2?></title>
<?php require("../_in_javascript.php"); ?>
<?php require_once("../_in-script.php"); ?>
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
          <div class="m-search-bar"><span class="span-group">上下架：
          <select name="Upload" class="m-select">
            <option value="">請選擇</option>
            <option value="Yes"<?php if ( $Upload == "Yes" ){echo " selected";}?>>上架</option>
            <option value="No"<?php if ( $Upload == "No" ){echo " selected";}?>>下架</option>
          </select>
          　關鍵字：
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
              <th width="2%" align="center">&nbsp;</th>
              <th width="8%" align="center">類別排序</th>
              <th align="left">類別標題</th>
              <th width="8%" align="center">上下架</th>
              <th width="8%" align="center">更新日期</th>
              <th width="8%" align="center">編輯</th>
            </tr>
            <?php
				$SQL = "Select * From filedown_class1 $Cond Order By Sort, dtUDate Desc";
				$rs = new recordset($SQL);
				if ($rs->field("PKey") == ""){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料</font></td></tr>";}
				while (! $rs->eof){
					
					/*判斷上下架*/
					$Upload = "上架";
					if ( $rs->field("Upload") == "No" ){ $Upload = "<span class=\"orange\">下架</span>";}
					
					/*是否允許刪除*/
					$chk = "";
					$SQL = "Select PKey From filedown Where Class1_PKey=".SqlFilter($rs->field("PKey"),"int");
					$rs1 = new recordset($SQL);
					if (! $rs1->eof ){
						$chk = "disabled=\"disabled\"";
					}
			  ?>
                    <tr onMouseOver='this.style.backgroundColor="#EFEFEF"' onMouseOut='this.style.backgroundColor=""'>
                      <td width="2%" align="center"><input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?>  /></td>
                      <td width="8%" align="center"><?php echo AddZero($rs->field("Sort"));?></td>
                      <td><?php echo $rs->field("strName")?></td>
                      <td width="8%" align="center"><? echo $Upload?></td>
                      <td width="8%" align="center"><? echo Date_EN($rs->field("dtUDate"),1) ?></td>
                      <td width="8%" align="center" valign="top"><input name="boton" type="button" class="btn btn-info" id="boton" onclick="Update('edit.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" /></td>
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
            <li>不分頁。</li>
          	<li>排序欄位：項目順序《由大到小》→更新日期《由大到小》。</li>
            <li class="red">若類別下尚有檔案連結，則該類別不允許刪除。</li>
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
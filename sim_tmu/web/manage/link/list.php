<?
require_once("../_inc.php");
$mainitem    = "m7";
$subitem     = "m7";
$subname     = $m7.$mgw1;
$unitprocess = $m_home.$icon.$m7.$mgw1; //單元路徑列
$ModuleNo    = 7;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	echo "<script language=\"javascript\">" ;
	echo "alert('無進入[".$m7."]權限!');";
	echo "location.href='../index.php';";
	echo "</script>";
}

//清除Session變數
unset($_SESSION["PKey_".$ModuleNo]);
unset($Keywords);

//刪除
if($_REQUEST["Action"] == "del"){
	$sql = "Select PKey from link_item Where PKey IN (".implode(",",$_POST["nid"]).")";
	$rs = new recordset($sql);
	while (! $rs->eof){
		execute_sql ("Delete From link_item Where PKey =".$rs->field("PKey")) ;
		$rs->movenext();
	}
	
	echo "<script language=\"javascript\">" ;
	echo "alert('成功刪除!');" ;
	echo "location.href='".$_SERVER["PHP_SELF"]."';" ;
	echo "</script>" ;
	exit() ;
}

//判斷有無執行搜尋
$Cond = " where intLang = 1 ";
	
/*關鍵字*/
if ( $_REQUEST["Keywords"] != "" ){
	$Keywords = SqlFilter($_REQUEST["Keywords"],"str");
	$Cond .= " And (Locate('".SqlFilter($Keywords,"str")."',strName)> 0 )";
}
	
//分頁程式-取得現有資料
$SQL = "Select Count(PKey)as Total From link_item ".$Cond;
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
if (SqlFilter($_REQUEST["Page"],"int") > 0){
	$tPage = $_REQUEST["Page"];
}
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
      <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onsubmit="document.form1.Page.value=1">
        <div class="m-content">
          <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
          <h2 class="pageTitle"><?php echo $subname ?></h2>
          <div class="m-search-bar"><span class="span-group">關鍵字：
			<input name="Keywords" type="text" class="m-input" value="<?php echo $Keywords?>" size="40" id="Keywords" onkeydown="if(event.keyCode==13){this.form.submit();}" onfocus="if (this.value == '<?php echo $Keywords?>') {this.value='';}" placeholder="請輸入連結文字關鍵字搜尋"/>
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
              <th width="6%">順序</th>
              <th align="left">連結文字</th>
              <th width="8%">上下架</th>
              <th width="8%">修改日期</th>
              <th width="8%">編輯</th>
            </tr>
            <?php
				/***取得現有新聞資料***/
				$SQL = "Select * From link_item $Cond Order By Sort";
				$SQL .= " limit " .($tPage - 1)*$tPageSize.",$tPageSize";//每頁顯示資料的 sql 語法,僅取出所需的資料筆數.
				$rs = new recordset($SQL);
				if ($rs->field("PKey") == ""){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料</font></td></tr>";}
				$tSum = 0;
				while (! $rs->eof){
					
					/*判斷上下架*/
					$Upload = "上架";
					if ( $rs->field("Upload") == "No" ){ $Upload = "<span class=\"orange\">下架</span>";}
		  ?>
            <tr onmouseover="bgColor='<? echo $line_color?>'"  onmouseout="bgColor=''">
              <td align="center"><input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?>  /></td>
              <td align="center"><? echo AddZero($rs->field("Sort"))?></td>
              <td align="left"><? echo $rs->field("strName")?></td>
              <td align="center"><? echo $Upload?></td>
              <td align="center"><?php echo Date_EN($rs->field("dtUDate"),2)?></td>
              <td align="center" valign="top"><input name="boton" type="button" class="btn btn-info" id="boton"  onclick="Update('edit.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" /></td>
            </tr>
            <?php
			$rs->movenext();
		}
	  ?>
          </table>
          <input name="PKey" type="hidden" id="PKey" value="" />
          <?php require("../_page.php"); ?>
          <ul class="notes css-radius">
            <li class="th">注意事項</li>
            <li>每頁15筆資料。</li>
            <li>排序：順序《由小到大》。</li>
          </ul>
        </div>
      </form>
      <?php require("../_footer.php"); ?>
    </div>
  </div>
</div>
<?php require("../_in_code_bottom.php"); ?>
</body>
</html>

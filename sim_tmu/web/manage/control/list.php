<?
require_once("../_inc.php");
$mainitem = "s2";
$subitem = "s2";
$subname = $s2.$mgw1;
$unitprocess = $m_home.$icon.$s2.$mgw1; //單元路徑列
$ModuleNo = 99;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('無進入[".$mainitem."]權限!');";
	ECHO "location.href='../index.php';";
	ECHO "</script>";
}

//清除Session變數
unset($_SESSION["Pkey_".$ModuleNo]);	

//刪除
if($_REQUEST["Action"] == "del"){
	$SQL = "Select * From webcontrol Where PKey IN (".implode(",",$_POST["nid"]).")";
	$DR1 = new recordset($SQL);
	while (! $DR1->eof){
		execute_sql ("delete from webcontrol Where PKey =".$DR1->field("PKey")) ;
		$DR1->movenext();
	}// while End
	
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('成功刪除!');" ;
	ECHO "location.href='".$_SERVER["PHP_SELF"]."';" ;
	ECHO "</script>" ;
	exit() ;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require("../_in_code_head.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle1.$pageTitle2 ?></title>
<?php require("../_in_javascript.php"); ?>
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
        <h2 class="pageTitle"><?php echo $subname ?></h2>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="form1" id="form1" onsubmit="document.form1.Page.value=1">
          <div class="m-btn-group">
            <?php require("../_select.php"); ?>
            <input type="button" name="button" id="button" class="btn btn-warning add" value="新增資料" onclick="location.href='add.php';" />
          </div>
          <!--m-btn-group-->
          <table width="100%" cellspacing="0" cellpadding="0" class="m-tables">
            <tr>
              <th width="4%" align="center">&nbsp;</th>
              <th width="8%" align="center">順序</th>
              <th width="15%" align="left">帳號</th>
              <th width="15%" align="left">姓名</th>
              <th align="left">權限名稱</th>
              <th width="10%" align="center">更新日期</th>
              <th width="8%" align="center">編輯</th>
            </tr>
            <?php
            $tSum = 0;
			$sql = "Select * From webcontrol Where strID <> 'Admin' Order By strID";
			$rs = new recordset($sql);
			if ($rs->eof){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料。</font></td></tr>";}
			while (! $rs->eof){
				$tSum = $tSum + 1;
			?>
            <tr>
              <td align="center">
                <input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?> />
              </td>
              <td align="center"><?php echo AddZero($tSum)?> </td>
              <td><?php echo $rs->field("strID")?></td>
              <td><? echo $rs->field("strName")?></td>
              <td><?php echo $rs->field("FunctionName")?>&nbsp;</td>
              <td align="center"><? echo Date_EN($rs->field("dtUDate"),1)?></td>
              <td align="center">
                <input name="boton" type="button" class="btn btn-info" id="boton" onclick="Update('update.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" />
              </td>
            </tr>
            <?
            $rs->movenext();
			}
			?>
          </table>
        <input type="hidden" name="PKey" id="PKey" />
        </form>
        <ul class="notes css-radius">
          <li class="th">注意事項</li>
          <li>不分頁</li>
          <li>排序：帳號(（由小至大）</li>
        </ul>
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
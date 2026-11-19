<?
require_once("../_inc.php");
$mainitem    = "m2";
$subitem     = "m22";
$subname     = $m2.$mgw1." » ".$m22.$mgw4;
$unitprocess = $m_home.$icon.$m2.$mgw1.$icon.$m22.$mgw4; //單元路徑列
$ModuleNo    = 2;

if (! in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) && $_SESSION["Login_ID"] != "Admin"){
	echo "<script language=\"javascript\">" ;
	echo "alert('無進入[".$m2."]權限!');";
	echo "location.href='../index.php';";
	echo "</script>";
	exit;
}

//清除Session變數
unset($_SESSION["PKey_".$ModuleNo]);
unset($Keywords);

//刪除
if($_REQUEST["Action"] == "del"){
	$sql = "Select PKey from course Where PKey IN (".implode(",",$_POST["nid"]).")";
	$rs = new recordset($sql);
	while (! $rs->eof){
		$sql = "Select * From course_img Where course_PKey =".$rs->field("PKey");
		$rs1 = new recordset($sql);
		while (! $rs1->eof){
			//刪除圖檔
			DelFile("../../Upload/course/".$rs1->field("Photo1"));
			DelFile("../../Upload/course/s_".$rs1->field("Photo1"));
			execute_sql ("Delete From course_img Where PKey =".$rs1->field("PKey")) ;
		$rs1->movenext();
		}// while End
	execute_sql ("Delete From course Where PKey =".$rs->field("PKey")) ;
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
if ($_REQUEST["Submit"] == "搜尋" OR $_REQUEST["Send"] == "搜尋"){
	$Keywords = $_REQUEST["Keywords"];
	$OpenDate = SqlFilter($_REQUEST["OpenDate"],"str");
	$EndDate = SqlFilter($_REQUEST["EndDate"],"str");

	$strF = 1;
	if ($Keywords != "" && $Keywords != "請輸入課程標題搜尋"){
		if ($strF == 1){$Cond1 = " (Locate('".SqlFilter($Keywords,"str")."',strName)> 0 )";}
		$strF = 0;
	}

	if (chkDate($OpenDate)){
		if ($strF == 1)
		{$Cond4 = " (OpenDate >='".$OpenDate."')";}
		else
		{$Cond4 = " AND (OpenDate >='".$OpenDate."')";}
		$strF = 0;
	}

	if (chkDate($EndDate)){
		if ($strF == 1)
		{$Cond5 = " (OpenDate <='".$EndDate."')";}
		else
		{$Cond5 = " AND (OpenDate <='".$EndDate."')";}
		$strF = 0;
	}

	if ($strF == 1)
		$Cond .= " ";
	else
		$Cond .= " and ".$Cond1.$Cond4.$Cond5;
}
	
if ($Keywords == ""){
	$Keywords="請輸入課程標題搜尋";
}

//分頁程式-取得現有資料
$SQL = "Select Count(PKey)as Total From course ".$Cond;
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
          <div class="m-search-bar"><span class="span-group">課程開始日期：
              <input name="OpenDate" type="text" class="m-input" id="OpenDate" size="10" value="<?php echo $OpenDate ?>" onclick="this.value='';" readonly="readonly" />
            <a href="javascript:;" id="BTN1"><i class="fa fa-calendar"></i></a>
            <script type="text/javascript">
                Calendar.setup({
                    inputField     :    "OpenDate",  //input元件主題
                    ifFormat       :    "%Y/%m/%d",　//輸出日期格式
                    showsTime      :    false, //日曆是否要在底訲顯示時間
                    button         :    "BTN1", //啟動日曆的按鈕id
                    singleClick    :    true, //是否需要雙擊按鈕才能啟動
                    steo           :    1 //上一年及次一年,年份間格,預設2
                });
                 </script>
            ~
            <input name="EndDate" type="text" class="m-input" id="EndDate" size="10" value="<?php echo $EndDate ?>" onclick="this.value='';" readonly="readonly" />
            <a href="javascript:;" id="BTN2"><i class="fa fa-calendar"></i></a>
            <script type="text/javascript">
                Calendar.setup({
                    inputField     :    "EndDate",  //input元件主題
                    ifFormat       :    "%Y/%m/%d",　//輸出日期格式
                    showsTime      :    false, //日曆是否要在底訲顯示時間
                    button         :    "BTN2", //啟動日曆的按鈕id
                    singleClick    :    true, //是否需要雙擊按鈕才能啟動
                    steo           :    1 //上一年及次一年,年份間格,預設2
                });
                 </script>
            </span> <span class="span-group"> 關鍵字：
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
              <th width="8%" align="center">課程主要類別</th>
              <th width="8%" align="center">課程類別</th>
              <th align="left">課程名稱（講師姓名）</th>
              <th width="12%" align="center">可報名人數(目前人數)</th>
              <th width="8%" align="center">首頁顯示</th>
              <th width="20%" align="left">課程日期</th>
              <th width="8%" align="center">編輯</th>
            </tr>
            <?php
				/***取得現有新聞資料***/
				$SQL = "Select * From course $Cond Order By class1_PKey, class2_PKey, Sort";
				$SQL .= " limit " .($tPage - 1)*$tPageSize.",$tPageSize";//每頁顯示資料的 sql 語法,僅取出所需的資料筆數.
				$rs = new recordset($SQL);
				if ($rs->field("PKey") == ""){ echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"10\" align=\"center\" height=\"100\"><font color=\"red\">暫無資料</font></td></tr>";}
				while (! $rs->eof){
					
					$PeopleSum = "";
					
					/*取得主要類別名稱*/
					$Class1Name = "";
					$SQL = "Select PKey,strName From course_class1 Where PKey=".$rs->field("class1_PKey");
					$rsc = new recordset($SQL);
					if ( $rsc->field("PKey") > 0 ){ $Class1Name = $rsc->field("strName");}
					
					/*取得類別名稱*/
					$Class2Name = "";
					$SQL = "Select PKey,strName From course_class2 Where PKey=".$rs->field("class2_PKey");
					$rsc = new recordset($SQL);
					if ( $rsc->field("PKey") > 0 ){ $Class2Name = $rsc->field("strName");}
					
					//取下架日期
					$EndDate = $rs->field("EndDate");
					
					//判斷首頁顯示
					$showIndex = "";
					if ($rs->field("showIndex")=="1"){$showIndex="<span class=\"orange\"><i class=\"fa fa-check-circle\"></i></span>";}
					
					/*判斷上下架*/
					$Upload = "上架";
					if ( $rs->field("Upload") == "No" ){ $Upload = "<span class=\"orange\">下架</span>";}
					
					/*判斷人數顯示*/
					if ( $rs->field("class1_PKey") == 2){
						$PeopleSum = $rs->field("PeopleNumber1")."（".$rs->field("PeopleNumber2")."）";
					}else{
						$PeopleSum = "--";
					}
		  ?>
            <tr onmouseover="bgColor='<? echo $line_color?>'"  onmouseout="bgColor=''">
              <td width="2%" align="center"><input type="checkbox" name="nid[]" value="<? echo $rs->field("PKey")?>" <?php echo $chk?>  /></td>
              <td width="4%" align="center"><? echo AddZero($rs->field("Sort"))?></td>
              <td width="8%" align="center"><? echo $Class1Name?></td>
              <td width="8%" align="center"><? echo $Class2Name?></td>
              <td><? echo $rs->field("strName")."（".$rs->field("strTeacher")."）"?></td>
              <td width="12%" align="center"><? echo $PeopleSum?></td>
              <td width="8%" align="center"><? echo $showIndex?></td>
              <td width="20%" align="left"><?php echo "日期：".Date_EN($rs->field("OpenDate"),2)." ~ ".Date_EN($rs->field("EndDate"),2)."<br>時間：".$rs->field("dtCourse_time")?></td>
              <td width="8%" align="center" valign="top"><input name="boton" type="button" class="btn btn-info" id="boton"  onclick="Update('edit.php','<?php echo authcode($rs->field("PKey"),'ENCODE')?>')" value="編輯" /></td>
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
            <li>排序：課程開始日期《由大到小》→&nbsp;順序《由小到大》。</li>
            <li class="orange">首頁顯示：勾選首頁顯示且排序前三筆資料。</li>
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

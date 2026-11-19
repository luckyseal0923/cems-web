<?
	require_once("../_inc.php");
	$mainitem    = "m2";
	$subitem     = "m23";
	$subname     = $m2.$mgw1." » ".$m23.$mgw2;
	$unitprocess = $m_home.$icon.$m2.$mgw1.$icon.$m23.$mgw2; //單元路徑列
	$ModuleNo    = 2;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
		
		/*取得明細*/
		$SQL = "Select * From apply Where PKey=".SqlFilter($Update_PKey,"int");
		$rsUD = new recordset($SQL);
		if (! $rsUD->eof){
			$apply_PKey = $rsUD->field("PKey");
			$Course_PKey = $rsUD->field("Course_PKey");
			$Member_Name = $rsUD->field("Member_Name");
			$Course_Name = $rsUD->field("Course_Name");
			$dtDate = Date_EN($rsUD->field("dtDate"),1);
			$Flag = $rsUD->field("flag");
			$UserID = $rsUD->field("UserID");
			$dtUDate = $rsUD->field("dtUDate");	
			
			/*取得課程日期*/
			$SQL = "Select OpenDate,EndDate,dtCourse_time From course Where PKey = ".SqlFilter($Course_PKey,"int");
			$rsC = new recordset($SQL);
			if (! $rsC->eof ){
				$OpenDate = $rsC->field("OpenDate");
				$EndDate = $rsC->field("EndDate");
				$dtTime = $rsC->field("dtCourse_time");
			}
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
              <td height="50" class="column-th">報名者姓名</td>
              <td height="50" align="left" class="line-d"><? echo $Member_Name?></td>
            </tr>
            <tr>
              <td width="132" height="50" class="column-th">報名課程</td>
              <td width="1474" height="50" align="left" class="line-d"><? echo $Course_Name?></td>
            </tr>
            <tr>
              <td height="50" class="column-th">報名日期</td>
              <td height="50" align="left" class="line-d"><? echo $dtDate?></td>
            </tr>
            <tr>
              <td height="50" valign="top" class="column-th">課程日期</td>
              <td height="50" class="line-d"><?php echo Date_EN($OpenDate,2)." ~ ".Date_EN($EndDate,2)?></td>
            </tr>
            <tr>
              <td height="50" valign="top" class="column-th">課程時間</td>
              <td height="50" class="line-d"><? echo $dtTime?></td>
            </tr>
            <tr>
              <td height="50" class="column-th">報名狀態</td>
              <td height="50"><select name="Flag" class="m-select" id="Flag">
                <option value="0" <?php if($Flag == '0') {echo "selected=\"selecteded\"";}?>>尚未繳費</option>
                <option value="1" <?php if($Flag == '1') {echo "selected=\"selecteded\"";}?>>已繳費</option>
              </select></td>
            </tr>
            <tr>
              <td height="50" class="column-th">更新日期</td>
              <td height="50" align="left" class="line-d"><?php require_once("../_modify.php"); ?></td>
            </tr>
          </table>
          <input type="hidden" name="apply_PKey" value="<? echo $apply_PKey?>">
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
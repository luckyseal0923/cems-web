<?php
    require("_inc.php");
	$pageName = "p5";
	$subPageName = "p5_1";
    $nav=$home.$icon.$p5;
	
	
	
	/***接收日期參數***/
	if ( $_REQUEST["chkM"] != "" ){

		$chkY = SqlFilter($_REQUEST["chkY"],"tab");
		$chkM = SqlFilter($_REQUEST["chkM"],"tab");
		$chkD = SqlFilter($_REQUEST["chkD"],"tab");
		$chkDate = $chkY."-".$chkM."-".$chkD;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php require("_in_code_head.php"); ?>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
<![endif]-->
<!-- Mobile layout control 若需自適應打開此設定 
<meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
<title>
<?php echo $pageTitle;?>
</title>
<meta name="description" content="" />
<meta name="keywords" content="<?php echo $m_keywords;?>" />
<meta name="Robots" content="all" />
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="wrapper">
  <h4 align="left"><? echo $chkY?> 年 <? echo $chkM?> 月 <? echo $chkD?> 日場地狀態</h4>
<!--  <table width="900" border="0">
    <tr>
      <td align="right"><input name="status" type="radio">全部<input name="status" type="radio">已租借<input name="status" type="radio">未租借</td>
    </tr>
  </table>	
-->  <table width="900" class="c_list">
    <tr>
      <th>教室</th>
      <th>時段</th>
      <th>狀態</th>
      <th>單位</th>
      <th>聯絡人</th>
    </tr>
    <?php for ($i=1;$i<=15;$i++){?>
	    <?php for ($j=1;$j<=3;$j++){?>
        <?php
        	/***判斷教室是否已租借***/
			$SQL = "Select * From rental_p Where classroom_PKey = ".$i." And Rental_Date = '".$chkDate."' And Rental_Time = ".$j;
			$rs = new recordset($SQL);
			$Rental_unit = "";
			$Rental_name = "";
			if (! $rs->eof ){
				$Rental_Status = "<font color='red'>已租借</font>";
				$Rental_unit = $rs->field("Rental_unit");
				$Rental_name = $rs->field("Rental_name");
			}else{
				$Rental_Status = "未租借";
			}
		?>
            <tr onMouseOver='this.style.backgroundColor="#EFEFEF"' onMouseOut='this.style.backgroundColor=""'>
              <td><? echo Classroom_Type($i)?></td>
              <td class="txt_center"><? echo Rental_Time($j)?></td>
              <td class="txt_center"><? echo $Rental_Status?></td>
              <td class="txt_center"><? echo $Rental_unit?></td>
              <td class="txt_center"><? echo $Rental_name?></td>
            </tr>
	    <?php }?>
    <?php }?>
  </table>
  <!--共15間教室!!!!-->
  <!--wrapper-->
</div>
</body>
</html>
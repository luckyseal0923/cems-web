<?php
require("_inc.php");
$pageName = "p8";
$subPageName = "p8_1";
$nav=$home.$icon.$p8;
$Cond = " Where intLang = 1 and Upload='Yes'";
/***分頁程式***/
$SQL = "Select Count(PKey)as Total From faq ".$Cond;
$DR1 = new recordset($SQL);
$Total = $DR1->field("Total");	/*取得資料的總數*/

/*頁數設定*/
$tSum=1;
$tPageTotal=1;
$tPage = 1;
$tPageSize=5;	/*每頁幾筆*/
$tPageTotal = ceil(($Total/$tPageSize));	/*總頁數*/

/*目前頁數*/
if (SqlFilter($_REQUEST["Page"],"int") > 0){
	$tPage = $_REQUEST["Page"];
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
<title><?php echo $pageTitle;?></title>
<meta name="description" content="" />
<meta name="keywords" content="<?php echo $m_keywords;?>" />
<meta name="Robots" content="all" />
<?php require("_in_javascript.php"); ?>
<link rel="stylesheet" href="../css/style.css">
</head>
<body <?php echo $bodytxt; ?>>
<div id="wrapper">
  <?php require("_menu.php"); ?>
  <?php require("_header.php"); ?>
  <div class="container clearfix">
	<?php require("_sidebar.php"); ?>
    <div class="main">
    <h2><?php echo $p8;?></h2>
    <div class="site"><? echo $nav;?></div>
    <ul class="faq_list">
    <?php /***取得目前資料列表***/
		$tSum = ($tPage-1) * $tPageSize;
		$SQL = "Select PKey,strName From faq ".$Cond." Order By Sort";
		$SQL .= " Limit " .($tPage - 1)*$tPageSize.",$tPageSize";
		$rs = new recordset($SQL);
		$tSum = 0;
		while (! $rs->eof ){
			$tSum++;
	?>
        	<li><a href="p8_faq_detail.php?PKey=<?php echo authcode($rs->field("PKey"),'ENCODE')?>"><div class="q_style"><p>Q<?php echo $tSum?></p></div><p class="q_title"><?php echo $rs->field("strName")?></p></a></li>
    <?php
    		$rs->movenext();
		}
	?>
    </ul>
    <?php require("_page_number.php"); ?>
	</div>
  </div>
</div>
<?php require("_footer.php"); ?>
</body>
</html>
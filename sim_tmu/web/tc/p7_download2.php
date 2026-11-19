<?php
    require("_inc.php");
	$pageName = "p7";
	$subPageName = "p7_2";
    $nav=$home.$icon.$p7;
	
	
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
      <h2><?php echo $p7;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="download_box">
        <h3 class="title4"><?php echo $p7_2; ?></h3>
        <p class="source_txt">資料來源:臺灣醫學教育學會</p>
      	<ul class="download_list">
        	<li><a href="../download/cems_03.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">OSCE整體規劃</p></a></li>
            <li><a href="../download/cems_04.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">OSCE基本概念與台灣國考現況</p></a></li>
            <li><a href="../download/cems_05.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">OSCE評分共識建立</p></a></li>
            <li class="clear"><a href="../download/cems_06.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">OSCE評分表與及格標準之制定原則</p></a></li>
            <li><a href="../download/cems_07.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">SP在聯合OSCE的角色與常見問題</p></a></li>
            <li><a href="../download/cems_08.pdf" target="_blank"><div class="download_icon"><img src="../images/p7/pdf.png"></div><p class="q_title">考場突發狀況之處理</p></a></li>

        </ul>
      </div>
      <!--main-->
      </div>
  
  
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
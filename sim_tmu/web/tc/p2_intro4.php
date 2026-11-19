<?php
    require("_inc.php");
	$pageName = "p2";
	$subPageName = "p2_4";
    $nav=$home.$icon.$p2.$icon.$p2_4;
	
	
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
      <h2><?php echo $p2_4;?></h2>
      <div class="site"><? echo $nav;?></div>
      
      <div style="margin-bottom:10px;">
      	110臺北市信義區吳興街250號 醫學模擬教育大樓
      </div>
      
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.217623977767!2d121.560192474832!3d25.026687638586985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442aa4b2ab8d925%3A0x93bcdecdd0969e89!2zMTEw5Y-w5YyX5biC5L-h576p5Y2A5ZCz6IiI6KGXMjUw6Jmf!5e0!3m2!1szh-TW!2stw!4v1746704048900!5m2!1szh-TW!2stw" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      
      <!--<div class="intro_box">
      	<img src="../images/p2/04/04.png" class="flt entrance_img">
      	<p class="entrance"><span class="entrance_txt">本中心位於杏春樓B1，<br>入口位於教研大樓對面</span></p>        
      </div>
      <div class="intro_box">
      	<img src="../images/p2/04/01.png" class="flt entrance_img">
      	<p class="entrance"><span class="entrance_txt">01. 位於雕像後方</span><br>The entrance behind carved stone</p>        
      </div>
      <div class="intro_box">
      	<img src="../images/p2/04/02.png" class="flt entrance_img">
      	<p class="entrance"><span class="entrance_txt">02. 醫學模擬教育中心入口</span><br>Center for Education in Medical Simulation Entrance</p>        
      </div>
      <div class="intro_box">
      	<img src="../images/p2/04/03.png" class="flt entrance_img">
      	<p class="entrance"><span class="entrance_txt">03. 抵達</span><br>Arrive</p>        
      </div> -->
      
      <!--main-->
      </div>
  
  
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
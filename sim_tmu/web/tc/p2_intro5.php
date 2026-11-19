<?php
    require("_inc.php");
	$pageName = "p2";
	$subPageName = "p2_5";
    $nav=$home.$icon.$p2.$icon.$p2_5;
	
	
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
<meta name="description" content="<?php echo $m_description;?>" />
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
      <h2><?php echo $p2_5;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="intro_box intro5_bg">
      	<h3 class="title1">宗旨</h3>
        <p>● 整合體系模擬教育資源<br>
          ● 培育本校模擬醫學師資<br>
          ● 研發模擬醫學教育課程<br>
          ● 進行國際模擬學術交流<br>
          ● 促進產學合作創新研發<br>
        ● 推廣模擬教育商業營運</p>
      </div>
      <div class="intro_box style_intro5">
      	<h3 class="title1">目標</h3>
        <div class="target">
        <p class="target_txt1"><i class="fa fa-circle"></i><span>近程</span>-培訓模擬教學師資，使模擬教學融入全校各科系的課程之中。</p>
        <p class="target_txt2"><i class="fa fa-circle"></i><span>中程</span>-成為醫學模擬教育的標竿訓練中心。</p>
        <p class="target_txt3"><i class="fa fa-circle"></i><span>遠程</span>-發展商業經營模式，實踐產學合作。</p>
        </div>  
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
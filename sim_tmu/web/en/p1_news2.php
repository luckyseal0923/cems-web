<?php
    require("_inc.php");
	$pageName = "p1";
	$subPageName = "p1_2";
	$subPageName2 = "p1_2_1";
    $nav=$home.$icon.$p1.$icon.$p1_2;
	
	
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
      <h2><?php echo $p1_2_1;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="news_listBox">
      	<div class="flt"><img src="../images/p1/img.jpg" class="news_img"></div><!--80x64-->
        <div class="flr news_info">
        <a href="#">
        <span>2015-06-02</span><span class="news_browse">瀏覽人次：3000</span>
        <p>第九次精進工作小組會議</p>
        </a>
        </div>
      </div>
      <div class="news_listBox">
      	<div class="flt"><img src="../images/p1/img.jpg" class="news_img"></div>
        <div class="flr news_info">
        <a href="#">
        <span>2015-05-20</span><span class="news_browse">瀏覽人次：127</span>
        <p>牙醫系TRM討論</p>
        </a>
        </div>
      </div>
      <div class="news_listBox">
      	<div class="flt"><img src="../images/p1/img.jpg" class="news_img"></div>
        <div class="flr news_info">
        <a href="#">
        <span>2015-05-14</span><span class="news_browse">瀏覽人次：127</span>
        <p>醫技系教案討論</p>
        </a>
        </div>
      </div>
      <div class="news_listBox">
      	<div class="flt"><img src="../images/p1/img.jpg" class="news_img"></div>
        <div class="flr news_info">
        <a href="#">
        <span>2015-05-14</span><span class="news_browse">瀏覽人次：127</span>
        <p>醫技系教案討論</p>
        </a>
        </div>
      </div>
      <?php require("_page_number.php"); ?>
      <!--main-->
      </div>
  
  
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
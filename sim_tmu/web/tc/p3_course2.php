<?php
    require("_inc.php");
	$pageName = "p3";
	$subPageName = "p3_2";
	$subPageName2 = "p3_2_1";
    $nav=$home.$icon.$p3.$icon.$p3_2;
	
	
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
      <h2><?php echo $p3_1_2;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="course_box">
      <div class="coures_title"><p class="i_icon">i</p>身體檢查評估與檢驗判讀</div>
      <p class="course_info">102學年度第一學期「身體檢查評估與檢驗判讀」於每週一下午一點至三點由醫學系四年級、呼吸治療系三年級、醫學檢驗生物技術學系三年級及護理系三年級等四系學生共同參與，學生人數共約350人分成13大組/週，每週由一大組同學約27人至醫學模擬</p>
      <div class="txt_right"><a href="p3_course_detail2.php"><img src="../images/p3/btn_01.png" onMouseOut="this.src='../images/p3/btn_01.png'" onMouseOver="this.src='../images/p3/btn_01b.png'" class="course_btn" /></a><a href="p4_mem_check.php"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" />
</a><!--<img src="../images/p3/btn_03.png"  class="course_btn" />--></div>
      </div>
      <div class="course_box">
      <div class="coures_title"><p class="i_icon">i</p>身體檢查評估與檢驗判讀</div>
      <p class="course_info">102學年度第一學期「身體檢查評估與檢驗判讀」於每週一下午一點至三點由醫學系四年級、呼吸治療系三年級、醫學檢驗生物技術學系三年級及護理系三年級等四系學生共同參與，學生人數共約350人分成13大組/週，每週由一大組同學約27人至醫學模擬</p>
      <div class="txt_right"><a href="p3_course_detail2.php"><img src="../images/p3/btn_01.png" onMouseOut="this.src='../images/p3/btn_01.png'" onMouseOver="this.src='../images/p3/btn_01b.png'" class="course_btn" /></a><!--<a href="p3_course_detail.php"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" />
</a>--><img src="../images/p3/btn_03.png"  class="course_btn" /></div>
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
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
</head>

<body <?php echo $bodytxt; ?>>
  <div id="wrapper">
    <?php require("_menu.php"); ?>
    <?php require("_header.php"); ?>
    <div class="container clearfix">
      <?php require("_sidebar.php"); ?>
      <div class="main">
        <h2><?php echo $p2_5;?></h2>
        <div class="site"><?php echo $nav;?></div>
        <div class="intro_box intro5_bg">
          <h3 class="title1">Purpose</h3>
          <p>Through situational simulation training, we help students to correctly apply the acquired knowledge, skills and attitudes in clinical practice so that university education and post-graduation clinical practice can be smoothly linked.</p>
        </div>
        <div class="intro_box style_intro5">
          <h3 class="title1">Aims</h3>
          <div class="target">
            <p class="target_txt1"><i class="fa fa-circle"></i><span>Short Course</span>&nbsp;-&nbsp;Training simulation teaching faculty to include simulation teaching in all departments of the school.</p>
            <p class="target_txt2"><i class="fa fa-circle"></i><span>midrange</span>&nbsp;-&nbsp;becomes the benchmark training center for medical simulation education.</p>
            <p class="target_txt3"><i class="fa fa-circle"></i><span>Remote</span>&nbsp;-&nbsp;Developing business models and implementing industry-university cooperation.</p>
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

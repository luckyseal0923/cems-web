<?php
    require("_inc.php");
	$pageName = "p5";
	$subPageName = "p5_2";
    $nav=$home.$icon.$p5.$icon.$p5_2;
	
	
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
<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
								
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
</head>

<body <?php echo $bodytxt; ?>>

<div id="wrapper">
  <?php require("_menu.php"); ?>
  <?php require("_header.php"); ?>
  <div class="container clearfix">
      
	  <?php require("_sidebar.php"); ?>
      
    <div class="main">
      <h2><?php echo $p5_2;?></h2>
      <div class="site"><? echo $nav;?></div>
      <h4>&nbsp;</h4>
      <h4>校內單位請使用「臺北醫學大學場地借用系統」(<a href="https://rd2sys.tmu.edu.tw:8011/BorrowSpaceNew/Home/" target="_blank">https://rd2sys.tmu.edu.tw:8011/BorrowSpaceNew/Home/</a>)申請借用，<br>
      校外單位請另來信至 hungchen@tmu.edu.tw 陳小姐收。</h4>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
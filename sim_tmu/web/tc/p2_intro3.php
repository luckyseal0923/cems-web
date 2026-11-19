<?php
    require("_inc.php");
	$pageName = "p2";
	$subPageName = "p2_3";
    $nav=$home.$icon.$p2.$icon.$p2_3;
	
	
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
		$(".iframe").colorbox({iframe:true, width:"820px", height:"550px"});
						
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
      <h2><?php echo $p2_3;?></h2>
      <div class="site"><? echo $nav;?></div>
      <map name="Map">
        <area shape="rect" coords="252,161,388,234" href="p2_intro3-02.php" class="iframe" title="林哲瑋">
      </map>
      <div class="intro_box">
        <img src="../images/p2/03/img01_20250516.jpg" width="690" height="782" border="0" usemap="#MapMap">
        <map name="MapMap"><area shape="rect" coords="88,558,141,624" href="p2_intro3-13.php" class="iframe" title="何容"><area shape="rect" coords="553,558,608,623" href="p2_intro3-07.php" class="iframe" title="陳虹蓁"><area shape="rect" coords="27,559,82,624" href="p2_intro3-07.php" class="iframe" title="陳虹蓁"><area shape="rect" coords="545,422,671,495" href="p2_intro3-11.php" class="iframe" title="陳皓羽"><area shape="rect" coords="23,423,149,496" href="p2_intro3-11.php" class="iframe" title="陳皓羽"><area shape="rect" coords="178,559,223,625" href="p2_intro3-02.php" class="iframe" title="林哲瑋"><area shape="rect" coords="230,561,274,621" href="p2_intro3-06.php" class="iframe" title="黃文成"><area shape="rect" coords="209,297,332,359" href="p2_intro3-06.php" class="iframe" title="黃文成"><area shape="rect" coords="284,562,332,623" href="p2_intro3-05.php" class="iframe" title="吳人傑"><area shape="rect" coords="355,293,488,356" href="p2_intro3-05.php" class="iframe" title="吳人傑"><area shape="rect" coords="525,248,651,306" href="p2_intro3-12.php" class="iframe" title="儲榢逸"><area shape="rect" coords="515,71,666,145" href="p2_intro3-10.php" class="iframe" title="Paul Phrampus">
          <area shape="rect" coords="274,196,410,269" href="p2_intro3-02.php" class="iframe" title="林哲瑋">
        </map>
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
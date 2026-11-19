<?php
    require("_inc.php");
	$pageName = "p7";
	$subPageName = "p7_1";
    $nav=$home.$icon.$p7;
	
	
	
	/***取得預設類別值***/
	$SQL = "Select PKey,strName From filedown_class1 Where intLang = 1 and Upload='Yes' Order By Sort Limit 1";
	$rs = new recordset($SQL);
	if (! $rs->eof ){
		$class_PKey = $rs->field(0);
		$class_Name = $rs->field(1);
	}
	
	/***接收類別值***/
	if ($_REQUEST["class_PKey"] <> ""){
		$class_PKey = authcode($_REQUEST["class_PKey"],'DECODE');
		$SQL = "Select strName From filedown_class1 Where PKey=".SqlFilter($class_PKey,"int")." And Upload='Yes'";
		$rs = new recordset($SQL);
		if (! $rs->eof ){
			$class_Name = $rs->field(0);
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('該類別已下架!');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
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
      <h2><?php echo $p7;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="download_box">
        <h3 class="title4"><?php echo $class_Name;?></h3>
        <?php if ( $class_Name == "全國醫學校院聯合臨床技能測驗考官測驗師資工作坊教案" || $class_Name == "標準化病人儲備課程教案" ){?><p class="source_txt">資料來源:臺灣醫學教育學會</p><?php }?>
      	<ul class="download_list">
        <?php /***取得類別資料清單***/
			$SQL = "Select * From filedown where intLang = 1 and Upload='Yes' Order By Sort";
			$rs = new recordset($SQL);
			while (! $rs->eof ){
				
				/*判斷連結型態*/
				$LINK = "";
				if ( $rs->field("intLink") == 1 ){
					$LINK = $rs->field("strLink");
				}else{
					$LINK = "../Upload/filedown/".$rs->field("FileName");					
				}
		?>
        		<li><a href="<?php echo $LINK;?>" target="_blank"><div class="download_icon"><img src="../images/p7/doc.png"></div><p class="q_title"><?php echo $rs->field("strName");?></p></a></li>
        <?php
				$rs->movenext();
			}
		?>
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
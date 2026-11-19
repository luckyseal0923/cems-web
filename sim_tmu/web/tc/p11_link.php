<?php
    require("_inc.php");
	$pageName = "p11";
	$subPageName = "p11_1";
    $nav=$home.$icon.$p11;
	
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
<title>
<?php echo $pageTitle;?>
</title>
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
            <h2>
                <?php echo $p11;?>
            </h2>
            <div class="site"><? echo $nav;?></div>
            <div class="link-list-title">
                <div class="row">
                <?php //連結列表
					$SQL = "Select strName,strUrl From link_item Where intLang = 1 and Upload='Yes' Order By Sort";
					$rs = new recordset($SQL);
					while (! $rs->eof ){
				?>
	                    <div class="col-xs-12 linklist"> <a href="<?php echo $rs->field("strUrl");?>" target="_blank" class="hvr-sweep-to-right"><i class="fa fa-external-link" aria-hidden="true"></i><?php echo $rs->field("strName");?></a> </div>
                <?php
                		$rs->movenext();
					}
				?>
                </div>
            </div>
            <?php require("_page_number.php"); ?>
        </div>
    </div>
</div>
<?php require("_footer.php"); ?>
</body>
</html>
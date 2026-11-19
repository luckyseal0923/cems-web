<?php
  require("_inc.php");
  $pageName = "p8";
  $subPageName = "p8_1";
  $nav=$home.$icon.$p8;

	/***參數解碼***/
	if ($_REQUEST["PKey"] <> ""){
		$PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***取得解碼資料***/
	$SQL = "Select * From faq Where PKey=".SqlFilter($PKey,"int")." And Upload='Yes'";
	$rs = new recordset($SQL);
	if (! $rs->eof ){
		$PKey = $rs->field("PKey");
		$strName = $rs->field("strName");
		$contents1 = $rs->field("contents1");
		$contents2 = $rs->field("contents2");
		$contents3 = $rs->field("contents3");
		$contents4 = $rs->field("contents4");
		
		/*取圖片陣列*/
		$Photo = array();
		$PhotoW = array();
		$PhotoH = array();
		for ($i=1;$i<=4;$i++){
			$SQL = "Select * From faq_img Where faq_PKey=".SqlFilter($PKey,"int")." And Sort=".$i;
			$rs = new recordset($SQL);
			if (! $rs->eof){
				array_push($Photo,$rs->field("Photo1"));
				array_push($PhotoW,$rs->field("PhotoW1"));
				array_push($PhotoH,$rs->field("PhotoH1"));
			}else{			
				array_push($Photo,'');
				array_push($PhotoW,0);
				array_push($PhotoH,0);
			}
		}
	}else{
		echo "<script language=\"javascript\">" ;
		echo "alert('查無資料,或該資料已下架!');";
		echo "location.href='javascript:history.back()';";
		echo "</script>";
		exit;
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
</head>

<body <?php echo $bodytxt; ?>>
  <div id="wrapper">
    <?php require("_menu.php"); ?>
    <?php require("_header.php"); ?>
    <div class="container clearfix">
      <?php require("_sidebar.php"); ?>
      <div class="main">
        <h2><?php echo $p8;?></h2>
        <div class="site"><?php echo $nav;?></div>
        <div class="detail_title">
          <p class="q_icon">Q</p>
          <p class="q_title"><?php echo $strName?></p>
        </div>
        <br class="clear">
        <div class="detail_box">
          <!--上圖下文-->
          <?php if ( $Photo[0] != "" ){?><div class="detail_box"><img src="../Upload/faq/<?php echo $Photo[0];?>"></div><?php }?>
          <?php if ( $contents1 != "" ){?><div class="detail_box"><?php echo $contents1;?></div><?php }?>
          <!--左圖右文-->
          <div class="detail_box">
            <?php if ( $Photo[1] != "" ){?><div class="detail_t"><img src="../Upload/faq/<?php echo $Photo[1];?>" width="100%"></div><?php }?>
            <?php if ( $contents2 != "" ){?><div class="detail_r"><?php echo $contents2;?></div><?php }?>
          </div>
          <!--右圖左文-->
          <div class="detail_box">
            <?php if ( $contents3 != "" ){?><div class="detail_t2"><?php echo $contents3;?></div><?php }?>
            <?php if ( $Photo[2] != "" ){?><div class="detail_r2"><img src="../Upload/faq/<?php echo $Photo[2];?>" width="100%"></div><?php }?>
          </div>
          <!--下圖上文-->
          <?php if ( $contents4 != "" ){?><div class="detail_box"><?php echo $contents4;?></div><?php }?>
          <?php if ( $Photo[3] != "" ){?><div class="detail_box"><img src="../Upload/faq/<?php echo $Photo[3];?>"></div><?php }?>
          <div class="back_btn"><a href="javascript:history.back()">上一頁</a></div>
        </div>
      </div>
    </div>
  </div>
  <?php require("_footer.php"); ?>
</body>
</html>

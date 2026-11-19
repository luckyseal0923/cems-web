<?php
    require("_inc.php");
	$pageName = "p1";
	$subPageName = "p1_1";
    $nav=$home.$icon.$p1.$icon.$p1_1;
	
	//$Cond = " Where (OpenDate <=Now() AND EndDate >= Now()) ";
	$Cond = " Where intLang = 2 and datediff(OpenDate,'".date("Y/m/d")."')<= 0 and datediff(EndDate,'".date("Y/m/d")."')>=0";
	
	/***參數解碼(新聞PKey)***/
	if ($_REQUEST["PKey"] <> ""){
		
		$News_PKey = authcode($_REQUEST["PKey"],'DECODE');		
		
		/***更新瀏覽人數***/
		$SQL = "Update news Set viewCount = viewCount + 1 Where PKey = ".$News_PKey;
		execute_sql($SQL);
		
		/*取得新聞明細*/
		$SQL = "Select * From news $Cond And PKey = ".SqlFilter($News_PKey,"int");
		$rsdetail = new recordset($SQL);
		if (! $rsdetail->eof ){
			$News_PKey = $rsdetail->field("PKey");
			$Class1_PKey = $rsdetail->field("class1_PKey");
			$Class2_PKey = $rsdetail->field("class2_PKey");
			$strName = $rsdetail->field("strName");
			$contents1 = $rsdetail->field("contents1");
			$OpenDate = $rsdetail->field("OpenDate");
			$youtubeID = $rsdetail->field("youtubeID");
			$PoName = $rsdetail->field("PoName");
			
			/*取得主類別名稱*/
			$SQL = "Select strName From news_class1 Where PKey = ".$Class1_PKey;
			$rsClass1 = new recordset($SQL);
			if (! $rsClass1->eof ){ $Class1_Name = $rsClass1->field("strName");}
			
			/*取得次類別名稱*/
			$SQL = "Select strName From news_class2 Where PKey = ".$Class2_PKey;
			$rsClass2 = new recordset($SQL);
			if (! $rsClass2->eof ){ $Class2_Name = $rsClass2->field("strName");}
			
			/*取得圖片陣列*/
			$Photo = array();
			$PhotoW = array();
			$PhotoH = array();
			for ($i=1;$i<=2;$i++){
				$SQL = "Select Photo1, PhotoW1, PhotoH1 From news_img Where News_PKey=".$News_PKey." And Sort=".$i;
				$rs = new recordset($SQL);
				if (! $rs->eof){
					/*前台縮圖*/
					$imgSize = ReSizeImg('Upload/news/'.$rs->field("Photo1"),690,300);
					$intW = $imgSize[0];
					$intH = $imgSize[1];
					
					array_push($Photo,$rs->field("Photo1"));
					array_push($PhotoW,$intW);
					array_push($PhotoH,$intH);
				}else{			
					array_push($Photo,'');
					array_push($PhotoW,0);
					array_push($PhotoH,0);
				}
			}
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('無此新聞資料!');";
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
<title>
<?php echo $pageTitle;?>
</title>
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
      <h2>
        <? echo $Class2_Name?>
      </h2>
      <div class="site"><? echo $nav;?></div>
      <div class="txt_right min_txt">張貼人：<? echo $PoName?> ╱ 公告日期：<? echo Date_EN($OpenDate,2)?></div>
      <div class="news_title"><? echo $strName?></div>
      <?php if ( $Photo[0] != "" ){?>      
	      <div class="detail_box"><img src="../Upload/news/<? echo $Photo[0]?>" width="690"></div>
      <?php }?>
      <!----編輯器----->
      <div class="detail_box"><? echo $contents1?></div>
      <?php if ( $Photo[1] != "" ){?>
	      <div class="detail_box"><img src="../Upload/news/<? echo $Photo[1]?>" width="690"></div>
      <?php }?>
      <!----編輯器----->
      <?php if ( $youtubeID != "" ){?>
          <div class="detail_box">
            <iframe width="690" height="388" src="https://www.youtube.com/embed/<? echo $youtubeID?>" frameborder="0" allowfullscreen></iframe>
          </div>
      <?php }?>
      <div class="back_btn"><a href="javascript:history.back()">上一頁</a></div>
      <!--main-->
    </div>
    <!--container-->
  </div>
  <!--wrapper-->
</div>
<?php require("_footer.php"); ?>
</body>
</html>
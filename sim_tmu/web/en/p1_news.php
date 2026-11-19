<?php
    require("_inc.php");
	$pageName = "p1";
	$subPageName = "p1_1";
	$subPageName2 = "p1_1_1";	
	
	//$Cond = " Where OpenDate <=Now() AND EndDate >= Now() ";
	$Cond = " Where intLang = 2 and datediff(OpenDate,'".date("Y/m/d")."')<= 0 and datediff(EndDate,'".date("Y/m/d")."')>=0";
	
	/***取得預設主類別***/
	$SQL = "Select PKey,strName From news_class1 Where intLang = 2 and Upload = 'Yes' Order By Sort Limit 1";
	$rsClass1 = new recordset($SQL);
	if (! $rsClass1->eof ){
		$Class1_PKey = $rsClass1->field("PKey");
		$Class1_Name = $rsClass1->field("strName");
	}
	
	/***接收主類別***/
	if ( $_REQUEST["C1_PKey"] != "" ){
		$Class1_PKey = authcode($_REQUEST["C1_PKey"],'DECODE');
		
		/*取得主類別名稱*/
		$SQL = "Select strName From news_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($Class1_PKey,"int");
		$rsClass1 = new recordset($SQL);
		if (! $rsClass1->eof ){
			$Class1_Name = $rsClass1->field("strName");
		}
	}
	
	/***取得預設次類別***/
	$SQL = "Select class1_PKey,PKey,strName From news_class2 Where intLang = 2 and Upload = 'Yes' And class1_PKey = ".SqlFilter($Class1_PKey,"int")." Order By Sort Limit 1";
	$rsClass2 = new recordset($SQL);
	if (! $rsClass2->eof ){
		$Class1_PKey = $rsClass2->field("class1_PKey");
		$Class2_PKey = $rsClass2->field("PKey");
		$Class2_Name = $rsClass2->field("strName");
		/*取得主類別名稱*/
		$SQL = "Select strName From news_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($Class1_PKey,"int");
		$rsClass1 = new recordset($SQL);
		if (! $rsClass1->eof ){
			$Class1_Name = $rsClass1->field("strName");
		}
	}
	
	/***接收次類別***/
	if ( $_REQUEST["C2_PKey"] != "" ){
		$Class2_PKey = authcode($_REQUEST["C2_PKey"],'DECODE');
		
		/*取得次類別名稱*/
		$SQL = "Select class1_PKey,strName From news_class2 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($Class2_PKey,"int");
		$rsClass2 = new recordset($SQL);
		if (! $rsClass2->eof ){
			$Class1_PKey = $rsClass2->field("class1_PKey");
			$Class2_Name = $rsClass2->field("strName");
			/*取得主類別名稱*/
			$SQL = "Select strName From news_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($Class1_PKey,"int");
			$rsClass1 = new recordset($SQL);
			if (! $rsClass1->eof ){
				$Class1_Name = $rsClass1->field("strName");
			}
		}
	}
	
	/*組合路徑文字*/
	$nav=$home.$icon.$Class1_Name.$icon.$Class2_Name;
	
	/***分頁程式-取得現有資料***/
	$SQL = "Select Count(PKey)as Total From news $Cond And class1_PKey = ".SqlFilter($Class1_PKey,"int")." And class2_PKey = ".SqlFilter($Class2_PKey,"int");
	$DR1 = new recordset($SQL);
	$Total = $DR1->field("Total");//取得資料的總數
	/*頁數*/
	$tSum=1;
	$tPageTotal=1;
	$tPage = 1;
	/*每頁幾筆*/
	$tPageSize=15;
	/*總頁數*/
	$tPageTotal = ceil(($Total/$tPageSize));
	/*目前頁數*/
	if (SqlFilter($_REQUEST["Page"],"int") > 0){
		$tPage = $_REQUEST["Page"];
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
        <h2>
          <? echo $Class2_Name?>
        </h2>
        <div class="site">
          <? echo $nav;?>
        </div>
        <?php
      	/***取得新聞列表***/
		$SQL  = "Select PKey,strName,OpenDate,viewCount From news $Cond And class1_PKey = ".SqlFilter($Class1_PKey,"int")." And ";
		$SQL .= "class2_PKey = ".SqlFilter($Class2_PKey,"int")." Order By OpenDate Desc, Sort";
		$SQL .= " limit " .($tPage - 1)*$tPageSize.",$tPageSize";//每頁顯示資料的 sql 語法,僅取出所需的資料筆數.
		$rsnewslist = new recordset($SQL);
		while (! $rsnewslist->eof ){
			
			/*取得新聞圖片*/
			$SQL = "Select * From news_img Where news_PKey = ".$rsnewslist->field("PKey")." And Photo1 <>'' Order By Sort Limit 1";
			$rsnewsimg = new recordset($SQL);
			if (! $rsnewsimg->eof ){
				$Photo1 = $rsnewsimg->field("Photo1");
				/*前台縮圖*/
				$imgSize = ReSizeImg('Upload/news/'.$Photo1,92,76);
				$intW = $imgSize[0];
				$intH = $imgSize[1];
			}
	  ?>
        <div class="news_listBox">
          <?php if ( $Photo1 != "" ){?>
          <div class="flt"><img src="../Upload/news/<? echo $Photo1?>" class="news_img" width="100px" height="<? echo $intH?>"></div>
          <?php }?>
          <!--80x64-->
          <div class="flr news_info"> <a href="p1_news_detail.php?PKey=<? echo authcode($rsnewslist->field("PKey"),'ENCODE')?>"> <span>
                <? echo Date_EN($rsnewslist->field("OpenDate"),2)?></span><span class="news_browse">瀏覽人次：
                <? echo $rsnewslist->field("viewCount")?></span>
              <p>
                <? echo $rsnewslist->field("strName")?>
              </p>
            </a> </div>
        </div>
        <?php
      		$rsnewslist->movenext();
		}
	  ?>
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

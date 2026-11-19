<?php
  require("_inc.php");
	$pageName = "p3";
	$subPageName = "p3_1";
	$subPageName2 = "p3_1_1";
  $nav=$home.$icon.$p3.$icon.$p3_1;
	/***取得預設主類別***/
	$SQL = "Select PKey,strName From course_class1 Where intLang = 2 and Upload = 'Yes' Order By Sort Limit 1";
	$rsClass1 = new recordset($SQL);
	if (! $rsClass1->eof ){
		$C_Class1_PKey = $rsClass1->field("PKey");
		$Class1_Name = $rsClass1->field("strName");
	}
	
	/***接收主類別***/
	if ( $_REQUEST["C1_PKey"] != "" ){
		$C_Class1_PKey = authcode($_REQUEST["C1_PKey"],'DECODE');
		
		/*取得主類別名稱*/
		$SQL = "Select strName From course_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($C_Class1_PKey,"int");
		$rsClass1 = new recordset($SQL);
		if (! $rsClass1->eof ){
			$Class1_Name = $rsClass1->field("strName");
		}
	}
	
	/***取得預設次類別***/
	$SQL = "Select class1_PKey,PKey,strName From course_class2 Where intLang = 2 and Upload = 'Yes' And class1_PKey = ".SqlFilter($C_Class1_PKey,"int")." Order By Sort Limit 1";
	$rsClass2 = new recordset($SQL);
	if (! $rsClass2->eof ){
		$C_Class1_PKey = $rsClass2->field("class1_PKey");
		$C_Class2_PKey = $rsClass2->field("PKey");
		$Class2_Name = $rsClass2->field("strName");
		/*取得主類別名稱*/
		$SQL = "Select strName From course_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($C_Class1_PKey,"int");
		$rsClass1 = new recordset($SQL);
		if (! $rsClass1->eof ){
			$Class1_Name = $rsClass1->field("strName");
		}
	}
	
	/***接收次類別***/
	if ( $_REQUEST["C2_PKey"] != "" ){
		$C_Class2_PKey = authcode($_REQUEST["C2_PKey"],'DECODE');
		
		/*取得次類別名稱*/
		$SQL = "Select class1_PKey,strName From course_class2 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($C_Class2_PKey,"int");
		$rsClass2 = new recordset($SQL);
		if (! $rsClass2->eof ){
			$C_Class1_PKey = $rsClass2->field("class1_PKey");
			$Class2_Name = $rsClass2->field("strName");
			/*取得主類別名稱*/
			$SQL = "Select strName From course_class1 Where intLang = 2 and Upload = 'Yes' And PKey = ".SqlFilter($C_Class1_PKey,"int");
			$rsClass1 = new recordset($SQL);
			if (! $rsClass1->eof ){
				$Class1_Name = $rsClass1->field("strName");
			}
		}
	}
	
	/***組合路徑文字***/
	$nav=$home.$icon.$Class1_Name.$icon.$Class2_Name;
	
	/***分頁程式-取得現有資料***/
	$SQL = "Select Count(PKey)as Total From course Where class1_PKey = ".SqlFilter($C_Class1_PKey,"int")." And class2_PKey = ".SqlFilter($C_Class2_PKey,"int")." And Upload = 'Yes'";
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
        <h2><?php echo $Class2_Name?></h2>
        <div class="site"><?php echo $nav;?></div>
        <?php
      	/***取得線上課程資料***/
		$SQL  = "Select * From course Where intLang = 2 and Upload = 'Yes' And class1_PKey = ".SqlFilter($C_Class1_PKey,"int")." And class2_PKey=".SqlFilter($C_Class2_PKey,"int")." Order By Sort";
		//$SQL .= " And class2_PKey = ".SqlFilter($C_Class2_PKey,"int");
		$rscourselist = new recordset($SQL);
		while (! $rscourselist->eof ){
			$PayExp = "";
			$PayExp = $rscourselist->field("PayExp");
	  ?>
        <div class="course_box">
          <div class="coures_title">
            <p class="i_icon">i</p>
            <? echo $rscourselist->field("strName")?>
          </div>
          <p class="course_info"><?php echo mb_substr($rscourselist->field("intro"), 0, 110,"utf-8")."...";?></p>
          <div class="txt_right"><a href="p3_course_detail3.php?PKey=<? echo authcode($rscourselist->field("PKey"),'ENCODE')?>"><img src="../images/p3/btn_01_en.png?20200406" onMouseOut="this.src='../images/p3/btn_01_en.png?20200406'" onMouseOver="this.src='../images/p3/btn_01b_en.png?20200406'" class="course_btn" /></a>
            <?php //if ( $rscourselist->field("class1_PKey") == 2 ){?>
            <?php if ( ( $rscourselist->field("PeopleNumber1")-$rscourselist->field("PeopleNumber2") > 0 ) && ( strtotime(date("Y/m/d")) < strtotime( $PayExp ) ) ){ ?>
            <a href="p3_course_detail.php?PKey=<? echo authcode($rscourselist->field("PKey"),'ENCODE')?>"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" /></a>
            <?php }?>
            <?php //if ( strtotime(date("Y/m/d")) > strtotime($PayExp) ){echo $PayExp;?>
            <!--<img src="../images/p3/btn_03.png"  class="course_btn" />
					<?php //}else{?>
                		<img src="../images/p3/btn_05.png"  class="course_btn" />-->
            <?php //}?>
            <?php //}?>
            <?php //}?>
          </div>
        </div>
        <?php
      		$rscourselist->movenext();
		}	  
	  ?>
        <!--main-->
      </div>
      <!--container-->
    </div>
    <!--wrapper-->
  </div>
  <?php require("_footer.php"); ?>
</body>

</html>

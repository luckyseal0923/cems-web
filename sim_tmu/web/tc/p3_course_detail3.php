<?php
    require("_inc.php");
	$pageName = "p3";
	$subPageName = "p3_1";
	$subPageName2 = "p3_1_1";
    $nav=$home.$icon.$p3.$icon;
	
	
	
	/***參數解碼***/
	if ($_REQUEST["PKey"] <> ""){
		$Course_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***取得參數資料***/
	$SQL = "Select * From course Where Upload='Yes' And PKey=".SqlFilter($Course_PKey,"int");
	$rs = new recordset($SQL);
	if (! $rs->eof ){
		$Course_PKey = $rs->field("PKey");
		$C_Class1_PKey = $rs->field("class1_PKey");
		$C_Class2_PKey = $rs->field("class2_PKey");
		$strName = $rs->field("strName");
		$strTeacher = $rs->field("strTeacher");
		$OpenDate = $rs->field("OpenDate");
		$EndDate = $rs->field("EndDate");
		$dtCourse_time = $rs->field("dtCourse_time");
		$intLink = $rs->field("intLink");
		$strLink = $rs->field("strLink");
		$FileName = $rs->field("FileName");
		$youtubeID = $rs->field("youtubeID");
		$PayExp = $rs->field("PayExp");
		$contents1 = $rs->field("contents1");
		$contents2 = $rs->field("contents2");
		$contents3 = $rs->field("contents3");
		$contents4 = $rs->field("contents4");
		$contents5 = $rs->field("contents5");
		$PeopleNumber1 = $rs->field("PeopleNumber1");	/*可報名人數*/
		$PeopleNumber2 = $rs->field("PeopleNumber2");	/*已報名人數*/
		$Price = $rs->field("Price");
		
		/*判斷檔案下載連結*/
		if ( $intLink == 1 && $strLink != "" ){
			$href = $strLink;
		}else{
			if ( $FileName != ""){
				$href = "Upload/files/".$FileName;
			}
		}
		
		/*組合課程日期*/
		if ( strtotime($OpenDate) == strtotime($EndDate) ){
			$Course_Date = Date_EN($OpenDate,3);
		}else{
			$Course_Date = Date_EN($OpenDate,3)." ～ ".Date_EN($EndDate,3);
		}
		
		/*取得主類別名稱*/
		$SQL = "Select strName From course_class1 Where PKey = ".SqlFilter($C_Class1_PKey,"int");
		$rsClass1 = new recordset($SQL);
		if (! $rsClass1->eof ){ $Class1_Name = $rsClass1->field("strName");}
		
		/*取得次類別名稱*/
		$SQL = "Select strName From course_class2 Where PKey = ".SqlFilter($C_Class2_PKey,"int");
		$rsClass2 = new recordset($SQL);
		if (! $rsClass2->eof ){ $Class2_Name = $rsClass2->field("strName");}
		
		/*圖片陣列*/
		$Photo = array();
		$PhotoW = array();
		$PhotoH = array();
		for ($i=1;$i<=8;$i++){
			$SQL = "Select * From course_img Where course_PKey=".SqlFilter($Course_PKey,"int")." And Sort=".$i;
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
      <h2><?php echo $Class2_Name;?></h2>
      <div class="site"><? echo $nav.$Class2_Name;?></div>
      <div class="detail_box">
      	<div class="detail_title"><p class="i_icon">i</p><?php echo $strName?></div>
        <div  class="detail_dataBox">
        	<div class="data_area">
        	  <table class="detail_data">
              
              <?php if ( $strTeacher != "" ){?>
                  <tr>
                    <th>授課講師</th>
                    <td><? echo $strTeacher?></td>
                  </tr>
              <?php }?>
              
        	  <?php if ( $Course_Date != "" ){?>
        	    <tr>
        	      <th>上課日期</th>
        	      <td><? echo $Course_Date?></td>
      	      	</tr>
        	  <?php }?>
              
        	  <?php if ( $dtCourse_time != "" ){?>
        	    <tr>
        	      <th>上課時間</th>
        	      <td><? echo $dtCourse_time?></td>
      	      	</tr>
        	  <?php }?>
              
        	  <?php if ( $PayExp > 0 ){?>
        	    <tr>
        	      <th>報名截止日</th>
        	      <td><? echo Date_EN($PayExp,3)?></td>
      	      	</tr>
        	 <?php }?>
      	    </table>
        	  <?php if ( $contents1 != "" ){?>
                <ul>
                	<?php echo $contents1?>
              </ul>
              <?php }?>
        </div>
        
        <div class="flr">
        
        	<?php if ( $C_Class1_PKey == 2 && ( $PeopleNumber1-$PeopleNumber2 > 0 ) && (strtotime(date("Y/m/d")) < strtotime($PayExp)) ){?>
	            <?php if ( $_SESSION["Member_PKey"] != "" ){?>
		            <a href="p4_mem_check.php"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" /></a>
                <?php }else{?>
                	<a href="p4_login.php"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" /></a>
                <?php }?>
            <?php }?>
            
            <?php if ( $href != "" ){?>
	        	<br><a href="<? echo $href?>" target="_blank"><img src="../images/p3/btn_04.png" onMouseOut="this.src='../images/p3/btn_04.png'" onMouseOver="this.src='../images/p3/btn_04b.png'" class="course_btn" /></a>
            <?php }?>
        </div>
            
        </div>
	    <div class="course_detail"><i class="fa fa-square"></i>課程介紹</div>        
        <!--上圖下文-->
        <?php if ( $Photo[4] != "" ){?><div class="detail_box"><img src="../Upload/course/<?php echo $Photo[4];?>"></div><?php }?>
      	<?php if ( $contents2 != "" ){?><div class="detail_box"><?php echo $contents2;?></div><?php }?>
        
        <!--左圖右文-->
        <div class="detail_box">
        	<?php if ( $Photo[5] != "" ){?><div class="detail_t"><img src="../Upload/course/<?php echo $Photo[5];?>" width="100%"></div><?php }?>
        	<?php if ( $contents3 != "" ){?><div class="detail_r"><?php echo $contents3;?></div><?php }?>
        </div>
        
        <!--右圖左文-->
        <div class="detail_box">
        	<?php if ( $contents4 != "" ){?><div class="detail_t2"><?php echo $contents4;?></div><?php }?>
        	<?php if ( $Photo[6] != "" ){?><div class="detail_r2"><img src="../Upload/course/<?php echo $Photo[6];?>" width="100%"></div><?php }?>
        </div>
        
        <!--下圖上文-->
        <?php if ( $contents5 != "" ){?><div class="detail_box"><?php echo $contents5;?></div><?php }?>
      	<?php if ( $Photo[7] != "" ){?><div class="detail_box"><img src="../Upload/course/<?php echo $Photo[7];?>"></div><?php }?>
        
        <?php if ( $Photo[0] != "" ){?><div class="detail_box"><img src="../Upload/course/<?php echo $Photo[0];?>"></div><?php }?>
        <?php if ( $Photo[1] != "" ){?><div class="detail_box"><img src="../Upload/course/<?php echo $Photo[1];?>"></div><?php }?>
        
        <!--youtube-->
        <?php if ( $youtubeID != "" ){?>
	      	<div class="detail_box"><iframe width="690" height="388" src="https://www.youtube.com/embed/<? echo $youtubeID?>" frameborder="0" allowfullscreen></iframe></div>
        <?php }?>    
      	<div class="back_btn"><a href="javascript:history.back()">上一頁</a></div>
        
      </div>   
      </div>
  </div>
</div>
<?php require("_footer.php"); ?>
</body>
</html>
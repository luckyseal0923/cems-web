<?php
    require("_inc.php");
	$pageName = "p3";
	$subPageName = "p3_1";
	$subPageName2 = "p3_1_1";
    $nav=$home.$icon.$p3.$icon.$p3_1;
	
	$Cond = " Where intLang = 2 and OpenDate <=Now() AND EndDate >= Now() ";
	
	/***參數解碼(課程PKey)***/
	if ($_REQUEST["PKey"] <> ""){
		
		$Course_PKey = authcode($_REQUEST["PKey"],'DECODE');		
		
		/*取得課程明細*/
		$SQL = "Select * From course Where PKey = ".SqlFilter($Course_PKey,"int");
		$rsdetail = new recordset($SQL);
		if (! $rsdetail->eof ){
			$Course_PKey = $rsdetail->field("PKey");
			$C_Class1_PKey = $rsdetail->field("class1_PKey");
			$C_Class2_PKey = $rsdetail->field("class2_PKey");
			$strName = $rsdetail->field("strName");
			$strTeacher = $rsdetail->field("strTeacher");
			$contents1 = $rsdetail->field("contents1");
			$OpenDate = $rsdetail->field("OpenDate");
			$EndDate = $rsdetail->field("EndDate");
			$PayExp = $rsdetail->field("PayExp");
			$youtubeID = $rsdetail->field("youtubeID");
			$dtCourse_time = $rsdetail->field("dtCourse_time");
			$intLink = $rsdetail->field("intLink");
			$strLink = $rsdetail->field("strLink");
			$FileName = $rsdetail->field("FileName");
			$PeopleNumber1 = $rsdetail->field("PeopleNumber1");	/*可報名人數*/
			$PeopleNumber2 = $rsdetail->field("PeopleNumber2");	/*已報名人數*/
			$Price = $rsdetail->field("Price");
			$PayExp = $rsdetail->field("PayExp");
			
			/*判斷檔案下載連結*/
			if ( $intLink == 1 ){
				$href = $strLink;
			}else{
				$href = "Upload/files/".$FileName;
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
			
			/*取得圖片陣列*/
			$Photo = array();
			$PhotoW = array();
			$PhotoH = array();
			for ($i=1;$i<=2;$i++){
				$SQL = "Select Photo1, PhotoW1, PhotoH1 From course_img Where Course_PKey=".SqlFilter($Course_PKey,"int")." And Sort=".$i;
				$rs = new recordset($SQL);
				if (! $rs->eof){
					/*前台縮圖*/
					$imgSize = ReSizeImg('Upload/course/'.$rs->field("Photo1"),690,300);
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
			echo "alert('無此課程資料!');";
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
      <h2>
        <? echo $Class2_Name?>
      </h2>
      <div class="site"><? echo $nav;?></div>
      <div class="detail_box">
        <div class="detail_title">
          <p class="i_icon">i</p>
          <? echo $strName?></div>
        <div  class="detail_dataBox">
          <table class="detail_data">
            <tr>
              <th>授課講師</th>
              <td><? echo $strTeacher?></td>
            </tr>
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
            <?php if ( $C_Class1_PKey == 2 ){?>
                <tr>
                  <th>報名人數限制</th>
                  <td><? echo $PeopleNumber1?></td>
                </tr>
                <tr>
                  <th>報名截止日</th>
                  <td><? echo Date_EN($PayExp,3)?></td>
                </tr>
                <tr>
                  <th>報名費用</th>
                  <td><? echo number_format($Price,0)?></td>
                </tr>
            <?php }?>
          </table>
          <div class="flr">
          	<?php if ( $C_Class1_PKey == 2 && ( $PeopleNumber1-$PeopleNumber2 > 0 ) && (strtotime(date("Y/m/d")) < strtotime($PayExp)) ){?>
                <?php if ( $_SESSION["Member_PKey"] != "" ){?>
	                <a href="p4_mem_check.php?PKey=<? echo authcode($Course_PKey,'ENCODE')?>">
                <?php }else{?>
                    <a href="p4_login.php">
                <?php }?>
                
                <img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" /></a>
                <br>
            <?php }?>
            <?php if ( $intLink != 0 ){ /*判斷是否有檔案下載*/?>
	            <a href="<? echo $href?>" target="_blank"><img src="../images/p3/btn_04.png" onMouseOut="this.src='../images/p3/btn_04.png'" onMouseOver="this.src='../images/p3/btn_04b.png'" class="course_btn" /></a> 
            <?php }?>
          </div>
        </div>
        <div class="course_detail"><i class="fa fa-square"></i>課程介紹</div>
        <?php if ( $Photo[0] != "" ){?>
        	<div class="detail_box"><img src="../Upload/course/<? echo $Photo[0]?>" width="690"></div>
         <?php }?>
        <!----編輯器----->
        <div class="detail_box"><? echo $contents1?></div>
        <?php if ( $Photo[1] != "" ){?>
	        <div class="detail_box"><img src="../Upload/course/<? echo $Photo[1]?>" width="690"></div>
        <?php }?>
        <!----編輯器----->
        <?php if ( $youtubeID != "" ){?>
            <div class="detail_box">
              <iframe width="690" height="388" src="https://www.youtube.com/embed/<? echo $youtubeID?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php }?>
        <div class="back_btn"><a href="javascript:history.back()">上一頁</a></div>
      </div>
      <!--detail_box-->
      <!--main-->
    </div>
    <!--container-->
  </div>
  <!--wrapper-->
</div>
<?php require("_footer.php"); ?>
</body>
</html>
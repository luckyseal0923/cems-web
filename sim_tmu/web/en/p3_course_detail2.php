<?php
    require("_inc.php");
	$pageName = "p3";
	$subPageName = "p3_1";
	$subPageName2 = "p3_1_1";
    $nav=$home.$icon.$p3.$icon.$p3_1;
	
	
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
<link rel="stylesheet" href="../css/style.css">
</head>

<body <?php echo $bodytxt; ?>>

<div id="wrapper">
  <?php require("_menu.php"); ?>
  <?php require("_header.php"); ?>
  <div class="container clearfix">
      
	  <?php require("_sidebar.php"); ?>
      
      <div class="main">
      <h2><?php echo $p3_1_1;?></h2>
      <div class="site"><? echo $nav;?></div>
      <div class="detail_box">
      	<div class="detail_title"><p class="i_icon">i</p>身體檢查評估與檢驗判讀</div>
        <div  class="detail_dataBox">
            <table class="detail_data">
            	  <tr>
                    <th>授課講師</th>
                    <td>XXX</td>
                  </tr>
                  <tr>
                    <th>上課日期</th>
                    <td>2016.01.02</td>
                  </tr>
                  <tr>
                    <th>上課時間</th>
                    <td>早上10:00~12:00</td>
                  </tr>
                  <tr>
                    <th>報名截止日</th>
                    <td>2015.12.31</td>
                  </tr>
                  <tr>
                    <th>報名人數限定</th>
                    <td>20</td>
                  </tr>
                  <tr>
                    <th>報名費用</th>
                    <td>10000</td>
                  </tr>
                </table>
            <div class="flr"><a href="p4_mem_check.php"><img src="../images/p3/btn_02.png" onMouseOut="this.src='../images/p3/btn_02.png'" onMouseOver="this.src='../images/p3/btn_02b.png'" class="course_btn" /></a>
            <br><a href="#" target="_blank"><img src="../images/p3/btn_04.png" onMouseOut="this.src='../images/p3/btn_04.png'" onMouseOver="this.src='../images/p3/btn_04b.png'" class="course_btn" /></a>
            </div>
        </div>
        
        <div class="course_detail"><i class="fa fa-square"></i>課程介紹</div>
        <div class="detail_box"><img src="../images/p1/01.jpg"></div><!----編輯器----->
      	<div class="detail_box"><!----編輯器----->
      	工作內容簡介<br>1.協調各系所借用模擬教學空間和模具<br>2.協助各系所準備模擬教學所需物品
      	<br>3.整合協調各系所模擬課程進度，提報教學卓越計畫<br>4.協助教卓計畫經費核銷<br><br>
		學校員工福利<br>
		三節禮金及生日禮券、員工海內外旅遊補助、免費選修校內課程、免費健康檢查、員工及眷屬就醫優待、子女獎學金、福利互助(結婚、生育、離退、住院、喪葬補助…)</div>
      	<div class="detail_box"><img src="../images/p1/01.jpg"></div><!----編輯器----->
      	<div class="detail_box"><iframe width="690" height="388" src="https://www.youtube.com/embed/gdUG2NfYv3E" frameborder="0" allowfullscreen></iframe></div>
      	<div class="back_btn"><a href="javascript:history.back()">上一頁</a></div>
        
      </div><!--detail_box-->
   
      <!--main-->
      </div>
  
  
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
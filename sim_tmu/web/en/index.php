<?php

	require("_inc.php");
	$pageName = "index";
	
	//exit;
	
	//$Cond = " Where OpenDate <=Now() AND EndDate >= Now() ";
	$Cond = " Where intLang = 2 and datediff(OpenDate,'".date("Y/m/d")."')<= 0 and datediff(EndDate,'".date("Y/m/d")."')>=0";
	
	$year = date("Y");
	$mon = date("m");

	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Car_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	if ($_REQUEST["intYear"] >= $year){
		$year = $_REQUEST["intYear"];
	}
	
	if ($_REQUEST["intMonth"] > 0 && $_REQUEST["intMonth"] < 13){
		$mon = $_REQUEST["intMonth"];
	}
	
	$timetemp = mktime(12,0,0,$mon,1,$year); 
	$day1 = date("j",$timetemp);//該月之月初(日) 
	$day2 = date("t",$timetemp);//該月天數 
	$day3 = date("w",$timetemp);//月初為星期幾
	$day4 = date("Y/m/d",$timetemp);//月初日期
	
	//取出上下月份日期
	$up_date = add_date($day4,0,-1,0);
	$next_date = add_date($day4,0,1,0);
	$days = array();
	//if($day3 == 0) { $day3 = 7; } 
	for($i=1;$i<=$day3;$i++) { 
		array_push($days,"");
	}
	
	for($j=1;$j<=$day2;$j++) { 
		array_push($days,$j);
	}
	
	/***取得新聞資料(科系活動)***/
	$SQL = "Select PKey,strName,OpenDate From news $Cond And class1_PKey = 3 And showIndex = '1' Order By OpenDate Desc, Sort Limit 1";
	$rsnews = new recordset($SQL);
	if (! $rsnews->eof ){
		$News_PKey1 = $rsnews->field("PKey");
		$News_Name1 = $rsnews->field("strName");
		$OpenDate1 = $rsnews->field("OpenDate");
	}
	
	if ( $_POST["Send"] == 'OK' ){
		
		/*表單檔案驗證*/
		$MSG = "";
		
		/*判斷帳號*/
		if (strLen($_POST['strID']) == ""){
			$MSG .= "Enter your account\\n";
		}
			
		/*判斷密碼*/
		$regexp = "/^[A-Za-z0-9._-]{6,20}$/";
		if (! preg_match($regexp,$_POST['strPW'])) {
			$MSG .= "Enter your password\\n";
		}
		
		/*判斷帳號密碼*/
		if ( $MSG == "" ){
			
			/*判斷資料庫是否有此帳號密碼*/
			$SQL = "Select * From member Where strID = '".SqlFilter($_POST['strID'],"tab")."' And strPW = '".SqlFilter($_POST['strPW'],"tab")."'";
			$rs = new recordset($SQL);
			if (! $rs->eof ){
				$_SESSION['Member_PKey'] = $rs->field("PKey");
				$_SESSION['Member_Name'] = $rs->field("strName");
				echo "<script language=\"javascript\">" ;
				echo "alert('Login suceesfully');" ;
				echo "location.href='p4_member.php';" ;
				echo "</script>" ;
				exit() ;

			}else{
				echo "<script language=\"javascript\">" ;
				echo "alert('No account password found, please re-enter!');" ;
				echo "location.href='p4_login.php';" ;
				echo "</script>" ;
				exit() ;
			}
		}else{
			echo "<script language=\"javascript\">" ;
			echo "alert('An error occurred, please confirm the following fields\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			exit;
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
  <?php require("_in_code_head.php"); ?>
  <meta charset="utf-8">
  <title>
    <?php echo $pageTitle;?>
  </title>
  <meta name="description" content="<?php echo $m_description;?>" />
  <meta name="keywords" content="<?php echo $m_keywords;?>" />
  <meta name="Robots" content="all" />
  <?php require("_in_javascript.php"); ?>
  <!-- Start WOWSlider.com HEAD section -->
  <!-- add to the <head> of your page 
<link rel="stylesheet" type="text/css" href="engine1/style.css" />
<script type="text/javascript" src="engine1/jquery.js"></script>
<!-- End WOWSlider.com HEAD section -->
  <script>
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        navigation: false, // Show next and prev buttons
        autoPlay: 6000,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true
      });
    });

  </script>
  <script>
    $(document).ready(function() {
      //Examples of how to assign the Colorbox event to elements
      $(".group1").colorbox({
        rel: 'group1'
      });
      $("#click").click(function() {
        $('#click').css({
          "background-color": "#f00",
          "color": "#fff",
          "cursor": "inherit"
        }).text("Open this window again and this message will still be here.");
        return false;
      });
    });

  </script>
  <script language="JavaScript" type="text/javascript">
    /*判斷表單欄位*/
    function sbForm() {
      var theForm = document.form1;
      if (fieldCheck0(theForm)) {
        theForm.Send.value = "OK";
        theForm.submit();
      }
    }
    /*-----------------------------------------*/
    function fieldCheck0(theForm) {

      /*判斷帳號*/
      if (theForm.strID.value == "") {
        alert("【帳號】請勿空白!");
        theForm.strID.focus();
        return false;
      }

      /*判斷密碼*/
      var reg = /^[a-z0-9]{6,20}$/ig;
      if (!reg.test(theForm.strPW.value)) {
        alert("【密碼】請輸入正確密碼!!");
        theForm.strPW.focus();
        return false;
      }
      return true;
    }

  </script>
</head>

<body <?php echo $bodytxt; ?>>
  <?php require("_menu.php"); ?>
  <?php require("_banner.php") ?>
  <div class="container">
    <div class="container_left">
      <div class="style_box3">
        <div class="box3_title"><span class="title_news">News</span>
          <div class="news_btn2"><a href="p1_news.php?C1_PKey=<? echo authcode(2,'ENCODE')?>">MORE</a></div>
        </div>
        <div class="style_boxImg2"><img src="../images/all/triangle2.png"></div>
        <?php
            /***取得新聞資料(中心活動)***/
            $SQL = "Select * From news $Cond And class1_PKey = 4 And showIndex = '1' Order By OpenDate Desc, Sort Limit 4";
            $rsnews = new recordset($SQL);
            while (! $rsnews->eof ){          
                $Photo1 = "";
                /*取得新聞圖片*/
                $SQL = "Select * From news_img Where News_PKey = ".$rsnews->field("PKey")." And Photo1 <> '' Order By Sort Limit 1";
                $rsnewsimg = new recordset($SQL);
                if (! $rsnewsimg->eof ){
                    $Photo1 = $rsnewsimg->field("Photo1");
                }
        ?>
        <div class="list_box">
          <div class="list_date"><span>
              <? echo date("d",strtotime($rsnews->field("OpenDate")));?></span><br>
            <?php echo date("M",strtotime($rsnews->field("OpenDate")))?></div>
          <?php if ( $Photo1 != "" ){?>
          <div class="list_left"><img src="../Upload/news/<? echo $Photo1?>" width="80" height="64"></div>
          <?php }?>
          <div class="list_left">
            <p><a href="p1_news_detail.php?PKey=<? echo authcode($rsnews->field("PKey"),'ENCODE')?>">
                <? echo $rsnews->field("strName")?></a></p>
          </div>
        </div>
        <?php
                $rsnews->movenext();
            }
        ?>
        <!--style_box3-->
      </div>
      <div class="index_activity">
        <!--會員登入-->
        <!--<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit='if (fieldCheck0(this)) {return true; login(this);} else {return false;}'>
          <div class="style_box4 main_color member_area"> <img src="../images/all/member_en.png">
            <input name="strID" id="strID" class="input" type="text" placeholder="account">
            <input name="strPW" id="strPW" class="input" type="text" placeholder="password">
            <div class="login_btn"><a href="javascript:sbForm();">Login</a></div>
          </div>
          <input type="hidden" name="Send">
        </form>入-->
        <!--contact-->
        <div class="style_box"><a href="p9_contact.php" target="_blank" class="share-circle3 fb"><img src="../images/all/contact_en.png"></a></div>
        <div class="style_boxImg3"><img src="../images/all/triangle.png"></div>    
        <!--fb-->
        <div class="style_box"><a href="https://www.facebook.com/CEMSTMU/?success=1" target="_blank" class="share-circle3 fb"><img src="../images/all/fb_en.jpg"></a></div>
        <div class="style_boxImg3"><img src="../images/all/triangle.png"></div>
      </div>
      <!--container_left-->
    </div>
    <div class="container_right">
      <!--youtube-->
      <div class="style_box2 youtube_h">
        <iframe width="504" height="260" src="https://www.youtube.com/embed/hw2Ss_VYdCY?rel=0" frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="index_activity2">
        <!--中心活動-->
        <div class="style_box main_color box_w">
          <div class="news_txt2"><?php echo $p1_1?>
            <div class="news_btn"><a href="p1_news.php?C1_PKey=<? echo authcode(1,'ENCODE')?>">MORE</a></div>
          </div>
        </div>
        <div class="style_box news_data box_w">
          <div class="news_date">
            <p class="date_txt">
              <? echo Date_En($OpenDate1,1)?>
            </p>
            <p><a href="p1_news_detail.php?PKey=<? echo authcode($News_PKey1,'ENCODE')?>">
                <? echo $News_Name1?></a></p>
          </div>
        </div>
        <div class="style_boxImg"><img src="../images/all/triangle.png"></div>
        <!--index_activity2-->
      </div>
      <!--場地租借-->
      <div class="style_box2 calendar_box">
        <table>
          <tr>
            <td width="234">
              <div class="calendar_area">
                <div class="title"><?php echo $p5?></div>
                <p class="date">
                  <? echo date("m")?>/
                  <? echo date("d")?>
                </p>
                <p class="calendar_txt">CALENDAR</p>
              </div>
            </td>
            <td width="242" class="calendar_style">
              <form id="form2" name="form2" method="post" action="<? echo $_SERVER['PHP_SELF']?>">
                <table class="calendar">
                  <tr>
                    <th colspan="7">
                      <? echo $year ?>/
                      <? echo $mon ?>/</th>
                  </tr>
                  <tr class="calendar_w">
                    <?php 
                      $i = 0;
                      for ($k=1;$k < 8;$k++){ ?>
                    <td>
                      <? echo weekname($k)?>
                    </td>
                    <?php }?>
                  </tr>
                  <?php /***日期***/ for($w=1;$w<7;$w++){ ?>
                  <tr>
                    <?php for ($k=1;$k < 8;$k++){ 
                            $className = "";
                            /*背景色*/
                            if ( date("Y")==$year && date("m")==$mon && date("d")==$days[$i] ){ $className = " class=\"red_txt red_bg\""; }
                            if ( $k == 1 || $k == 7 ){ $className = " class=\"red_txt\""; }
                        ?>
                    <td id="li_<? echo $days[$i]?>" <? echo $className?>>
                      <?php
                            if ($days[$i] != ""){ 
                                echo $days[$i];
                                $thisDate = date("Y/m/d",mktime(0,0,0,$mon,$days[$i],$year));
                            }
                        ?>
                    </td>
                    <?php
                      $i++;
                      /*if ($days[$i]=="" && $i > 20)
                       break;*/
                       }//for ($k=1;$k < 8;$k++){
                  ?>
                  </tr>
                  <?php
                    if ($days[$i]=="" && $i > 20)
                        break;
                    }//for($w=1;$w<7;$w++)
                ?>
                </table>
              </form>
            </td>
          </tr>
        </table>
        <!--calendar_box-->
      </div>
    </div>
    <!--container-->
  </div>
  <?php require("_footer.php"); ?>
</body>

</html>

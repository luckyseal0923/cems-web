<?php
    require("_inc.php");
	$pageName = "p5";
	$subPageName = "p5_3";
    $nav=$home.$icon.$p5;
	
	
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
<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
								
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<script language="JavaScript" type="text/javascript">
/*-----------------------------------------*/
	//偵測Form裡的各欄位----^_^
	function sbForm(){
		var theForm = document.chkForm;
		if(fieldCheck0(theForm)){
		  theForm.Send.value ="OK";
		  theForm.submit();
		}
	}
	/*-----------------------------------------*/
	function fieldCheck0(theForm) {	
		/*====================================*/	
		if (theForm.C_unit.value == ""){
			alert("【單位】空白"); 
			theForm.C_unit.focus();
		return false;}	
		/*====================================*/
		if (theForm.C_name.value == ""){
			alert("【連絡人】空白"); 
			theForm.C_name.focus();
		return false;}	
		/*====================================*/
		var reg = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+$/i;
		if (!reg.test(theForm.C_email.value)){
			alert("【電子信箱】空白或格式錯誤"); 
			theForm.C_email.focus();
		return false;}	
		/*====================================*/	
		if (theForm.C_tel.value == ""){
			alert("【聯絡電話】空白"); 
			theForm.C_tel.focus();
		return false;}	
		
		/*====================================*/
		if (theForm.C_message.value == ""){
			alert("【說明】空白"); 
			theForm.C_message.focus();
		return false;}	
        /*====================================*/    
		
		return true;
	}
	/*-----------------------------------------*/
</script>
</head>

<body <?php echo $bodytxt; ?>>

<div id="wrapper">
  <?php require("_menu.php"); ?>
  <?php require("_header.php"); ?>
  <div class="container clearfix">
      
	  <?php require("_sidebar.php"); ?>
      
      <div class="main">
      <h2><?php echo $p5_3;?></h2>
      <div class="site"><? echo $nav;?></div>
      <h3 class="title2">線上場地租借</h3>
        <form method="post" action="#" name="chkForm" id="chkForm"  onsubmit="document.chkForm.Page.value=1">
      	<table class="rental_box">
          <tr>
            <th>租借教室</th>
            <td colspan="3"><select name="C_classroom" id="C_classroom" class="c_select">
            	<option>模擬診間(一)</option>
                <option>模擬診間(二)</option>
                <option>模擬診間(三)</option>
                <option>模擬診間(四)</option>
                <option>模擬診間(五)</option>
                <option>模擬診間(六)</option>
                <option>模擬診間(七)</option>
                <option>模擬診間(八)</option>
                <option>操作教室(一)</option>
                <option>操作教室(二)</option>
                <option>操作教室(三)</option>
                <option>討論室</option>
                <option>教學教室</option>
                <option>模擬加護病房</option>
                <option>模擬開刀房</option>
            </select></td>
          </tr>
          <tr>
            <th>租借日期</th>
            <td><select name="C_year" id="C_year" class="c_select">
            	<option>2015</option>
                <option>2016</option>
                </select>年
                <select name="C_month" id="C_month" class="c_select">
            	<option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
                <option>05</option>
                <option>06</option>
                <option>07</option>
                <option>08</option>
                <option>09</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                </select>月
                <select name="C_day" id="C_day" class="c_select">
            	<option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
                <option>05</option>
                <option>06</option>
                <option>07</option>
                <option>08</option>
                <option>09</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>13</option>
                <option>14</option>
                <option>15</option>
                <option>16</option>
                <option>17</option>
                <option>18</option>
                <option>19</option>
                <option>20</option>
                <option>21</option>
                <option>22</option>
                <option>23</option>
                <option>24</option>
                <option>25</option>
                <option>26</option>
                <option>27</option>
                <option>28</option>
                <option>29</option>
                <option>30</option>
                </select>日
            </td>
            <th>租借時段</th>
            <td><select name="C_time" id="C_time" class="c_select">
            	<option>08:00~12:00 AM</option>
                <option>13:00~17:00 PM</option>
                <option>18:00~22:00 PM</option>
                </select>
            </td>
          </tr>
          <tr>
            <th>單位</th>
            <td><input name="C_unit" type="text"  class="c_input" id="C_unit" size="20" onclick="javascript:this.value='';"  /></td>
            <th>聯絡人</th>
            <td><input name="C_name" type="text"  class="c_input" id="C_name" size="20" onclick="javascript:this.value='';"  /></td>
          </tr>
          <tr>
            <th>E-mail</th>
            <td><input name="C_email" type="text"  class="c_input" id="C_email" size="20" onclick="javascript:this.value='';"  /></td>
            <th>電話</th>
            <td><input name="C_tel" type="text"  class="c_input" id="C_tel" size="20" onclick="javascript:this.value='';"  /></td>
          </tr>
          <tr>
            <th>說明</th>
            <td colspan="3"><textarea name="C_message" id="C_message" class="c_message" required></textarea></td>
          </tr>
        </table>
        <div class="back_btn"><a  href="javascript:sbForm(); " onMouseOut="MM_swapImgRestore()">確定送出</a></div>
        </form>
        <div class="line"></div>
      
      
<!--      <div class="rental_btn flr"><a href="#rental">我要租借</a></div>
-->    
	  <table class="classroom_month">
          <tr>
            <td><div class="news_btn"><a href="#"><i class="fa fa-arrow-circle-left"></i>&ensp;上個月</a></div></td>
            <td>2015年12月</td>
            <td><div class="news_btn"><a href="#">下個月&ensp;<i class="fa fa-arrow-circle-right"></i></a></div></td>
          </tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="0" class="classroom_date">
          <tr>
            <th>日</th>
            <th>一</th>
            <th>二</th>
            <th>三</th>
            <th>四</th>
            <th>五</th>
            <th>六</th>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>1<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>2<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>3<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>4<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>5<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
          </tr>
          <tr>
            <td>6<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>7<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>8<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>9<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>10<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>11<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>12<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
          </tr>
          <tr>
            <td>13<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>14<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>15<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>16<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>17<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>18<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>19<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
          </tr>
          <tr>
            <td>20<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>21<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>22<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>23<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>24<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>25<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>26<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
          </tr>
          <tr>
            <td>27<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>28<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>29<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>30<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>31<br><a href="p5_classroom_list.php" class="group1 classroom_txt">場地狀態&ensp;<i class="fa fa-search"></i></a></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <!--<a name="rental"></a>-->
		
      <!--main-->
      </div>
      
  <!--container-->
  </div>
  
<!--wrapper-->
</div>


<?php require("_footer.php"); ?>
</body>
</html>
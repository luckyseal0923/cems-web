<div id="menu">
  <?
  if($mainitem!="index"){
	$Left_Menu = explode(",",$_SESSION["FunctionID"]);
  ?>
  <div id="menuarea">
    <!--廣告管理-->
    <? if (in_array('1',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../ad/list.php" class="<? if($mainitem=="m1"){echo "menu2";}?>"><? echo $m1.$mgw1;?></a>
    <? }?>
	<!--最新消息管理-->
    <? if (in_array('2',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../news/list.php" class="<? if($mainitem=="m2"){echo "menu2";}?>"><? echo $m2.$mgw1;?></a>
    <div class="submenu" id="ans1"  style=" <? if($mainitem=="m2"){echo "display:block";}else{echo "display:".$divview;}?>">
      <!--最新消息-->
      <a href="../news/list.php" class="<? if($subitem=="m21"){echo "on2";}?>"><? echo $m21.$mgw1 ?></a>
      <!--最新消息-->
      <a href="../news2/list.php" class="<? if($subitem=="m23"){echo "on2";}?>"><? echo $m23.$mgw1 ?></a>
      <!--類別-->
      <a href="../newsclass/list.php" class="<? if($subitem=="m22"){echo "on2";}?>"><? echo $m22.$mgw1 ?></a>
    </div>
    <? }?>
	<!--專題文章管理-->
    <? if (in_array('3',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../paper/list.php" class="<? if($mainitem=="m3"){echo "menu2";}?>"><? echo $m3.$mgw1;?></a>
    <div class="submenu" id="ans1"  style=" <? if($mainitem=="m3"){echo "display:block";}else{echo "display:".$divview;}?>">
      <!--週刊專欄-->
      <a href="../paper/list.php" class="<? if($subitem=="m31"){echo "on2";}?>"><? echo $m31.$mgw1 ?></a>
      <!--週刊類別-->
      <a href="../paperclass/list.php" class="<? if($subitem=="m32"){echo "on2";}?>"><? echo $m32.$mgw1 ?></a>
	  <!--週刊作者-->
      <a href="../author/list.php" class="<? if($subitem=="m33"){echo "on2";}?>"><? echo $m33.$mgw1 ?></a>
	  <!--週刊書籤-->
      <a href="../bookmark/list.php" class="<? if($subitem=="m34"){echo "on2";}?>"><? echo $m34.$mgw1 ?></a>
    </div>
    <? }?>
	<!--會員管理-->
    <? if (in_array('4',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../member/list.php" class="<? if($mainitem=="m4"){echo "menu2";}?>"><? echo $m4.$mgw1;?></a>
    <? }?>
	<!--書籍商品管理-->
    <? if (in_array('5',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../class1/list.php" class="<? if($mainitem=="m5"){echo "menu2";}?>"><? echo $m5.$mgw1;?></a>
    <div class="submenu" id="ans1"  style=" <? if($mainitem=="m5"){echo "display:block";}else{echo "display:".$divview;}?>">
      <!--類別管理-->
      <a href="../class1/list.php" class="<? if($subitem=="m51"){echo "on2";}?>"><? echo $m51.$mgw1 ?></a>
      <!--系列管理-->
      <a href="../class2/list.php" class="<? if($subitem=="m52"){echo "on2";}?>"><? echo $m52.$mgw1 ?></a>
	  <!--項目管理-->
      <a href="../class3/list.php" class="<? if($subitem=="m53"){echo "on2";}?>"><? echo $m53.$mgw1 ?></a>
	  <!--書籍產品管理-->
      <a href="../books/list.php" class="<? if($subitem=="m54"){echo "on2";}?>"><? echo $m54.$mgw1 ?></a>
      <!--零售產品管理-->
      <a href="../sale/list.php" class="<? if($subitem=="m55"){echo "on2";}?>"><? echo $m55.$mgw1 ?></a>
	  <!--一般產品管理-->
      <a href="../product/list.php" class="<? if($subitem=="m56"){echo "on2";}?>"><? echo $m56.$mgw1 ?></a>
	  <!--庫存管理-->
      <!-- <a href="m5-7.php" class="<? if($subitem=="m57"){echo "on2";}?>"><? echo $m57.$mgw1 ?></a>-->
    </div>
    <? }?>
	<!--FAQ管理-->
    <? if (in_array('6',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../faq/list.php" class="<? if($mainitem=="m6"){echo "menu2";}?>"><? echo $m6.$mgw1;?></a>
    <div class="submenu" id="ans1"  style=" <? if($mainitem=="m6"){echo "display:block";}else{echo "display:".$divview;}?>">
      <!--FAQ專欄-->
      <a href="../faq/list.php" class="<? if($subitem=="m61"){echo "on2";}?>"><? echo $m61.$mgw1 ?></a>
      <!--FAQ類別-->
      <a href="../faqclass/list.php" class="<? if($subitem=="m62"){echo "on2";}?>"><? echo $m62.$mgw1 ?></a>
    </div>
    <? }?>
	<!--訂閱電子報管理-->
    <? if (in_array('7',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../epaper/list.php" class="<? if($mainitem=="m7"){echo "menu2";}?>"><? echo $m7.$mgw1;?></a>
    <? }?>
	<!--問卷調查管理-->
    <? if (in_array('8',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../quaction/m8-1.php" class="<? if($mainitem=="m8"){echo "menu2";}?>"><? echo $m8.$mgw1;?></a>
    <? }?>
	<!--公司簡介管理-->
    <? if (in_array('9',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../company/list.php" class="<? if($mainitem=="m9"){echo "menu2";}?>"><? echo $m9.$mgw1;?></a>
    <? }?>
	<!--品牌管理-->
    <? if (in_array('10',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../brand/list.php" class="<? if($mainitem=="m10"){echo "menu2";}?>"><? echo $m10.$mgw1;?></a>
    <? }?>
	<!--訂單管理-->
    <? if (in_array('11',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../order/list.php" class="<? if($mainitem=="m11"){echo "menu2";}?>"><? echo $m11.$mgw1;?></a>
    <? }?>
	<!--物流報表管理-->
    <? if (in_array('12',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../hct/list.php" class="<? if($mainitem=="m12"){echo "menu2";}?>"><? echo $m12.$mgw1;?></a>
    <? }?>
	<!--物流報表管理-->
    <? if (in_array('13',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../seven/list.php" class="<? if($mainitem=="m13"){echo "menu2";}?>"><? echo $m13.$mgw1;?></a>
    <? }?>
	<!--活動相簿管理-->
    <? if (in_array('14',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../album/list.php" class="<? if($mainitem=="m14"){echo "menu2";}?>"><? echo $m14.$mgw1;?></a>
    <? }?>
	<!--檔案下載管理-->
    <? if (in_array('15',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
    <a href="../filedown/list.php" class="<? if($mainitem=="m15"){echo "menu2";}?>"><? echo $m15.$mgw1;?></a>
    <? }?>
    <!--權限管理-->
    <? if (in_array('99',$Left_Menu) OR $_SESSION["Login_ID"] == "Admin"){?>
	<a href="../control/list.php" class="<? if($mainitem=="s2"){echo "menu2";}?>"><? echo $s2.$mgw1;?></a><?}?>
    <!--變更密碼-->
    <a href="../control/chgpw.php" class="<? if($mainitem=="s1"){echo "menu2";}?>">變更密碼</a>
    <!--menuarea end-->
  </div>
  <? }else{?>
  <div style="width:180px;height:5px;"></div>
  <? }?>
  <!--menu end-->
</div>

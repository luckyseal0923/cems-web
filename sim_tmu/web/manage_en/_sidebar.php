<div class="m-sidebar">
  <div class="m-user">
    <div class="m-logo"><img src="../images/logo.png" /></div>
    <?php
        if($mainitem!="index"){echo "<p>".$_SESSION["UserName"].", 你好</p>";}
    ?>
  </div>
  <!-- end user -->
  <?php
    if($mainitem!="index"){
      $Left_Menu = explode(",",$_SESSION["FunctionID"]);
    ?>
    
  <ul class="m-nav">
      
    <!--最新消息管理-->
    <? if (in_array('1',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m1'){echo 'class="active"';}?>> <a href="../news_class2/list.php"><i class="fa fa-cog"></i><?php echo $m1.$mgw1;?> </a>
		<div class="m-subnav"> <i class="fa fa-angle-down"></i>
		<a href="../news_class2/list.php"<?php if($subitem=="m11"){echo " class='active'";}?>><i class="fa fa-list"></i><?php echo $m11.$mgw4;?></a>
		<a href="../news/list.php"<?php if($subitem=="m12"){echo " class='active'";}?>><i class="fa fa-list"></i><?php echo $m12.$mgw4;?></a>
	   	</div>
    </li>
    <?php } ?>
    
    <!--課程資訊管理-->
    <? if (in_array('2',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m2'){echo 'class="active"';}?>> <a href="../course_class2/list.php"><i class="fa fa-cog"></i><?php echo $m2.$mgw1;?> </a>
		<div class="m-subnav"> <i class="fa fa-angle-down"></i>
		<a href="../course_class2/list.php"<?php if($subitem=="m21"){echo " class='active'";}?>><i class="fa fa-list"></i> <?php echo $m21.$mgw4;?></a>
		<a href="../course/list.php"<?php if($subitem=="m22"){echo " class='active'";}?>><i class="fa fa-list"></i> <?php echo $m22.$mgw4;?></a>
		<a href="../apply/list.php"<?php if($subitem=="m23"){echo " class='active'";}?>><i class="fa fa-list"></i> <?php echo $m23.$mgw1;?></a>
	   	</div>    
    </li>
    <?php } ?>

    <!--會員資料-->
    <? if (in_array('3',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m3'){echo 'class="active"';}?>> <a href="../member/list.php"><i class="fa fa-cog"></i><?php echo $m3.$mgw1;?> </a>
    </li>
    <?php } ?>
    
    <!--場地租借-->
    <? if (in_array('4',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m4'){echo 'class="active"';}?>> <a href="../rental/list.php"><i class="fa fa-cog"></i><?php echo $m4.$mgw1;?> </a>
    </li>
    <?php } ?>
    
    <!--FAQ-->
    <? if (in_array('5',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m5'){echo 'class="active"';}?>> <a href="../faq/list.php"><i class="fa fa-cog"></i><?php echo $m5.$mgw1;?> </a>
    </li>
    <?php } ?>
    
    <!--課程資訊管理-->
    <? if (in_array('6',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m6'){echo 'class="active"';}?>> <a href="../filedown_class/list.php"><i class="fa fa-cog"></i><?php echo $m6.$mgw1;?> </a>
		<div class="m-subnav"> <i class="fa fa-angle-down"></i>
		<a href="../filedown_class/list.php"<?php if($subitem=="m61"){echo " class='active'";}?>><i class="fa fa-list"></i> <?php echo $m61.$mgw4;?></a>
		<a href="../filedown/list.php"<?php if($subitem=="m62"){echo " class='active'";}?>><i class="fa fa-list"></i> <?php echo $m62.$mgw4;?></a>
	   	</div>    
    </li>
    <?php } ?>
    
    <!--相關連結-->
    <? if (in_array('7',$Left_Menu) or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=='m7'){echo 'class="active"';}?>> <a href="../link/list.php"><i class="fa fa-cog"></i><?php echo $m7.$mgw1;?> </a>
    </li>
    <?php } ?>

    <!--員工權限管理-->
	<? if (in_array('99',$Left_Menu) Or $_SESSION["Login_ID"] == "Admin"){?>
    <li <?php if($mainitem=="s2"){echo " class='active'";}?>><a href="../control/list.php"><i class="fa fa-cog"></i> 員工權限 </a></li>
    <?php } ?>
  </ul>
  <?php } ?>
</div>
<!-- Sidebar側邊選單 -->

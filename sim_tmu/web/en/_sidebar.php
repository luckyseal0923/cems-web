<div id="cssmenu" class="sidebar">
  <?php if ( $pageName=="p1" ) { ?>
  <ul>
    <?php 
  	/***取得新聞主類別***/
	$SQL = "Select PKey, strName From news_class1 Where intLang = 2 and Upload = 'Yes' Order By Sort";
	$rsnewsclass1 = new recordset($SQL);
	while (! $rsnewsclass1->eof ){
  ?>
    <li class="has-sub<?php if( $Class1_PKey == $rsnewsclass1->field("PKey") ){echo " open";}?>"><a href="p1_news.php?C1_PKey=<? echo authcode($rsnewsclass1->field("PKey"),'ENCODE')?>">
        <? echo $rsnewsclass1->field("strName")?></a>
      <ul>
        <?php
			/***取得新聞次類別***/
			$SQL = "Select PKey,strName From news_class2 Where intLang = 2 and Upload = 'Yes' And class1_PKey = ".$rsnewsclass1->field("PKey")." Order By Sort";
			$rsnewsclass2 = new recordset($SQL);
			while (! $rsnewsclass2->eof ){
		?>
        <li<?php if ( $Class2_PKey == $rsnewsclass2->field("PKey") ){echo " class=\"mark\"";}?>><a href="p1_news.php?C2_PKey=<? echo authcode($rsnewsclass2->field("PKey"),'ENCODE')?>">
            <? echo $rsnewsclass2->field("strName")?></a>
    </li>
    <?php
			$rsnewsclass2->movenext();
		}
	?>
  </ul>
  </li>
  <?php
  		$rsnewsclass1->movenext();
	}
  ?>
  </ul>
  <?php } elseif( $pageName=="p2" ){ ?>
  <ul>
    <li class="has-sub<?php if($subPageName=="p2_1"){echo " mark";}?>"><a href="p2_intro.php">
        <?php echo $p2_1; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p2_3"){echo " mark";}?>"><a href="p2_intro3.php">
        <?php echo $p2_3; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p2_5"){echo " mark";}?>"><a href="p2_intro5.php">
        <?php echo $p2_5; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p2_2"){echo " mark";}?>"><a href="p2_intro2.php">
        <?php echo $p2_2; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p2_4"){echo " mark";}?>"><a href="p2_intro4.php">
        <?php echo $p2_4; ?>
      </a></li>
  </ul>

  <?php } elseif( $pageName=="p3" ){ ?>
  <ul>
    <?php 
  	/***取得課程主類別***/
	$SQL = "Select PKey, strName From course_class1 Where intLang = 2 and Upload = 'Yes' Order By Sort";
	$rscourseclass1 = new recordset($SQL);
	while (! $rscourseclass1->eof ){
  ?>
    <li class="<?php if( $C_Class1_PKey == $rscourseclass1->field("PKey") ){echo " open";}?>"><a href="p3_course.php?C1_PKey=<? echo authcode($rscourseclass1->field("PKey"),'ENCODE') ?>">
        <? echo $rscourseclass1->field("strName")?></a>
      <ul>
        <?php
            	/***取得課程次類別***/
				$SQL = "Select PKey,strName From course_class2 Where intLang = 2 and Upload = 'Yes' And class1_PKey = ".$rscourseclass1->field("PKey")." Order By Sort";
				$rscourseclass2 = new recordset($SQL);
				while (! $rscourseclass2->eof ){
			?>
        <li<?php if ( $C_Class2_PKey == $rscourseclass2->field("PKey") ){echo " class=\"mark\"";}?>><a href="p3_course.php?C2_PKey=<? echo authcode($rscourseclass2->field("PKey"),'ENCODE')?>">
            <? echo $rscourseclass2->field("strName")?></a>
    </li>
    <?php
            		$rscourseclass2->movenext();
				}
			?>
  </ul>
  </li>
  <?php
  		$rscourseclass1->movenext();
	}
  ?>
  </ul>

  <?php } elseif( $pageName=="p4"){ ?>
  <ul>
    <?php if ( $_SESSION["Member_PKey"] == "" ){?>
    <!---登入前--->
    <!--<li class="has-sub<?php if($subPageName=="p4_1"){echo " mark";}?>"><a href="p4_login.php">
        <?php echo $p4_1; ?>
      </a></li> -->
    <li class="has-sub<?php if($subPageName=="p4_2"){echo " mark";}?>"><a href="p4_join.php">
        <?php echo $p4_2; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p4_5"){echo " mark";}?>"><a href="p4_forget.php">
        <?php echo $p4_5; ?>
      </a></li>
    <?php }else{?>
    <!---登入後--->
    <li class="has-sub<?php if($subPageName=="p4_3"){echo " mark";}?>"><a href="p4_edit.php">
        <?php echo $p4_3; ?>
      </a></li>
    <li class="has-sub<?php if($subPageName=="p4_4"){echo " mark";}?>"><a href="p4_mem_list.php">
        <?php echo $p4_4; ?>
      </a></li>
    <li><a href="p3_course.php">Sign up course</a></li>
    <li><a href="mem_logout.php">
        <?php echo $p4_6; ?>
      </a></li>
    <?php }?>
  </ul>

  <?php } elseif( $pageName=="p5" ){ ?>
  <ul>
    <!---登入前--->
    <li class="has-sub<?php if($subPageName=="p5_2"){echo " mark";}?>"><a href="p5_classroom_cost.php">
        <?php echo $p5_2; ?>
      </a></li>
    <!--<li class="has-sub<?php if($subPageName=="p5_3"){echo " mark";}?>"><a href="p5_classroom.php">
        <?php echo $p5_3; ?>
      </a></li> -->
    <!--<li class="has-sub<?php if($subPageName=="p5_1"){echo " mark";}?>"><a href="p5_classroom_clause.php">
      <?php echo $p5_1; ?>
      </a></li> -->
  </ul>

  <?php } elseif( $pageName=="p7" ){ ?>
  <ul>
    <?php /***取得目前資料列表***/
  	$SQL = "Select PKey,strName From filedown_class1 Where intLang = 2 and Upload='Yes' Order By Sort";
	$rs = new recordset($SQL);
	while (! $rs->eof ){
  ?>
    <li class="has-sub<?php if( $rs->field(0) == $class_PKey ){echo " mark";}?>"><a href="p7_download.php?class_PKey=<?php echo authcode($rs->field("PKey"),'ENCODE');?>"><?php echo $rs->field("strName");?></a></li>
    <?php
  		$rs->movenext();
	}
  ?>
  </ul>



  <?php } ?>

  <!--<?php if ( $pageName!="p5" ) { ?>
  <a href="p5_classroom.php"><img src="../images/all/sidebar_btn1_en.png" class="sidebar_img"></a> -->
  <?php } ?>
  <?php if ( $pageName!="p6" ) { ?>
  <!--<a href="http://cems.tmu.edu.tw/dms/index.html" target="_blank" onclick="myFunction()"><img src="../images/all/sidebar_btn2.png" class="sidebar_img"></a> -->
  <?php } ?>
  <br>
  <br>
</div>

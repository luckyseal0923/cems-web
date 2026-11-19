<?php
	if($Total > 0)
	{
	   //分頁開始
	   $AreaNo = (int)(($tPage-1)/10);
	   $sPage = 1+ (10 * $AreaNo);
	   $ePage = 10 + (10 * $AreaNo);
	   $endPage = ceil($Total / $tPageSize);
	}
	if(empty($ePage))
	{
	   $ePage = "1";
	}
	if(empty($sPage))
	{
	   $sPage = "1";
	}
	
	if(empty($endPage))
	{
	   $endPage = "1";
	}
?>
<div class="page_04">

	<?php if( $tPage > 1):?>
       <a href="javascript:GotoPage(<?php echo "1"; ?>,document.SearchF,'<? echo $Keyword?>');" class="first">&lt;&lt;</a>
       <a href="javascript:GotoPage(<?php echo $tPage-1; ?>,document.SearchF,'<? echo $Keyword?>');" class="prev">&lt;</a>
    <?php endif;?>
       
   <?php for($Li=$sPage;$Li<=$ePage;$Li++):?>
      <?php if ($Li > $tPageTotal) break;?>
      <?php if ($tPage == $Li):?>
         <?php if($tPageTotal > 1):?>
            <a href="#" class="on"><?php echo $Li;?></a>
         <?php else:?>
            <a href="#" class="on"><?php echo $Li;?></a>
         <?php endif;?>
      <?php else:?>
         <a href="javascript:GotoPage(<?php echo $Li; ?>,document.SearchF,'<? echo $Keyword?>');">
            <?php echo $Li;?>
         </a>
      <?php endif;?>
   <?php endfor;?>

   <?php if ($tPage+1 <= $tPageTotal):?>
       <a href="javascript:GotoPage(<?php echo $tPage+1; ?>,document.SearchF,'<? echo $Keyword?>');" class="next">&gt;</a>
       <a href="javascript:GotoPage(<?php echo $endPage; ?>,document.SearchF,'<? echo $Keyword?>');" class="last">&gt;&gt;</a>
    <?php endif;?>
   
</div><!-- page_04 end -->

<?php
	$Total = $DR1->field("Total");//取得資料的總數
	
	//頁數
	$tSum = 1;//序號
	$tPageTotal = 1;//總頁數
	$tPage = 1;//目前頁數
	$tPage2 = 1;//目前頁數
	
	//每頁幾筆-----
	$tPageSize=$listCount;
	
	//總頁數-----
	$tPageTotal = ceil(($Total/$tPageSize));
	
	//目前頁數
	if ( $thisPageType == "photo_list" or $thisPageType == "detail_photo" or $thisPageType == "detail_forums" or $thisPageType=="detail_forums2" ){

		if ( SqlFilter($_REQUEST["Page2"],"int") > 0 ){
			$tPage2 = SqlFilter($_REQUEST["Page2"],"int");
		}
		$tSum = ($tPage2-1) * $tPageSize;
				
	} else {
		if ( SqlFilter($_REQUEST["Page"],"int") > 0 ){
			$tPage = SqlFilter($_REQUEST["Page"],"int");
		}
		$tSum = ($tPage-1) * $tPageSize;
	}
	//echo "Total=" . $Total . "<br>tPageTotal=" . $tPageTotal . "<br>tPage=" . $tPage . "<br>tPage2=" . $tPage2 . "<br>tSum=" . $tSum . "<br>tPageSize=" . $tPageSize;
?>
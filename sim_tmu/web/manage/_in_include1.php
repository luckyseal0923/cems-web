<?php
	//if($thisPageType=="list"){
		//清除Session變數
		unset($_SESSION["PKey_".$ModuleNo]);
		unset($Keywords);
		unset($_SESSION["PKey_".$ModuleNo."_cid"]);
		unset($_SESSION["PKey_".$ModuleNo."_tid"]);
		unset($_SESSION["PKey_".$ModuleNo."_n2id"]);
	//}
	//------------------------------------------------------------------------
	require("include2/_chk_permission.php");
	//------------------------------------------------------------------------
	//刪圖要用的
	/*motion = Request("motion")
	imgNo = Request("imgNo")
	imgName = Request("imgName") 'img
	docName1 = Request("docName1") 'name
	docName2 = Request("docName2") 'size*/
	//------------------------------------------------------------------------
	//上圖的位置
	switch($mainitem){
	case "m3":
		$uploadUrl1 = $uploadUrl1 . "product/";
		break;
	case "m4":
		break;
	case "m5":
		break;
	default:
		$uploadUrl1 = $uploadUrl1;
		break;
	}
	//------------------------------------------------------------------------
	if ( $thisPageType == "list" ){
	//清單
		$Page = SqlFilter($_REQUEST["Page"],"int");
		
	} elseif ( $thisPageType == "photo_list" or $thisPageType == "photo_add" or $thisPageType == "photo_detail" ){
	//相簿
		$Page2 = SqlFilter($_REQUEST["Page2"],"int");
		$ppage = SqlFilter($_REQUEST["ppage"],"int");
		$ppage2 = SqlFilter($_REQUEST["ppage2"],"int");
		
		$s_ok = SqlFilter($_REQUEST["s_ok"],"int");//是否為搜尋
		$fm = SqlFilter($_REQUEST["fm"],"int");
		
		if ( SqlFilter($_REQUEST["nid"],"int") != "" and SqlFilter($_REQUEST["nid"],"int") != 0 ){
			$_SESSION["PKey_".$ModuleNo] = SqlFilter($_REQUEST["nid"],"int");
			$Item_PKey = $_SESSION["PKey_".$ModuleNo];
			
		} else {
			ECHO "<script language=\"javascript\">" ;
			ECHO "alert('" . $warn_data_not_found ."');" ;
			ECHO "location.href='" . $page_list . "';" ;
			ECHO "</script>" ;
			exit();
		}
		
		if ( $thisPageType == "photo_detail" ){
			$pnid = SqlFilter($_REQUEST["pnid"],"int");//照片PKey
		}
		
	} elseif ( $thisPageType == "detail" ){
	//詳細內容	
		$ppage = SqlFilter($_REQUEST["ppage"],"int");//頁碼
		$s_ok = SqlFilter($_REQUEST["s_ok"],"int");//是否為搜尋
		$file_id = SqlFilter($_REQUEST["file_id"],"int");//要刪除的圖片或檔案PKey(檔案是儲存在另外的資料表時使用)
	
		if ( SqlFilter($_REQUEST["nid"],"int") != "" and SqlFilter($_REQUEST["nid"],"int") != 0 ){
			$_SESSION["PKey_".$ModuleNo] = SqlFilter($_REQUEST["nid"],"int");
			$Item_PKey = $_SESSION["PKey_".$ModuleNo];
		}
	}
	//------------------------------------------------------------------------
?>
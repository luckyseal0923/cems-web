<?php
	//------------------------------------------------------------------------
	$s_ok = SqlFilter($_REQUEST["s_ok"],"int");//是否為搜尋
	$is_search = SqlFilter($_REQUEST["is_search"],"int");//第1次搜尋
	$fm = SqlFilter($_REQUEST["fm"],"int");//來自相關單元
	
	if ( $is_search==1 and $s_ok==2 ) {
	//After the search,From the other page return 
		$s_ok = 1;
	}

	if ( $s_ok==1 ) {
	//onClick=search button
		$_SESSION["s_uid"] = "";//單元ID
		$_SESSION["s_uid"] = SqlFilter($_REQUEST["unit_id"],"int");
		$unit_id = $_SESSION["s_uid"];
		
		$_SESSION["s_bid"] = "";//相簿ID
		$_SESSION["s_bid"] = SqlFilter($_REQUEST["b_Class1"],"int");
		$b_Class1 = $_SESSION["s_bid"];

		$_SESSION["s_mid"] = "";//會員ID
		$_SESSION["s_mid"] = SqlFilter($_REQUEST["mem_id"],"int");
		$mem_id = $_SESSION["s_mid"];
		
		$_SESSION["s_cid"] = "";//類別ID
		$_SESSION["s_cid"] = SqlFilter($_REQUEST["Class1"],"int");
		$Class1 = $_SESSION["s_cid"];

		$_SESSION["s_tid"] = "";//類別ID
		$_SESSION["s_tid"] = SqlFilter($_REQUEST["Class2"],"int");
		$Class2 = $_SESSION["s_tid"];

		$_SESSION["s_tid3"] = "";//類別ID
		$_SESSION["s_tid3"] = SqlFilter($_REQUEST["Class3"],"int");
		$Class3 = $_SESSION["s_tid3"];

		$_SESSION["s_tid4"] = "";//類別ID
		$_SESSION["s_tid4"] = SqlFilter($_REQUEST["Class4"],"int");
		$Class4 = $_SESSION["s_tid4"];

		$_SESSION["s_tid5"] = "";//類別ID
		$_SESSION["s_tid5"] = SqlFilter($_REQUEST["Class5"],"int");
		$Class5 = $_SESSION["s_tid5"];
		
		$_SESSION["s_list_upordown"] = "";//上下架ID
		$_SESSION["s_list_upordown"] = SqlFilter($_REQUEST["list_upordown"],"tab");
		$list_upordown = $_SESSION["s_list_upordown"];

		$_SESSION["s_dtid"] = "";//類別
		$_SESSION["s_dtid"] = SqlFilter($_REQUEST["Class_D"],"int");
		$Class_D = $_SESSION["s_dtid"];
		
		$_SESSION["s_item1"] = "";//項目
		$_SESSION["s_item1"] = SqlFilter($_REQUEST["item1"],"int");
		$item1 = $_SESSION["s_item1"];
		
		$_SESSION["s_Keywords"] = "";//關鍵字
		$_SESSION["s_Keywords"] = SqlFilter($_REQUEST["Keywords"],"tab");
		$Keywords = $_SESSION["s_Keywords"];
		
		$_SESSION["s_pay_type"] = "";//付款方式
		$_SESSION["s_pay_type"] = SqlFilter($_REQUEST["pay_type"],"int");
		$pay_type = $_SESSION["s_pay_type"];
		
		$_SESSION["s_int_flag"] = "";//處理進度
		$_SESSION["s_int_flag"] = SqlFilter($_REQUEST["int_flag"],"int");
		$int_flag = $_SESSION["s_int_flag"];
		
		$_SESSION["s_pay_flag"] = "";//入帳否
		$_SESSION["s_pay_flag"] = SqlFilter($_REQUEST["pay_flag"],"int");
		$pay_flag = $_SESSION["s_pay_flag"];

		$_SESSION["s_search_year"] = "";//年
		$_SESSION["s_search_year"] = SqlFilter($_REQUEST["search_year"],"tab");
		$search_year = $_SESSION["s_search_year"];

		$_SESSION["s_search_month"] = "";//月
		$_SESSION["s_search_month"] = SqlFilter($_REQUEST["search_month"],"tab");
		$search_month = $_SESSION["s_search_month"];

		$_SESSION["s_search_day"] = "";//日
		$_SESSION["s_search_day"] = SqlFilter($_REQUEST["search_day"],"tab");
		$search_day = $_SESSION["s_search_day"];

		$_SESSION["s_state1"] = "";//狀態
		$_SESSION["s_state1"] = SqlFilter($_REQUEST["state1"],"int");
		$state1 = $_SESSION["s_state1"];
		
		$_SESSION["s_show_date"] = "";//顯示日期
		$_SESSION["s_show_date"] = SqlFilter($_REQUEST["show_date"],"tab");
		$show_date = $_SESSION["s_show_date"];

		$_SESSION["s_m_state"] = "";//狀態
		$_SESSION["s_m_state"] = SqlFilter($_REQUEST["m_state"],"int");
		$m_state = $_SESSION["s_m_state"];

		$_SESSION["s_OpenDate"] = "";//刊登日期
		$_SESSION["s_OpenDate"] = SqlFilter($_REQUEST["OpenDate"],"tab");
		$OpenDate = $_SESSION["s_OpenDate"];
		
		$_SESSION["s_EndDate"] = "";//下架日期
		$_SESSION["s_EndDate"] = SqlFilter($_REQUEST["EndDate"],"tab");
		$EndDate = $_SESSION["s_EndDate"];
		
		$_SESSION["s_start_date"] = "";//開始日期
		$_SESSION["s_start_date"] = SqlFilter($_REQUEST["start_date"],"tab");
		$start_date = $_SESSION["s_start_date"];
		
		$_SESSION["s_end_date"] = "";//結束日期
		$_SESSION["s_end_date"] = SqlFilter($_REQUEST["end_date"],"tab");
		$end_date = $_SESSION["s_end_date"];
		
		$_SESSION["s_is_have"] = "";//要，不要
		$_SESSION["s_is_have"] = SqlFilter($_REQUEST["is_have"],"int");
		$is_have = $_SESSION["s_is_have"];

		$s_ok = 2;
		
	} elseif ( $s_ok==2 ) {
	//From page return
		if ( $fm==1 ) {
		//from 跨單元
			$_SESSION["s_uid"] = SqlFilter($_REQUEST["unit_id"],"int");
			$_SESSION["s_cid"] = SqlFilter($_REQUEST["Class1"],"int");
			$_SESSION["s_tid"] = SqlFilter($_REQUEST["Class2"],"int");
			
			$Keywords = "";
			$_SESSION["s_Keywords"] = "";
			
			$list_upordown = "";
			$_SESSION["s_list_upordown"] = "";
			
			//跨單元 ing
			$fm = 2;
		}
		
		$unit_id = $_SESSION["s_uid"];
		$b_Class1 = $_SESSION["s_bid"];
		$mem_id = $_SESSION["s_mid"];
		$Class1 = $_SESSION["s_cid"];
		$Class2 = $_SESSION["s_tid"];
		$Class3 = $_SESSION["s_tid3"];
		$Class4 = $_SESSION["s_tid4"];
		$Class5 = $_SESSION["s_tid5"];
		$list_upordown = $_SESSION["s_list_upordown"];
		$Class_D = $_SESSION["s_dtid"];
		$item1 = $_SESSION["s_item1"];
		$Keywords = $_SESSION["s_Keywords"];
		
		$pay_type = $_SESSION["s_pay_type"];
		$int_flag = $_SESSION["s_int_flag"];
		$pay_flag = $_SESSION["s_pay_flag"];
		
		$search_year = $_SESSION["s_search_year"];
		$search_month = $_SESSION["s_search_month"];
		$search_day = $_SESSION["s_search_day"];
		
		$state1 = $_SESSION["s_state1"];
		$show_date = $_SESSION["s_show_date"];
		$m_state = $_SESSION["s_m_state"];
		
		$OpenDate = $_SESSION["s_OpenDate"];
		$EndDate = $_SESSION["s_EndDate"];

		$start_date = $_SESSION["s_start_date"];
		$end_date = $_SESSION["s_end_date"];
		
		$is_have = $_SESSION["s_is_have"];
	
	} else {
		$_SESSION["s_uid"] = "";
		$unit_id = 0;
		
		$_SESSION["s_bid"] = "";
		$b_Class1 = 0;
		
		$_SESSION["s_mid"] = "";
		$mem_id = 0;
		
		$_SESSION["s_cid"] = "";
		$Class1 = 0;
		
		$_SESSION["s_tid"] = "";
		$Class2 = 0;
		
		$_SESSION["s_tid3"] = "";
		$Class3 = 0;

		$_SESSION["s_tid4"] = "";
		$Class4 = 0;

		$_SESSION["s_tid5"] = "";
		$Class5 = 0;
		
		$_SESSION["s_list_upordown"] = "";
		$list_upordown = "";
		
		$_SESSION["s_dtid"] = "";
		$Class_D = 0;
		
		$_SESSION["s_item1"] = "";
		$item1 = 0;
		
		$_SESSION["s_Keywords"] = "";
		$Keywords = "";

		$_SESSION["s_pay_type"] = "";
		$_SESSION["s_int_flag"] = "";
		$_SESSION["s_pay_flag"] = "";
		$pay_type = 0;
		$int_flag = 0;
		$pay_flag = 0;
		
		$_SESSION["s_search_year"] = "";
		$_SESSION["s_search_month"] = "";
		$_SESSION["s_search_day"] = "";
		$search_year = "";
		$search_month = "";
		$search_day = "";
		
		$_SESSION["s_state1"] = "";
		$_SESSION["s_show_date"] = "";
		$_SESSION["s_m_state"] = "";
		$state1 = 0;
		$show_date = "";
		$m_state = 0;
		
		$_SESSION["s_OpenDate"] = "";
		$_SESSION["s_EndDate"] = "";
		$OpenDate = "";
		$EndDate = "";
		
		$_SESSION["s_start_date"] = "";
		$_SESSION["s_end_date"] = "";
		$start_date = "";
		$end_date = "";
		
		$_SESSION["s_is_have"] = "";
		$is_have = "";
		
//		if ( $subitem!="m2-3" ){
//			$_SESSION["pp_cid"] = "";
//			$_SESSION["pp_tid"] = "";
//		}
		
	}
	//------------------------------------------------------------------------
	if ( $fm==1 or $fm==2 ) {
	//1=from 跨單元　2=跨單元 ing
		$add_bt_str = "s_ok=2&fm=2&";

	} elseif( $fm==3 ){
	//跨單元回原單元
		$Keywords = "";
		$_SESSION["s_Keywords"] = "";
		
		$list_upordown = "";
		$_SESSION["s_list_upordown"] = "";
	}
	//------------------------------------------------------------------------
?>
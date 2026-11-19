<?php
	//刪除
	if ( SqlFilter($_REQUEST["u"],"tab") == "del" ){
		
		$del_nid  = implode(",",$_POST["nid"]);
		
		$SQL  = " Select * From " . $DelDbName;
		$SQL .= " Where PKey IN (".SqlFilter($del_nid,"tab").")";
		//echo "SQL=" . $SQL . "<br>";
		//exit;
		$DR1  = new recordset($SQL);
		while ( ! $DR1->eof ){
			
			if ( $del_type == 2 and $DelDbName2 != "" and $DelDbName2NId != "" ){
			//$del_type = 2 圖檔是儲存在另外的資料表
			
				$SQL2  = " Select * From " . $DelDbName2;
				$SQL2 .= " Where " . $DelDbName2NId . " = " . $DR1->field("PKey");
				$DR2 = new recordset($SQL2);
				while ( ! $DR2->eof ){
					DelFile($uploadUrl1.$DR2->field("Photo1"));		
					execute_sql ("delete From " . $DelDbName2 . " Where PKey = ".$DR2->field("PKey")) ;
				$DR2->movenext();
				}// while End
				
			} elseif ( $del_type == 3 and $DelDbName3 != "" and $DelDbName3NId != "" ){
			//$del_type = 3 會員下載權限
				execute_sql ("delete From " . $DelDbName3 . " Where member_PKey = " . $DR1->field("PKey"));
				
			} else {
				
				if ( $del_pic == "yes" ) {
					for ( $i = 1 ; $i <= $del_pic_sum ; $i++ ){
						DelFile($uploadUrl1.$DR1->field("Photo".$i));
					}
				}

				if ( $del_file == "yes" ) {
					for ( $i = 1 ; $i <= $del_file_sum ; $i++ ){
						DelFile($uploadUrl1.$DR1->field("File".$i));
					}
				}

			}
						
			execute_sql ("delete From " . $DelDbName . " Where PKey = " . $DR1->field("PKey"));
			$DR1->movenext();
		}// while End	
	
		/*if( $subitem=="m63" ){
			//$location_str = "&cid=" . $_SESSION["PKey_".$ModuleNo."_cid"];
		}*/
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert('" . $warn_del3 . "');" ;
		ECHO "location.href='" . $_SERVER["PHP_SELF"] . "?s_ok=" . $s_ok . "&fm=" . $fm . $search_go_str . "&ppage=" . $ppage . $location_str . "';";
		ECHO "</script>" ;
		exit() ;
		
	}//if ( SqlFilter($_REQUEST["u"],"tab") == "del" ){
?>
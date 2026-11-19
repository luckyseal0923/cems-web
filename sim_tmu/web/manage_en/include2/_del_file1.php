<?php 
	//刪除選取的圖檔
	if ( SqlFilter($_REQUEST["motion"],"tab") == "del" and is_numeric(SqlFilter($_REQUEST["imgNo"],"tab")) and SqlFilter($_REQUEST["act_type"],"tab") != "" ){
		//echo '$DelDbName2='	. $DelDbName2 . '<br>$DelDbName2NId='	. $DelDbName2NId . '<br>$file_id='	. $file_id . "<br>";

		if ( $del_type == 2 ){
			//檔案是儲存在另外的資料表(del_type=2)
			
			if ( $DelDbName2 != "" and $DelDbName2NId != "" and ( $file_id != "" and $file_id != 0 ) ){
				//echo 'del_type=2<br>';
				
				$SQL2  = " Select * From " . $DelDbName2;
				$SQL2 .= " Where PKey = " . SqlFilter($file_id,"int");
				//echo "Del_SQL2=" . $SQL2 . "<br>";
				$DR2 = new recordset($SQL2);
				while ( ! $DR2->eof ){
					//echo "Del_PKey=" . $DR2->field("PKey") . "<br>";
					DelFile($uploadUrl1.$DR2->field("Photo1"));		
					execute_sql ("delete From " . $DelDbName2 . " Where PKey = ".$DR2->field("PKey")) ;
				$DR2->movenext();
				}// while End
				//exit;
			}

		} else {
			//檔案是儲存在同一個資料表
			//echo 'del_type=空<br>';
			
			//取出檔案路徑
			$SQL  = " Select * From " . $DelDbName;
			if ( $thisPageType == "photo_detail" ){
				$SQL .= " Where " . $DelDbNameId . "=".SqlFilter($pnid,"int");
				
			} elseif ( $thisPageType == "chg_data" ){
				$SQL .= " Where " . $DelDbNameId . "=".SqlFilter($del_nid,"int");
				
			} else {
				$SQL .= " Where " . $DelDbNameId . "=".SqlFilter($_SESSION["PKey_".$ModuleNo],"int");
			}
			//echo $SQL;
			//exit();
			$DR1 = new recordset($SQL);
			if ( !$DR1->eof ){
				//$PKey = authcode($DR1->field($DelDbNameId),'ENCODE');
				if ( SqlFilter($_REQUEST["act_type"],"tab") == "pic" ) {
					//圖檔
					DelFile($uploadUrl1.$DR1->field("Photo".SqlFilter($_REQUEST["imgNo"],"tab")));
					$sql  = " Update " . $DelDbName . " Set " ;
					$sql .= " Photo".SqlFilter($_REQUEST["imgNo"],"tab")."='',";
					$sql .= " PhotoW".SqlFilter($_REQUEST["imgNo"],"tab")."=0,";
					$sql .= " PhotoH".SqlFilter($_REQUEST["imgNo"],"tab")."=0 ";
					//$sql .= " PhotoM".SqlFilter($_REQUEST["imgNo"],"tab")."=''";
					
				} elseif ( SqlFilter($_REQUEST["act_type"],"tab") == "file" ){
					//檔案
					DelFile($uploadUrl1.$DR1->field("File".SqlFilter($_REQUEST["imgNo"],"tab")));
					$sql  = " Update " . $DelDbName . " Set " ;
					//$sql .= " FileType".SqlFilter($_REQUEST["imgNo"],"tab")."=0,";
					$sql .= " File".SqlFilter($_REQUEST["imgNo"],"tab")."='',";
					//$sql .= " FileLink".SqlFilter($_REQUEST["imgNo"],"tab")."='',";
					$sql .= " FileSize".SqlFilter($_REQUEST["imgNo"],"tab")."='' ";
				}			

				if ( $thisPageType == "photo_detail" ){
					$sql .= " Where " . $DelDbNameId . "=" . SqlFilter($pnid,"int");
				} else {
					$sql .= " Where " . $DelDbNameId . "=" . SqlFilter($_SESSION["PKey_".$ModuleNo],"int");
				}
					//echo $sql;
					execute_sql($sql);
			}//if (!$DR1->eof){		
				
		}
		
		echo "<script language=\"javascript\">" ;
		echo "alert('" . $warn_del3 . "');" ;
		if ( $thisPageType == "photo_detail"  ){
			echo "location.href='" . $_SERVER["PHP_SELF"] . "?nid=" . SqlFilter($_SESSION["PKey_".$ModuleNo],"int") . "&pnid=" . $pnid . "&s_ok=" . $s_ok . "&fm=" . $fm . "&ppage=" . $ppage . "&ppage2=" . $ppage2 . $search_go_str . "';";
			
		} elseif ( $thisPageType == "chg_data" ){
			echo "location.href='" . $_SERVER["PHP_SELF"] . "';" ;
			
		} else {
			echo "location.href='" . $_SERVER["PHP_SELF"] . "?nid=" . SqlFilter($_SESSION["PKey_".$ModuleNo],"int") . "&s_ok=" . $s_ok . "&fm=" . $fm . "&ppage=" . $ppage . $search_go_str . "';" ;
		}
		echo "</script>" ;
		exit() ;
	}
?>
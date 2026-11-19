<?php
	if ( $show_chg_bt == "1" ) {
		
		if ( SqlFilter($_REQUEST["u"],"tab") == "ok" and SqlFilter($_REQUEST["item_nid1"],"int") != "" and SqlFilter($_REQUEST["item_nid1"],"int") != 0 ){
			
			if ( SqlFilter($_REQUEST["this_count"],"int") != "" and SqlFilter($_REQUEST["this_count"],"int") != 0 ){
				$listCount = SqlFilter($_REQUEST["this_count"],"int");
			}
			
			for ( $i=1;$i<=$listCount;$i++ ){
				$nid = "";
				$nid = SqlFilter($_POST['item_nid'.$i],"int");
				
				$Sort = SqlFilter($_POST['Sort'.$i],"int");
				$Sort_old = SqlFilter($_POST['Sort_old'.$i],"int");
				
				if ( ( $nid != "" and $nid != 0 ) and ( $Sort != $Sort_old ) ){
					
					$SQL  = " Select * ";
					$SQL .= " From " . $DelDbName;
					$SQL .= " Where " . $DelDbNameId . " = " . $nid;
					$DR1  = new recordset($SQL);
					//echo $SQL;
					if ( !$DR1->eof ){
						//Update
						$SQL_U  = " Update " . $DelDbName . " set ";
						$SQL_U .= " Sort = '".SqlFilter($Sort,"int")."',";
						$SQL_U .= " UserID2 = '".SqlFilter($login_user,"tab")."',";
						$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
						$SQL_U .= " Where " . $DelDbNameId . "=" . $nid;
						//echo $SQL_U;
						execute_sql($SQL_U);
						
					}					
				}				
			}//for
			
			/*if( $subitem=="m63" ){
				$location_str = "&cid=" . $_SESSION["PKey_".$ModuleNo."_cid"];
			}*/
			
			ECHO "<script language=\"javascript\">" ;
			ECHO "alert('" . $warn_chg_ok . "');";
			ECHO "location.href='" . $_SERVER["PHP_SELF"] . "?s_ok=" . $s_ok . "&fm=" . $fm . $search_go_str . "&Page=" . $Page . $location_str . "';";
			ECHO "</script>";
						
		}//if
	}
?>
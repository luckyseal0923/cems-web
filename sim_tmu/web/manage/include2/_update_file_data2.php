<?php
			//print_r($Photo);
			//echo "<br><br>";
			
			//寫入DB-圖片
			if ( $img_start > 0 and ( $DelDbName2 != "" and $DelDbName2NId != "" ) ){
				
				for ( $i=$img_start;$i<=$img_end;$i++ ){
					
					$SQL_U = "";
					$SQL_UD = "";
					$SQL_UD = "PhotoM1 = '".SqlFilter($_POST['PhotoM'.$i],"tab")."',";
					
					if ( strLen($Photo[$i]) > 10 ){
					
						$SQL  = " Select * From " . $DelDbName2;
						$SQL .= " Where " . $DelDbName2NId . " = " . SqlFilter($Item_PKey,"int");
						$SQL .= " and Sort = " . SqlFilter($i,"int");
						$DR1  = new recordset($SQL);
						//echo "SQL=" . $SQL . "<br>";
						if ( !$DR1->eof ){
							//Update
							DelFile($uploadUrl1.$DR1->field("Photo1"));
							DelFile($uploadUrl2.$DR1->field("Photo1"));
	
							$SQL_U  = " Update " . $DelDbName2 . " set ";
							$SQL_U .= " $DelDbName2NId = '".SqlFilter($Item_PKey,"int")."',";
							$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
							$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',"; 
							$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',"; 
							$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
							$SQL_U .= $SQL_UD;
							$SQL_U .= " UserID2 ='".SqlFilter($login_user,"tab")."',";
							$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
							$SQL_U .= " Where PKey =".$DR1->field("PKey");
							
						} else {
							//Insert
							$SQL_U  = " Insert into " . $DelDbName2 . " set ";
							$SQL_U .= " $DelDbName2NId = '".SqlFilter($Item_PKey,"int")."',";
							$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
							$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',"; 
							$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',"; 
							$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
							$SQL_U .= $SQL_UD;
							$SQL_U .= " UserID ='".SqlFilter($login_user,"tab")."',";
							$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
							$SQL_U .= " UserID2 ='".SqlFilter($login_user,"tab")."',";
							$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
						}
						execute_sql($SQL_U);
					
					}//if (strLen($Photo[$i]) > 10){
					//echo $i . "_SQL_U=" . $SQL_U . "<br><br>";
					
				}//for
				
			}//if( $img_start > 0 ){
			//exit;
?>
<?php
				if( $img_start>0 ){
					for ($i=$img_start; $i <= $img_end; $i++) {
						if (strLen($Photo[$i]) > 10){
							//刪除原始圖檔
							if(SqlFilter($_SESSION["PKey_".$ModuleNo],"int")!="" and SqlFilter($_SESSION["PKey_".$ModuleNo],"int")!=0){
								DelFile($uploadUrl1.$DR1->field("Photo$i"));
								DelFile($uploadUrl2.$DR1->field("Photo$i"));
							}
		
							$SQL_U .= "Photo$i = '".SqlFilter($Photo[$i],"tab")."',";
							$SQL_U .= "PhotoW$i = '".SqlFilter($PhotoW[$i],"int")."',";
							$SQL_U .= "PhotoH$i = '".SqlFilter($PhotoH[$i],"int")."',";
						}
						$SQL_U .= "PhotoM$i = '".SqlFilter($_POST['PhotoM'.$i],"tab")."',";
					}//for
				}
				
				$i = "";
				if( $file_start>0 ){
					for ($i=$file_start; $i <= $file_end; $i++) {
						if (strLen($File[$i]) > 10){
							//刪除原始圖檔
							if(SqlFilter($_SESSION["PKey_".$ModuleNo],"int")!="" and SqlFilter($_SESSION["PKey_".$ModuleNo],"int")!=0){
								DelFile($uploadUrl1.$DR1->field("File$i"));
							}
		
							$SQL_U .= "File$i = '".SqlFilter($File[$i],"tab")."',";
						}
						$SQL_U .= "FileType$i = '".SqlFilter($_POST['FileType'.$i],"int")."',";
						$SQL_U .= "FileLink$i = '".SqlFilter($_POST['FileLink'.$i],"tab")."',";
						if( SqlFilter($_POST['FileSize'.$i],"tab")!=""){
							//Size有填寫
							$SQL_U .= "FileSize$i = '".SqlFilter($_POST['FileSize'.$i],"tab")."',";
						}elseif( SqlFilter($File[$i],"tab")!="" ){
							//上傳檔案存在
							$SQL_U .= "FileSize$i = '".SqlFilter($FileSize[$i],"tab")."',";
						}
						$SQL_U .= "FileName$i = '".SqlFilter($_POST['FileName'.$i],"tab")."',";
					}//for
				}
?>
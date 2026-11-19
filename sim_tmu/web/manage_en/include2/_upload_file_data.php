<?php
	if ( $MSG == "" ){
		//echo '$img_start='.$img_start."<br>";
		//echo '$img_end='.$img_end."<br>";
		
		//用迴圈讀取上傳檔案資料
		//圖檔		
		for ( $i = $img_start; $i <= $img_end; $i++ ){
			//echo $uploadUrl1;
			$new_file = $_FILES['Photo'.$i];
			//echo '$i='.$i." ";
			//print_r($new_file);
			//echo "<br><br>";
			$file_name = $new_file['name'];//讀取上傳檔名
			$file_name = str_ireplace(' ', '_', $file_name);//把檔名中的空格替換成 "_"
			$file_tmp  = $new_file['tmp_name'];//存入暫存區的檔名
			$file_size = $new_file['size'];//檔案大小

			//判斷檔案是否指定上傳檔案…
			if ( is_uploaded_file($file_tmp) ){
				//若有上傳檔，則取出該檔案的副檔名
				$ext = strrchr($file_name,'.');
				
				//判斷副檔名是否符合預期
				if ( !in_array(strtolower($ext),$img_limitedext) ){
					//不符合預期，顯示錯誤訊息。
					$MSG .="檔案 $i: ($file_name) 的檔案副檔名有誤（只允許" . $ImageTypeLimit . "）\\n";

				} else {
					
					//檢查檔案是否太大
					if ( $file_size > $img_size_bytes ){
						$MSG .="檔案 $i: ($file_name) 無法上傳，請檢查檔案是否小於 ". $img_size_bytes / 1024 ." KB。\\n";

					} else {
						$file_name = $ForderName . date('YmdHis').substr(microtime(),2,3) . $i . $ext;//更改上傳的圖檔名稱.
		
						//放入陣列
						$Photo[$i] = $file_name;//存入資料庫的 檔案存取路徑
						//echo "Photo:i=" . $i . "<br>file_name=" . $file_name . "<br>file_tmp=" . $file_tmp . "<br>file_size=" . $file_size . "<br>ext=" . $ext . "<br>Photo[$i]=" . $Photo[$i] . "<br>";
						
						if ( move_uploaded_file($file_tmp,$uploadUrl1.$file_name) ){//執行此句表示檔案已成功上傳至資料夾
							
							//取得上傳圖片
							$src = getimagesize($uploadUrl1.$file_name);
							
							//縮圖,再儲存至「**原來**」的資料夾
							$is_resize_image = "no";
							$resize_width = "";
							$resize_height = "";
							if ( $subitem == "aaaa" and $i == 1 ){
								//m50=名師介紹
								$is_resize_image = "yes";
								$resize_width = "230";
								$resize_height = "230";
							}
							
							if ( $is_resize_image == "yes" ){
								if ( $src['0'] >= $resize_width or $src['1'] >= $resize_height ){
								
									//重設圖片尺吋
									$reSizeImg = ReSizeImg($uploadUrl1.$file_name,$resize_width,$resize_height);
									/*製作圖片,再儲存至原來的資料夾,覆蓋原來的檔案*/
									$Resize_Image = new Resize_Image;
									$Resize_Image->image_to_resize 	= $uploadUrl1.$file_name;
									$Resize_Image->new_width 		= $reSizeImg['0'];
									$Resize_Image->new_height 		= $reSizeImg['1'];
									$Resize_Image->new_image_name 	= $file_name;
									$Resize_Image->save_folder 		= $uploadUrl1;
									$Resize_Image->resize();
									
									//取得來源圖片長寬
									$PhotoW[$i] = $reSizeImg['0'];//圖檔寬
									$PhotoH[$i] = $reSizeImg['1'];//圖檔高
									
								} else {
									//取得來源圖片長寬
									$PhotoW[$i] = $src['0'];//圖檔寬
									$PhotoH[$i] = $src['1'];//圖檔高
								}
								
							} else {
								//取得來源圖片長寬
								$PhotoW[$i] = $src[0];
								$PhotoH[$i] = $src[1];
								
							}//if( $is_resize_image=="yes" ){
								

							/*同樣名稱的圖片,縮小圖後,存在「指定」的資料夾-------------------------begin-*/
							
							//縮圖,再儲存至「**指定**」的資料夾
							$is_other_save = "no";
							$other_resize_width = "";
							$other_resize_height = "";
							if ( $subitem == "aaaa" and $i == 1 ){
								$is_other_save = "yes";
								$other_resize_width = "225";
								$other_resize_height = "225";
							}

							if ( $is_other_save == "yes" ){
								if ( $src['0'] >= $resize_width or $src['1'] >= $resize_height ){
								
									//重設圖片尺吋
									$reSizeImg2 = ReSizeImg($uploadUrl1.$file_name,$other_resize_width,$other_resize_height);
									/*製作圖片,再儲存至「指定」的資料夾,覆蓋原來的檔案*/
									$Resize_Image = new Resize_Image;
									$Resize_Image->image_to_resize 	= $uploadUrl1.$file_name;
									$Resize_Image->new_width 		= $reSizeImg2['0'];
									$Resize_Image->new_height 		= $reSizeImg2['1'];
									$Resize_Image->new_image_name 	= $file_name;
									$Resize_Image->save_folder 		= $uploadUrl2;
									$Resize_Image->resize();
									
								}
								
							}//if( $is_resize_image=="yes" ){
															
							/*同樣名稱的圖片,縮小圖後,存在「指定」的資料夾-------------------------end---*/
							

						}//if (move_uploaded_file...
						
					}//if ($file_size > $img_size_bytes){
					
				}
			}
			
		}//for
		
		
		//檔案
		for ( $j = $file_start; $j <= $file_end; $j++ ){
			$new_file2 = $_FILES['File'.$j];
			$file_name2 = $new_file2['name'];//讀取上傳檔名
			$file_name2 = str_ireplace(' ', '_', $file_name2);//把檔名中的空格替換成 "_"
			$file_tmp2  = $new_file2['tmp_name'];//存入暫存區的檔名
			$file_size2 = $new_file2['size'];//檔案大小
			//判斷檔案是否指定上傳檔案…
			if ( is_uploaded_file($file_tmp2) ){
				//若有上傳檔，則取出該檔案的副檔名
				$ext2 = strrchr($file_name2,'.');
				
				//判斷副檔名是否符合預期
				if ( !in_array(strtolower($ext2),$file_limitedext) ){
					//不符合預期，顯示錯誤訊息。
					$MSG .="檔案 $j: ($file_name2) 的檔案副檔名有誤（只允許" . $FileTypeLimit . "） \\n";

				} else {
					
					//檢查檔案是否太大
					if ( $file_size2 > $file_size_bytes ){
						$MSG .="檔案 $j: ($file_name2) 無法上傳，請檢查檔案是否小於 ". $file_size_bytes / 1024 ." KB。\\n";

					} else {
						$file_name2 = $ForderName . date('YmdHis').substr(microtime(),2,3) . $j . $ext2;//更改上傳的圖檔名稱.
						//echo "<br>File1:j=" . $j . "<br>file_name2=" . $file_name2 . "<br>file_tmp2=" . $file_tmp2 . "<br>file_size2=" . $file_size2 . "<br>ext2=" . $ext2 . "<br>File[j]=" . $File[$j] . "<br>";
		
						//放入陣列
						$File[$j] = $file_name2;//存入資料庫的 檔案存取路徑
						//echo "<br>File2:j=" . $j . "<br>file_name2=" . $file_name2 . "<br>file_tmp2=" . $file_tmp2 . "<br>file_size2=" . $file_size2 . "<br>ext2=" . $ext2 . "<br>File[j]=" . $File[$j] . "<br>";
						
						//尺寸計算
						$size_count = "";
						if ( $file_size2>1000000 ){
							$size_count = round($file_size2/1000000, 2) . "MB";
							
						} elseif ( $file_size2>1000 ){
							$size_count = round($file_size2/1000, 2) . "KB";						
						}
						$FileSize[$j] = $size_count;					
						
						if ( move_uploaded_file($file_tmp2,$uploadUrl1.$file_name2) ){
							//取得上傳圖片
							//$src2 = getimagesize($uploadUrl1.$file_name2);
						}					   
					}
					
				}
			}
			
		}//for
		
		/*echo "<pre>";  
		var_dump($_FILES);  
		echo "</pre>";
		exit;*/
		
	}//if
?>
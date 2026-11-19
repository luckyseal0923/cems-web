<?php 
/*
* desc: 圖檔合成
* author: james
* date: 2019/4/3
*/

//計算縮圖寬高
function ReSizeImg($PhotoUrl,$PhotoW,$PhotoH){
	//函數功能：回傳縮圖的寬高
	//參數意義：原始圖寬,原始圖高,限制圖寬,限制圖高

	//判斷圖檔是否存在
	$imgW = $PhotoW;
	$imgH = $PhotoH;
	if(is_file($PhotoUrl)){
		// 取得上傳圖片
		$src = getimagesize($PhotoUrl);
		// 取得來源圖片長寬
		$imgW = $src[0];
		$imgH = $src[1];

		//不指定寬
		if ($PhotoW==0)
			$RePhotoW = $imgW;
		else
			$RePhotoW = $PhotoW;

		//不指定高
		if ($PhotoH == 0)
			$RePhotoH = $imgH;
		else
			$RePhotoH = $PhotoH;

		if ($imgW >= $imgH){
			if ($imgW >= $RePhotoW){
				$cropW = $RePhotoW;
				$cropH = ceil($imgH/($imgW /$cropW));
			}
			else {
			 	$cropH = $imgH;
				$cropW = $imgW;
			}
		}
		else {
		 	if ($imgH >= $RePhotoH){
				$cropH = $RePhotoH;
				$cropW = ceil($imgW/($imgH / $cropH));
			}
			else {
			 	$cropH = $imgH;
				$cropW = $imgW;
			}
		}
		if ($cropW >= $RePhotoW){
			$cropH = ceil($cropH / ($cropW/$RePhotoW));
			$cropW = $RePhotoW;
		}

		if ($cropH >= $RePhotoH){
			$cropW = ceil($cropW / ($cropH/$RePhotoH));
			$cropH = $RePhotoH;
		}
	}
	//$imgsize = array( $cropW,$cropH);
    return array( $cropW,$cropH);
}



/**
* 圖檔合成
* @param $source_path 原圖路徑
* @param $target_path 目標路徑
* @param $target_width 目標寬度
* @param $target_height 目標高度
* @return bool|resource
*/
function merge_image($source_path,$target_path,$target_width=500,$target_height=500){
	// 合成後的圖片
	$image_all = imageCreatetruecolor($target_width,$target_height);
	// 為真彩色畫布建立白色背景
	$color = imagecolorallocate($image_all, 255, 255, 255);
	imagefill($image_all, 0, 0, $color);
	//imageColorTransparent($image_all, $color); // 背景透明
	
	$source_info = getimagesize($source_path);
	$source_width = $source_info[0];
	$source_height = $source_info[1];
	$source_mime = $source_info['mime'];
		
	// 排版合成 
	$tmpx=0;   
	$tmpy=0; //圖片之間的間距   
	if($target_width-$source_width > 0){
		$tmpx= ceil(($target_width-$source_width) / 2); 
	} 
	if($target_height-$source_height > 0){
		$tmpy= ceil(($target_height-$source_height) / 2); 
	}
	
	//存到Server 
	switch ($source_mime)
	{
		case 'image/gif':
			$source_image = imagecreatefromgif($source_path);
			imagecopyresampled($image_all,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagegif($image_all,$target_path); 
			break;
		case 'image/jpeg':
			$source_image = imagecreatefromjpeg($source_path);
			imagecopyresampled($image_all,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagejpeg($image_all,$target_path); 
			break;
		case 'image/png':
			$source_image = imagecreatefrompng($source_path);
			imagecopyresampled($image_all,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			imagesavealpha($image_all, true);
			Imagepng($image_all,$target_path); 
			break;
		default:
			$source_image = imagecreatefromjpeg($source_path);
			imagecopyresampled($image_all,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagejpeg($image_all,$target_path); 
			break;
	}
	
	//$source_image = imagecreatefromjpeg($source_path); 
	//imagecopy($image_all,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height);
		 
	//Imagejpeg($image_all,$target_path);  
	//清楚緩存  
	imagedestroy($image_all);   
	imagedestroy($source_image);	
}

/**
* 合成浮水印圖檔
* @param $target_path 背景圖
* @param $sourece 來源圖
* @param $newimg 新檔名
* @return bool|resource
*/
function merge_watermark($target_path,$sourece_path,$new_path){
	
	$target_info = getimagesize($target_path);
	$target_width = $target_info[0];
	$target_height = $target_info[1];
	$target_mime = $target_info['mime'];
	switch ($target_mime)
	{
		case 'image/gif':
			$target_image = imagecreatefromgif($target_path);
			break;
		case 'image/jpeg':
			$target_image = imagecreatefromjpeg($target_path);
			break;
		case 'image/png':
			$target_image = imagecreatefrompng($target_path);
			break;
		default:
			$source_image = imagecreatefromjpeg($target_path);
			break;
	}
	
	$source_info = getimagesize($sourece_path);
	$source_width = $source_info[0];
	$source_height = $source_info[1];
	$source_mime = $source_info['mime'];
		
	// 排版合成 
	$tmpx=0;   
	$tmpy=0; //圖片之間的間距   
	if($target_width-$source_width > 0){
		$tmpx= ceil(($target_width-$source_width) / 2); 
	} 
	if($target_height-$source_height > 0){
		$tmpy= ceil(($target_height-$source_height) / 2); 
	}
	
	//存到Server 
	switch ($source_mime)
	{
		case 'image/gif':
			$source_image = imagecreatefromgif($source_path);
			imagecopyresampled($target_image,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagegif($target_image,$new_path); 
			break;
		case 'image/jpeg':
			$source_image = imagecreatefromjpeg($source_path);
			imagecopyresampled($target_image,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagejpeg($target_image,$new_path); 
			break;
		case 'image/png':
			$source_image = imagecreatefrompng($source_path);
			imagecopyresampled($target_image,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			imagesavealpha($target_image, true);
			Imagepng($target_image,$new_path); 
			break;
		default:
			$source_image = imagecreatefromjpeg($source_path);
			imagecopyresampled($target_image,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height,$source_width,$source_height);
			Imagejpeg($target_image,$new_path); 
			break;
	}
	
	//$source_image = imagecreatefromjpeg($source_path); 
	//imagecopy($target_image,$source_image,$tmpx,$tmpy,0,0,$source_width,$source_height);
		 
	//Imagejpeg($target_image,$target_path);  
	//清楚緩存  
	imagedestroy($target_image);   
	imagedestroy($source_image);	
}
?>
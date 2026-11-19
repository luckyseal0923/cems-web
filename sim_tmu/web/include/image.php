<?php 

/**
 * @link http://www.aiit.wang
 *curl判斷判斷遠程圖片或文件是否存在
 */
function url_exists($url) {
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    //不下載
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    //設置超時
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code == 200) {
        return true;
    }
    return false;
}

//產生QRCode
function QRCode($data,$size=4,$level='L') {
	include "qrcode/qrlib.php"; // 引用 PHP QR code

	//set it to writable location, a place for temp generated PNG files
	$PNG_TEMP_DIR = 'Upload/QRCode/';

	//html PNG location prefix
	$PNG_WEB_DIR = 'Upload/QRCode/';
	  

	//ofcourse we need rights to create temp dir
	if (!file_exists($PNG_TEMP_DIR)){
		mkdir($PNG_TEMP_DIR);
	}
	$filename = $PNG_TEMP_DIR.'test.png';

	//processing form input
	//remember to sanitize user input in real-life solution !!!
	$errorCorrectionLevel = 'L';
	if (isset($level) && in_array($level, array('L','M','Q','H'))){
		$errorCorrectionLevel = $level;
	}   

	$matrixPointSize = 4;
	if (isset($size)){
		$matrixPointSize = min(max((int)$size, 1), 10);
	}
	if (isset($data)) { 

		//it's very important!
		if (trim($data) == '')
			die('data cannot be empty! <a href="?">back</a>');
			
		// user data
		$filename = $PNG_TEMP_DIR.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		
	} else {    

		//default data
		echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
		QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		
	}    
	return $PNG_WEB_DIR.basename($filename)	;
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

/*
*功能：php完美實現下載遠程圖片保存到本地
*參數：文件url,保存文件目錄,保存文件名稱，使用的下載方式
*當保存文件名稱為空時則使用遠程文件原來的名稱
*/
function getImage($url,$save_dir='',$filename='',$type=0){
    if(trim($url)==''){
		return array('file_name'=>'','save_path'=>'','error'=>1);
	}
	if(trim($save_dir)==''){
		$save_dir='./';
	}
    if(trim($filename)==''){//保存文件名
        $ext=strrchr($url,'.');
        if($ext!='.gif'&&$ext!='.jpg'&&$ext!='.png'){
			return array('file_name'=>'','save_path'=>'','error'=>3);
		}
        $filename=time().$ext;
    }
	if(0!==strrpos($save_dir,'/')){
		$save_dir.='/';
	}
	//創建保存目錄
	if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
		return array('file_name'=>'','save_path'=>'','error'=>5);
	}
    //獲取遠程文件所採用的方法 
    if($type){
		$ch=curl_init();
		$timeout=5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);
    }else{
	    ob_start(); 
	    readfile($url);
	    $img=ob_get_contents(); 
	    ob_end_clean(); 
    }
    //$size=strlen($img);
    //文件大小 
    $fp2=@fopen($save_dir.$filename,'a');
    fwrite($fp2,$img);
    fclose($fp2);
	unset($img,$url);
    return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
}

/**
 * 圖片處理函數功能：縮放、剪切、相框、水印、銳化、旋轉、翻轉、透明度、反色
 * 處理並保存歷史記錄的思路：當有圖片有改動時自動生成一張新圖片，命名方式可以考慮在原圖片的基礎上加上步驟，例如：圖片名稱+__第幾步
 * 網址：http://www.phpernote.com
 */
class picture{
     var $PICTURE_URL; //要處理的圖片
     var $DEST_URL = "temp__01.jpg"; //生成目標圖片位置
     var $PICTURE_CREATE; //要創建的圖片
     var $TURE_COLOR; //新建一個真彩圖像
   
   
     var $PICTURE_WIDTH; //原圖片寬度
     var $PICTURE_HEIGHT; //原圖片高度
   
   
    /**
     * 水印的類型，默認的為水印文字
     */
     var $MARK_TYPE = 1;
     var $WORD; //經過UTF-8後的文字
     var $WORD_X; //文字橫坐標
     var $WORD_Y; //文字縱坐標
     var $FONT_TYPE; //字體類型
     var $FONT_SIZE = "12"; //字體大小
     var $FONT_WORD; //文字
     var $ANGLE = 0; //文字的角度，默認為0
     var $FONT_COLOR = "#000000"; //文字顏色
     var $FONT_PATH = "font/simkai.ttf"; //字體庫，默認為細明體
     var $FORCE_URL; //水印圖片
     var $FORCE_X = 0; //水印橫坐標
     var $FORCE_Y = 0; //水印縱坐標
     var $FORCE_START_X = 0; //切起水印的圖片橫坐標
     var $FORCE_START_Y = 0; //切起水印的圖片縱坐標
   
   
     var $PICTURE_TYPE; //圖片類型
     var $PICTURE_MIME; //輸出的頭部
   
   
    /**
     * 縮放比例為1的話就按縮放高度和寬度縮放
     */
     var $ZOOM = 1; //縮放類型
     var $ZOOM_MULTIPLE; //縮放比例
     var $ZOOM_WIDTH; //縮放寬度
     var $ZOOM_HEIGHT; //縮放高度
   
   
    /**
     * 裁切，按比例和固定長度、寬度
     */
     var $CUT_TYPE = 1; //裁切類型
     var $CUT_X = 0; //裁切的橫坐標
     var $CUT_Y = 0; //裁切的縱坐標
     var $CUT_WIDTH = 100; //裁切的寬度
     var $CUT_HEIGHT = 100; //裁切的高度
   
   
    /**
     * 銳化
     */
     var $SHARP = "7.0"; //銳化程度
   
   
    /**
     * 透明度處理
     */
     var $ALPHA = '100'; //透明度在0-127之間
     var $ALPHA_X = "90";
     var $ALPHA_Y = "50";
   
    /**
     * 任意角度旋轉
     */
     var $CIRCUMROTATE = "90.0"; //注意，必須為浮點數
   
   
    /**
     * 出錯信息
     */
     var $ERROR = array(
        'unalviable' => '沒有找到相關圖片!'
        );
   
    /**
     * 構造函數：函數初始化
     */
     function __construct($PICTURE_URL){
       
         $this -> get_info($PICTURE_URL);
       
         }
     function get_info($PICTURE_URL){
        /**
         * 處理原圖片的信息,先檢測圖片是否存在,不存在則給出相應的信息
         */
         @$SIZE = getimagesize($PICTURE_URL);
         if(!$SIZE){
             exit($this -> ERROR['unalviable']);
             }
       
         // 得到原圖片的信息類型、寬度、高度
        $this -> PICTURE_MIME = $SIZE['mime'];
         $this -> PICTURE_WIDTH = $SIZE[0];
         $this -> PICTURE_HEIGHT = $SIZE[1];
       
         // 創建圖片
        switch($SIZE[2]){
         case 1:
             $this -> PICTURE_CREATE = imagecreatefromgif($PICTURE_URL);
             $this -> PICTURE_TYPE = "imagejpeg";
             $this -> PICTURE_EXT = "jpg";
             break;
         case 2:
             $this -> PICTURE_CREATE = imagecreatefromjpeg($PICTURE_URL);
             $this -> PICTURE_TYPE = "imagegif";
             $this -> PICTURE_EXT = "gif";
             break;
         case 3:
             $this -> PICTURE_CREATE = imagecreatefrompng($PICTURE_URL);
             $this -> PICTURE_TYPE = "imagepng";
             $this -> PICTURE_EXT = "png";
             break;
             }
       
        /**
         * 文字顏色轉換16進制轉換成10進制
         */
         preg_match_all("/([0-f]){2,2}/i", $this -> FONT_COLOR, $MATCHES);
         if(count($MATCHES) == 3){
         $this -> RED = hexdec($MATCHES[0][0]);
         $this -> GREEN = hexdec($MATCHES[0][1]);
         $this -> BLUE = hexdec($MATCHES[0][2]);
         }
     }

 # end of __construct
/**
 * 將16進制的顏色轉換成10進制的（R，G，B）
 */
function hex2dec(){
     preg_match_all("/([0-f]){2,2}/i", $this -> FONT_COLOR, $MATCHES);
     if(count($MATCHES) == 3){
         $this -> RED = hexdec($MATCHES[0][0]);
         $this -> GREEN = hexdec($MATCHES[0][1]);
         $this -> BLUE = hexdec($MATCHES[0][2]);
         }
     }

 // 縮放類型
function zoom_type($ZOOM_TYPE){
     $this -> ZOOM = $ZOOM_TYPE;
     }

 // 對圖片進行縮放,如果不指定高度和寬度就進行縮放
function zoom(){
     // 縮放的大小
    if($this -> ZOOM == 0){
         $this -> ZOOM_WIDTH = $this -> PICTURE_WIDTH * $this -> ZOOM_MULTIPLE;
         $this -> ZOOM_HEIGHT = $this -> PICTURE_HEIGHT * $this -> ZOOM_MULTIPLE;
         }
     // 新建一個真彩圖像
    $this -> TRUE_COLOR = imagecreatetruecolor($this -> ZOOM_WIDTH, $this -> ZOOM_HEIGHT);
     $WHITE = imagecolorallocate($this -> TRUE_COLOR, 255, 255, 255);
     imagefilledrectangle($this -> TRUE_COLOR, 0, 0, $this -> ZOOM_WIDTH, $this -> ZOOM_HEIGHT, $WHITE);
     imagecopyresized($this -> TRUE_COLOR, $this -> PICTURE_CREATE, 0, 0, 0, 0, $this -> ZOOM_WIDTH, $this -> ZOOM_HEIGHT, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
     }

 # end of zoom
// 裁切圖片,按坐標或自動
function cut(){
     $this -> TRUE_COLOR = imagecreatetruecolor($this -> CUT_WIDTH, $this -> CUT_WIDTH);
     imagecopy($this -> TRUE_COLOR, $this -> PICTURE_CREATE, 0, 0, $this -> CUT_X, $this -> CUT_Y, $this -> CUT_WIDTH, $this -> CUT_HEIGHT);
     }

 # end of cut
/**
 * 在圖片上放文字或圖片
 * 水印文字
 */
function _mark_text(){
     $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
     $this -> WORD = mb_convert_encoding($this -> FONT_WORD, 'utf-8', 'gb2312');
    /**
     * 取得使用 TrueType 字體的文本的範圍
     */
     $TEMP = imagettfbbox($this -> FONT_SIZE, 0, $this -> FONT_PATH, $this -> WORD);
     $WORD_LENGTH = strlen($this -> WORD);
     $WORD_WIDTH = $TEMP[2] - $TEMP[6];
     $WORD_HEIGHT = $TEMP[3] - $TEMP[7];
    /**
     * 文字水印的默認位置為右下角
     */
     if($this -> WORD_X == ""){
         $this -> WORD_X = $this -> PICTURE_WIDTH - $WORD_WIDTH;
         }
     if($this -> WORD_Y == ""){
         $this -> WORD_Y = $this -> PICTURE_HEIGHT - $WORD_HEIGHT;
         }
     imagesettile($this -> TRUE_COLOR, $this -> PICTURE_CREATE);
     imagefilledrectangle($this -> TRUE_COLOR, 0, 0, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT, IMG_COLOR_TILED);
     $TEXT2 = imagecolorallocate($this -> TRUE_COLOR, $this -> RED, $this -> GREEN, $this -> Blue);
     imagettftext($this -> TRUE_COLOR, $this -> FONT_SIZE, $this -> ANGLE, $this -> WORD_X, $this -> WORD_Y, $TEXT2, $this -> FONT_PATH, $this -> WORD);
     }

/**
 * 水印圖片
 */
 function _mark_picture(){
   
    /**
     * 獲取水印圖片的信息
     */
     @$SIZE = getimagesize($this -> FORCE_URL);
     if(!$SIZE){
         exit($this -> ERROR['unalviable']);
         }
     $FORCE_PICTURE_WIDTH = $SIZE[0];
     $FORCE_PICTURE_HEIGHT = $SIZE[1];
     // 創建水印圖片
    switch($SIZE[2]){
     case 1:
         $FORCE_PICTURE_CREATE = imagecreatefromgif($this -> FORCE_URL);
         $FORCE_PICTURE_TYPE = "gif";
         break;
     case 2:
         $FORCE_PICTURE_CREATE = imagecreatefromjpeg($this -> FORCE_URL);
         $FORCE_PICTURE_TYPE = "jpg";
         break;
     case 3:
         $FORCE_PICTURE_CREATE = imagecreatefrompng($this -> FORCE_URL);
         $FORCE_PICTURE_TYPE = "png";
         break;
         }
    /**
     * 判斷水印圖片的大小，並生成目標圖片的大小，如果水印比圖片大，則生成圖片大小為水印圖片的大小。否則生成的圖片大小為原圖片大小。
     */
     $this -> NEW_PICTURE = $this -> PICTURE_CREATE;
     if($FORCE_PICTURE_WIDTH > $this -> PICTURE_WIDTH){
     $CREATE_WIDTH = $FORCE_PICTURE_WIDTH - $this -> FORCE_START_X;
     }else{
     $CREATE_WIDTH = $this -> PICTURE_WIDTH;
     }
 if($FORCE_PICTURE_HEIGHT > $this -> PICTURE_HEIGHT){
     $CREATE_HEIGHT = $FORCE_PICTURE_HEIGHT - $this -> FORCE_START_Y;
     }else{
     $CREATE_HEIGHT = $this -> PICTURE_HEIGHT;
     }
/**
 * 創建一個畫布
 */
 $NEW_PICTURE_CREATE = imagecreatetruecolor($CREATE_WIDTH, $CREATE_HEIGHT);
 $WHITE = imagecolorallocate($NEW_PICTURE_CREATE, 255, 255, 255);
/**
 * 將背景圖拷貝到畫布中
 */
 imagecopy($NEW_PICTURE_CREATE, $this -> PICTURE_CREATE, 0, 0, 0, 0, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);

/**
 * 將目標圖片拷貝到背景圖片上
 */
 imagecopy($NEW_PICTURE_CREATE, $FORCE_PICTURE_CREATE, $this -> FORCE_X, $this -> FORCE_Y, $this -> FORCE_START_X, $this -> FORCE_START_Y, $FORCE_PICTURE_WIDTH, $FORCE_PICTURE_HEIGHT);
 $this -> TRUE_COLOR = $NEW_PICTURE_CREATE;
 }
 # end of mark
function alpha_(){
 $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
 $rgb = "#CDCDCD";
 $tran_color = "#000000";
 for($j = 0;$j <= $this -> PICTURE_HEIGHT-1;$j++){
     for ($i = 0;$i <= $this -> PICTURE_WIDTH-1;$i++)
    {
         $rgb = imagecolorat($this -> PICTURE_CREATE, $i, $j);
         $r = ($rgb >> 16) & 0xFF;
         $g = ($rgb >> 8) & 0xFF;
         $b = $rgb & 0xFF;
         $now_color = imagecolorallocate($this -> PICTURE_CREATE, $r, $g, $b);
         if ($now_color == $tran_color)
        {
             continue;
             }
        else
            {
             $color = imagecolorallocatealpha($this -> PICTURE_CREATE, $r, $g, $b, $ALPHA);
             imagesetpixel($this -> PICTURE_CREATE, $ALPHA_X + $i, $ALPHA_Y + $j, $color);
             }
         $this -> TRUE_COLOR = $this -> PICTURE_CREATE;

         }
     }
 }

/**
 * 圖片旋轉:
 * 沿y軸旋轉
 */
 function turn_y(){
 $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
 for ($x = 0; $x < $this -> PICTURE_WIDTH; $x++)
{
     imagecopy($this -> TRUE_COLOR, $this -> PICTURE_CREATE, $this -> PICTURE_WIDTH - $x - 1, 0, $x, 0, 1, $this -> PICTURE_HEIGHT);
     }
 }
/**
 * 沿X軸旋轉
 */
 function turn_x(){
	 $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
	 for ($y = 0; $y < $this -> PICTURE_HEIGHT; $y++){
		 imagecopy($this -> TRUE_COLOR, $this -> PICTURE_CREATE, 0, $this -> PICTURE_HEIGHT - $y - 1, 0, $y, $this -> PICTURE_WIDTH, 1);
	 }
 }

/**
 * 任意角度旋轉
 */
 function turn(){
	 $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
	 imageCopyResized($this -> TRUE_COLOR, $this -> PICTURE_CREATE, 0, 0, 0, 0, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
	 $WHITE = imagecolorallocate($this -> TRUE_COLOR, 255, 255, 255);
	 $this -> TRUE_COLOR = imagerotate ($this -> TRUE_COLOR, $this -> CIRCUMROTATE, $WHITE);
 }
/**
 * 圖片銳化
 */
 function sharp(){
	 $this -> TRUE_COLOR = imagecreatetruecolor($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
	 $cnt = 0;
	 for ($x = 0; $x < $this -> PICTURE_WIDTH; $x++){
		 for ($y = 0; $y < $this -> PICTURE_HEIGHT; $y++){
			 $src_clr1 = imagecolorsforindex($this -> TRUE_COLOR, imagecolorat($this -> PICTURE_CREATE, $x-1, $y-1));
			 $src_clr2 = imagecolorsforindex($this -> TRUE_COLOR, imagecolorat($this -> PICTURE_CREATE, $x, $y));
			 $r = intval($src_clr2["red"] + $this -> SHARP * ($src_clr2["red"] - $src_clr1["red"]));
			 $g = intval($src_clr2["green"] + $this -> SHARP * ($src_clr2["green"] - $src_clr1["green"]));
			 $b = intval($src_clr2["blue"] + $this -> SHARP * ($src_clr2["blue"] - $src_clr1["blue"]));
			 $r = min(255, max($r, 0));
			 $g = min(255, max($g, 0));
			 $b = min(255, max($b, 0));
			 if (($DST_CLR = imagecolorexact($this -> PICTURE_CREATE, $r, $g, $b)) == -1)
				 $DST_CLR = imagecolorallocate($this -> PICTURE_CREATE, $r, $g, $b);
			 $cnt++;
			 if ($DST_CLR == -1) die("color  allocate  faile  at  $x,  $y  ($cnt).");
			 imagesetpixel($this -> TRUE_COLOR, $x, $y, $DST_CLR);
		}
	}
 }
/**
 * 將圖片反色處理??
 */
 function return_color(){
/**
 * 創建一個畫布
 */
 $NEW_PICTURE_CREATE = imagecreate($this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
 $WHITE = imagecolorallocate($NEW_PICTURE_CREATE, 255, 255, 255);
/**
 * 將背景圖拷貝到畫布中
 */
 imagecopy($NEW_PICTURE_CREATE, $this -> PICTURE_CREATE, 0, 0, 0, 0, $this -> PICTURE_WIDTH, $this -> PICTURE_HEIGHT);
 $this -> TRUE_COLOR = $NEW_PICTURE_CREATE;
 }

/**
 * 生成目標圖片並顯示
 */
 function show(){
 // 判斷瀏覽器,若是IE就不發送頭
if(isset($_SERVER['HTTP_USER_AGENT']))
    {
     $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
     if(!preg_match('/^.*MSIE.*\)$/i', $ua))
        {
         header("Content-type:$this->PICTURE_MIME");
         }
     }
 $OUT = $this -> PICTURE_TYPE;
 $OUT($this -> TRUE_COLOR);
 }

/**
 * 生成目標圖片並保存
 */
 function save_picture(){
 // 以 JPEG 格式將圖像輸出到瀏覽器或文件
$OUT = $this -> PICTURE_TYPE;
 if(function_exists($OUT)){
     // 判斷瀏覽器,若是IE就不發送頭
    if(isset($_SERVER['HTTP_USER_AGENT']))
        {
         $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
         if(!preg_match('/^.*MSIE.*\)$/i', $ua))
            {
             header("Content-type:$this->PICTURE_MIME");
             }
         }
     if(!$this -> TRUE_COLOR){
         exit($this -> ERROR['unavilable']);
         }else{
         $OUT($this -> TRUE_COLOR, $this -> DEST_URL);
         $OUT($this -> TRUE_COLOR);
         }
     }
 }
/**
 * 析構函數：釋放圖片
 */
 function __destruct(){
/**
 * 釋放圖片
 */
 imagedestroy($this -> TRUE_COLOR);
 imagedestroy($this -> PICTURE_CREATE);
 }
 # end of class
}
?>
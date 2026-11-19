<?php
/*
* desc: Resize Image(png, jpg, gif)
* author: 十年後的盧哥哥
* date: 2014.11.13
*/
class ResizeImage {
	//圖片型別
	private $type;
	//實際寬度
	private $width;
	//實際高度
	private $height;
	//改變後的寬度
	private $resize_width;
	//改變後的高度
	private $resize_height;
	//是否裁圖
	private $cut;
	//源圖象
	private $srcimg;
	//目標圖象地址
	private $dstimg;
	//臨時建立的圖象
	private $im;
	function __construct($imgPath, $width, $height, $isCut=false, $savePath) {
		$this->srcimg = $imgPath;
		$this->resize_width = $width;
		$this->resize_height = $height;
		$this->cut = $isCut;
		//圖片的型別
		$this->type = strtolower(substr(strrchr($this->srcimg,"."),1));
		//初始化圖象
		$this->initi_img();
		//目標圖象地址
		$this -> dst_img($savePath);
		//--
		$this->width = imagesx($this->im);
		$this->height = imagesy($this->im);
		//生成圖象
		$this->newimg();
		ImageDestroy ($this->im);
	}
	private function newimg() {
		//改變後的圖象的比例
		$resize_ratio = ($this->resize_width)/($this->resize_height);
		//實際圖象的比例
		$ratio = ($this->width)/($this->height);
		if($this->cut) {
			//裁圖
			$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
			if($this->type=="png") {
				imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
			}
			if($ratio>=$resize_ratio) {
				//高度優先
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
			} else {
				//寬度優先
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
			}
		} else {
			//不裁圖
			if($ratio>=$resize_ratio) {
				$newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
				if($this->type=="png") {
				imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
				}
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
			} else {
				$newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
				if($this->type=="png") {
					imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
				}
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
			}
		}
		if($this->type=="png") {
			imagesavealpha($newimg, true);
			imagepng ($newimg,$this->dstimg);
		} else {
			imagejpeg ($newimg,$this->dstimg);
		}
	}
	//初始化圖象
	private function initi_img() {
		if($this->type=="jpg") {
			$this->im = imagecreatefromjpeg($this->srcimg);
		}
		if($this->type=="gif") {
			$this->im = imagecreatefromgif($this->srcimg);
		}
		if($this->type=="png") {
			$this->im = imagecreatefrompng($this->srcimg);
		}
	}
	//圖象目標地址
	private function dst_img($dstpath) {
		$full_length = strlen($this->srcimg);
		$type_length = strlen($this->type);
		$name_length = $full_length-$type_length;
		$name     = substr($this->srcimg,0,$name_length-1);
		$this->dstimg = $dstpath;
	}
}
?>

<?php
function SqlFilter($content,$strType){
	//函數功能：過濾字符參數中的單引號，對於數字參數進行判斷，如果不是數值類型，則賦值-1
	//參數意義：  str        ---- 要過濾的參數
	// strType ---- 參數類型，分為字符型和數字型，字符型為"str"，數字型為"int"
	$strTmp = '';
	switch($strType){
		case "str" :
			if (is_string($content) || is_numeric($content)){
				$conn = sql_conn();
				$strTmp = xss_clean($content);
				$strTmp = htmlspecialchars($strTmp,ENT_QUOTES);
				$strTmp = mysqli_real_escape_string($conn,$strTmp);
				$strTmp = xssafe($strTmp);
			}
			break;
		case "tab" :
			if (is_string($content) || is_numeric($content)){			
			$strTmp = Trim($content);
			$strTmp = str_ireplace("\\", "\\\\", $strTmp);
			$strTmp = str_ireplace("'", "\'", $strTmp);
			// Remove javascript: and vbscript: protocols
			$strTmp = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $strTmp);
			$strTmp = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $strTmp);
			$strTmp = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $strTmp);			
			}
			break;
		case "int" :
			if (!is_numeric($content)|| empty($content)){
				$strTmp = 0;
			}Else{
				$strTmp = $content;
			}
			break;
	}	
	return $strTmp;
}

function xssafe($data,$encoding='UTF-8')
{
   return htmlspecialchars($data,ENT_QUOTES | ENT_HTML401,$encoding);
}

function xss_clean($data)
{
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	// we are done...
	return $data;
}

Function DelFile($sFileName){
	//函數功能：刪除檔案
	//參數意義：檔案名稱

	//判斷檔案是否存在
	if(is_file($sFileName)){
		unlink($sFileName);
	}
}

//檢查E-Mail格式是否正確
function CheckMail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//檢查網址格式是否正確
function CheckURL($url)
{
    $check = 0;
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
      $check = 1;
    }
    return $check;
}

//檢查身份證字號
function Checkid($id){
	$id = strtoupper($id);
	//建立字母分數陣列
	$headPoint = array(
		'A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
		'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
		'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
		'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
		'Y'=>12,'Z'=>30
	);
	//建立加權基數陣列
	$multiply = array(8,7,6,5,4,3,2,1);
	//檢查身份字格式是否正確
	if (preg_match("/^[a-zA-Z][1-2][0-9]+$/",$id) && strlen($id) == 10 && $id != 'A123456789'){
		//切開字串
		$len = strlen($id);
		for($i=0; $i<$len; $i++){
			$stringArray[$i] = substr($id,$i,1);
		}
		//取得字母分數
		$total = $headPoint[array_shift($stringArray)];
		//取得比對碼
		$point = array_pop($stringArray);
		//取得數字分數
		$len = count($stringArray);
		for($j=0; $j<$len; $j++){
			$total += $stringArray[$j]*$multiply[$j];
		}
		//計算餘數碼並比對
		$last = (($total%10) == 0 )?0:(10-($total%10));
		if ($last != $point) {
			return false;
		} else {
			return true;
		}
	}  else {
	   return false;
	}
}

//檢查居留證
function chkPassport($id)
{
	if(!$id){
		return false;
	}
    $id = strtoupper(trim($id)); //將英文字母全部轉成大寫，消除前後空白
    //檢查第一個字母是否為英文字，第二個字元1 2 A~D 其餘為數字共十碼
    $ereg_pattern= "/^[A-Z]{1}[12ABCD]{1}[[:digit:]]{8}$/";
    if(!preg_match($ereg_pattern, $id)){
		return false;
	}
    $wd_str="BAKJHGFEDCNMLVUTSRQPZWYX0000OI";   //關鍵在這行字串
    $d1=strpos($wd_str, $id[0])%10;
    $sum=0;
    if($id[1]>='A'){
		$id[1]=ord($id[1])-65; //第2碼非數字轉換依[4]說明處理
	}
    for($ii=1;$ii<9;$ii++){
		$sum += (int)$id[$ii]*(9-$ii);
	}        
    $sum += $d1 + (int)$id[9];
    if($sum%10 != 0){
		return false;
	}else{
		return true;
	}    
}

// 前面位數補0
Function AddZero($strNumber){
	Return sprintf("%02d", $strNumber);
}

//依自定字數取得網頁檔名
function GetPage($inum){
	$pageName = end(explode('/', $_SERVER['REQUEST_URI']));
	$pageName = substr($pageName, 0, $inum).'.php';
	return $pageName ;
}

function right($value, $count){
	return mb_substr($value,mb_strlen($value,'utf-8')-$count,$count,"UTF-8");
}

function left($string, $count){
    return mb_substr($string,0,$count,"UTF-8");
}

function mid($string,$start,$length){
	return mb_substr($string,$start,$length,"utf-8");
}

class recordset
{
	var $result ;
	var $record_count ;
	var $position ;
	var $eof ;
	var $page_size ;
	var $conn;

	function __construct($sql )
	{			 
		$this->conn = sql_conn();
		$this->result = mysqli_query($this->conn, $sql ) ;
		$this->record_count = mysqli_num_rows($this->result ) ;
		$this->position = 0 ;
		$this->page_size = -1 ;
		$this->eof = ( $this->record_count == 0 ) ? true : false ;
	}

	function absolutepage( $Page )
	{
		$this->position = $this->page_size * ( $Page - 1 ) ;
	}

	function page_count()
	{
		$return_value = $this->record_count / $this->page_size ;

		if( $this->record_count % $this->page_size > 0 ) $return_value ++ ;

		return $return_value ;
	}

	function move( $position )
	{
		$this->position = $position ;

		if( $this->position >= $this->record_count ) $this->eof = true ;
	}

	function movenext()
	{
			$this->position ++ ;

			if( $this->position >= $this->record_count ) $this->eof = true ;
	}

	function movefirst()
	{
			$this->position = 0 ;

			if( $this->record_count == 0 ) $this->eof = true ;
			else $this->eof = false ;
	}

	function field( $field_name)
	{
		$field_name = strtolower($field_name);
		if( $this->eof )
		{
			return "" ;
		}
		else
		{
			mysqli_data_seek($this->result,$this->position);
			$line = array_change_key_case(mysqli_fetch_array($this->result,MYSQLI_ASSOC));
			return isset($line[$field_name])?$line[$field_name]:false; 
		}
	}
	
	function __destruct()
    {
       mysqli_close($this->conn);
    }
}

function execute_sql( $SQL )
{
	$conn= sql_conn();
	mysqli_query($conn, $SQL ) ;
	return mysqli_insert_id($conn);
}

function alert($message)
{
	echo "<script language=\"javascript\">";
	echo "window.alert(\"" . $message . "\");";
	echo "</script>";
}

function location_href($uurl)
{
	/*Header("HTTP/1.1 303 See Other");
	Header ("Location: ".$uurl);
	exit;*/
	echo "<script language=\"javascript\">";
	echo "location.replace(\"" . $uurl . "\");";
	echo "</script>";
	exit;
}

//驗證字串是否為日期格式
function chkDate($str)
 {
    if (!isset($str) || $str=="")
    {
        return false;
    }
    if (stristr($str,"-"))
    	list($yy,$mm,$dd)=explode("-",$str);
    if (stristr($str,"/"))
    	list($yy,$mm,$dd)=explode("/",$str);
    if ($dd!="" && $mm!="" && $yy!="")
    {
        return checkdate($mm,$dd,$yy);
    }

    return false;
 }

//英文日期格式(yyyy/mm/dd)
Function Date_EN($dtDate,$num){
	if (chkDate($dtDate)){
		switch ($num) {
		case 1:
			$reDate = date("Y/m/d",strtotime($dtDate));
			break;
		case 2:
			$reDate = date("Y-m-d",strtotime($dtDate));
			break;
		case 3:
			$reDate = date("Y.m.d",strtotime($dtDate));
			break;
		case 4:
			$reDate = date("d.m.Y",strtotime($dtDate));
			break;
		case 5:
			$reDate = date("Y/m/d H:i",strtotime($dtDate));
			break;
		case 6:
			$reDate = date("Y/m/d H:i:s",strtotime($dtDate));
			break;
		case 7:
			$reDate = date("m/d",strtotime($dtDate)).'<br />'.date("Y",strtotime($dtDate));
			break;
		case 8:
			$weekday  = date('w', strtotime($dtDate));
			$weeklist = array('日', '一', '二', '三', '四', '五', '六');			
			$reDate = date("m/d",strtotime($dtDate)).'('.$weeklist[$weekday].')';
			break;
		}
		return $reDate;
	}
}

//中文日期格式(yyyy/mm/dd)
Function Date_CH($dtDate,$num){
	if (chkDate($dtDate)){
		switch ($num) {
		case 1:
			$reDate = date("Y",strtotime($dtDate)).'年'.date("m",strtotime($dtDate)).'月'.date("d",strtotime($dtDate)).'日';
			break;
		case 2:
			$reDate = date("Y-m-d",strtotime($dtDate));
			break;
		case 3:
			$reDate = date("Y.m.d",strtotime($dtDate));
			break;
		case 4:
			$reDate = date("d.m.Y",strtotime($dtDate));
			break;
		case 5:
			$reDate = date("Y/m/d H:i",strtotime($dtDate));
			break;
		case 6:
			$reDate = date("Y/m/d H:i:s",strtotime($dtDate));
			break;
		}
		return $reDate;
	}
}

/****模擬sqlserver中的dateadd函數*******
$part 類型：string
取值範圍：year,month,day,hour,min,sec
表示：要增加的日期的哪個部分
$n 類型：數值
表示：要增加多少，根據$part決定增加哪個部分
可為負數
$datetime類型：timestamp
表示：增加的基數
返回 類型：timestamp
**************結束**************/
function dateadd($part,$n,$datetime){
	$year=date("Y",$datetime);
	$month=date("m",$datetime);
	$day=date("d",$datetime);
	$hour=date("H",$datetime);
	$min=date("i",$datetime);
	$sec=date("s",$datetime);
	$part=strtolower($part);
	$ret=0;
	switch ($part) {
	case "year":
		$year+=$n;
		break;
	case "month":
		$month+=$n;
		break;
	case "day":
		$day+=$n;
		break;
	case "hour":
		$hour+=$n;
		break;
	case "min":
		$min+=$n;
		break;
	case "sec":
		$sec+=$n;
		break;
	default:
		return $ret;
		break;
	}
	$ret=mktime($hour,$min,$sec,$month,$day,$year);
	return $ret;
}
//日期相加
function add_date($givendate,$day=0,$mth=0,$yr=0) {
    $cd = strtotime($givendate);
    $newdate = date('Y/m/d h:i:s', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
    return $newdate;
}

//比對前後日期值
function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */

    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds

    switch($interval) {

    case 'yyyy': // Number of full years

        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;

    case "q": // Number of full quarters

        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;

    case "m": // Number of full months

        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;

    case 'y': // Difference between day numbers

        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

    case "d": // Number of full days

        $datediff = floor($difference / 86400);
        break;

    case "w": // Number of full weekdays

        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

    case "ww": // Number of full weeks

        $datediff = floor($difference / 604800);
        break;

    case "h": // Number of full hours

        $datediff = floor($difference / 3600);
        break;

    case "n": // Number of full minutes

        $datediff = floor($difference / 60);
        break;

    default: // Number of full seconds (default)

        $datediff = $difference;
        break;
    }

    return $datediff;

}

//取得當月取後一天
function Lastday($date){
	//得到第一天的,這個很簡單,一看就明白  strtotime()就是把指定的時間轉換成秒,例如strtotime("2007-06-30")
	$firstday = date("Y-m-01",strtotime($date));
	//Date() 函數可把時間戳格式化為可讀性更好的日期和時間。
	return date("Y-m-d",strtotime("$firstday +1 month -1 day"));
}

//壓碼
function addpadding($string, $blocksize = 16){
    $len = strlen($string);
    $pad = $blocksize - ($len % $blocksize);
    $string .= str_repeat(chr($pad), $pad);
    return $string;
}

function EnCode($Value, $SecretKey='45578fGFDe34LghE', $iv='PPkli145Kh675GFR'){ 
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $SecretKey, addpadding($Value), MCRYPT_MODE_CBC, $iv))); 
}
//解碼
function strippadding($string){
    $slast = ord(substr($string, -1));
    $slastc = chr($slast);
    $pcheck = substr($string, -$slast);
    if(preg_match("/$slastc{".$slast."}/", $string)){
        $string = substr($string, 0, strlen($string)-$slast);
        return $string;
    } else {
        return false;
    }
}

function DeCode($Value, $SecretKey='45578fGFDe34LghE', $iv='PPkli145Kh675GFR'){  
    $str = strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $SecretKey, base64_decode($Value), MCRYPT_MODE_CBC, $iv));  
    return $str;
}

// 參數解釋
// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
function Authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    if( $operation == 'DECODE') $string=str_replace(array("-","_"), array('+','/'),$string);
    $ckey_length = 4;
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace(array("=","+","/"), array('','-','_'), base64_encode($result));
    }
}

//回傳遠端網頁內容
function getUrlContent($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;		
}

//更新網頁編輯器內的圖檔符合RWD頁面CSS值
function rwd_width($txt){
 	//$txt = preg_replace('/height="[a-z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
	//$txt = preg_replace('/width="[a-z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
	//$txt = preg_replace('/style="[a-z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
	//$txt = preg_replace('/\.jpg\"/i', '.jpg" class="img-responsive"', $txt);
	//$txt = preg_replace('/\.gif\"/i', '.gif" class="img-responsive"', $txt);
	//$txt = preg_replace('/\.png\"/i', '.png" class="img-responsive"', $txt);
	return $txt;
}

//更新網頁編輯器內的表格符合RWD頁面CSS值
function rwd_table($txt,$num){
	switch($num){
	case 1:
		//$txt = preg_replace('/<table/i','<div class="table-container"><table', $txt);
		//$txt = preg_replace('/<\/table>/','</table></div>', $txt);
		break;
	case 2:
		//$txt = preg_replace('/height="[a-z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
		//$txt = preg_replace('/width="[a-z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
		//$txt = preg_replace('/style="[a-zA-Z0-9:;\.\s\(\)\-\,]*"/i', '', $txt);
		//$txt = preg_replace('/<table /i', '<table class="table shopcart" ', $txt);		
		break;
	}
	$txt = preg_replace('/target="_blank"/i','target="_blank" rel="noopener noreferrer"', $txt);
	return $txt;
}



/***取得會員身份***/
Function Member_Type($num){
	switch ($num) {
		case 1:
			$MType = "教師";
			break;
		case 2:
			$MType = "博土班";
			break;
		case 3:
			$MType = "碩士班";
			break;
		case 4:
			$MType = "大學部";
			break;
		case 5:
			$MType = "外系師生";
			break;
		case 9:
			$MType = "其他";
			break;
	}
	return $MType;
}

/***取得租借教室***/
Function Classroom_Type($num){
	switch ($num) {
		case 1:
			$ClassroomName = "模擬診間(一)";
			break;
		case 2:
			$ClassroomName = "模擬診間(二)";
			break;
		case 3:
			$ClassroomName = "模擬診間(三)";
			break;
		case 4:
			$ClassroomName = "模擬診間(四)";
			break;
		case 5:
			$ClassroomName = "模擬診間(五)";
			break;
		case 6:
			$ClassroomName = "模擬診間(六)";
			break;
		case 7:
			$ClassroomName = "模擬診間(七)";
			break;
		case 8:
			$ClassroomName = "模擬診間(八)";
			break;
		case 9:
			$ClassroomName = "操作教室(一)";
			break;
		case 10:
			$ClassroomName = "操作教室(二)";
			break;
		case 11:
			$ClassroomName = "操作教室(三)";
			break;
		case 12:
			$ClassroomName = "討論室";
			break;
		case 13:
			$ClassroomName = "教學教室";
			break;
		case 14:
			$ClassroomName = "模擬加護病房";
			break;
		case 15:
			$ClassroomName = "模擬開刀房";
			break;
	}
	return $ClassroomName;
}

/***取得教室費用***/
Function Classroom_Charge($num){
	switch ($num) {
		case 1:
			$Charge = 1500;
			break;
		case 2:
			$Charge = 3000;
			break;
		case 3:
			$Charge = 3200;
			break;
		case 4:
			$Charge = 1000;
			break;
		case 5:
			$Charge = 5000;
			break;
		case 6:
			$Charge = 10000;
			break;
	}
	return $Charge;
}

/***取得租借時間***/
Function Rental_Time($num){
	switch ($num) {
		case 1:
			$Rental_Time = "08:00~12:00 AM";
			break;
		case 2:
			$Rental_Time = "13:00~17:00 PM";
			break;
		case 3:
			$Rental_Time = "18:00~22:00 PM";
			break;
	}
	return $Rental_Time;
}

/***取得星期名稱***/
function weekname($num){
	switch($num){
		Case 1:
			$strTxt = "日";//星期日
			break;
		Case 2:
			$strTxt = "一";//星期一
			break;
		Case 3:
			$strTxt = "二";//星期二
			break;
		Case 4:
			$strTxt = "三";//星期三
			break;
		Case 5:
			$strTxt = "四";//星期四
			break;
		Case 6:
			$strTxt = "五";//星期五
			break;
		Case 7:
			$strTxt = "六";//星期六
			break;
	}
	return $strTxt;
}

//清除Html Code
function RemoveHTML($Contents){
	$txt = preg_replace('/<[^>]*>/', '', $Contents);
	$txt=str_ireplace("\r\n","",$txt);
	$txt=str_ireplace(" ","",$txt);
	return $txt;
}

//清除手機 Code
function RemoveMobile($Contents){
	$arr = array("+","-");
	$txt = str_replace($arr,"",$Contents);
	return $txt;
}

//N個字元間插入其它字元
function mbstringtoarray($str,$cut_len,$charset="UTF-8",$inter="/") { 
	$strlen=mb_strlen($str,$charset); 
	$array=array();
	while($strlen){ 
		$array[]=mb_substr($str,0,$cut_len,$charset); 
		$str=mb_substr($str,$cut_len,$strlen-$cut_len,$charset); 
		$strlen=mb_strlen($str,$charset);
	} 
	return implode($inter,$array); 
}

//Get the real client IP ("bullet-proof")
function GetIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
   return($ip);
}

//發送信件
function SendMail($SendName, $SendMail,$FromName, $FromMail, $Subject, $MailBody){//(收件者,收件信箱,寄件者,寄件信箱,主旨,內文)
	//連到遠端主機發送信件 Open
	$base_url = 'http://webmail.tsg.com.tw/mail.php';
	$data = [
		'WebUrl' => RootURL($_SERVER['PHP_SELF']).$_SERVER["REQUEST_URI"],//主機
		'FromName' => $FromName,//寄件者
		'FromMail' => $FromMail,//寄件信箱
		'toName' => $SendName,//收件者
		'toMail' => $SendMail,//收件信箱，要發送到多組信箱時，mail請使用;分隔
		'Subject' => $Subject,//主旨
		'MailBody' => $MailBody//內文
	];

	$header = [
		'Content-Type: application/json',
	];
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $base_url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, true);
	$result = curl_exec($curl);
	curl_close($curl);	
}

Function chkMobile($tel){
	//判斷手機號碼是否正確	
	if(preg_match("/09+[0-9]{8}$/",str_ireplace("-","",$tel)))
		return true;
	else
		return false;
}

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

//產生GUID值
function getGUID($num){
    if (function_exists('com_create_guid')){
        $uuid = com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        //return $uuid;
    }
    $uuid = str_replace("-","",$uuid);
    return substr($uuid,1,$num);
}

//取出網站目錄
function RootURL($str){
	$link = explode('/', $str);
	for ($i=0;$i<count($link);$i++){	
		if ($link[$i]=='manage' || $link[$i]=='en' || $link[$i]=='tc' || $i==count($link)-1){
			break;
		}
		$url .=$link[$i].'/';
	}
	if($_SERVER['HTTPS']=="on"){
		return "https://".$_SERVER['HTTP_HOST'].$url;
	}else{
		return "http://".$_SERVER['HTTP_HOST'].$url;
	}	
}

//取出網站實體目錄
function RootForder($str){
	if(stripos($str,'\\') > 0){
		$link = explode('\\', $str);
	}else{
		$link = explode('/', $str);
	}
	
	for ($i=0;$i<count($link);$i++){	
		if ($link[$i]=='manage' || $link[$i]=='en' || $link[$i]=='tc' || $i==count($link)-1){
			break;
		}
		$forder .=$link[$i].'/';
	}	
	return $forder;
}

//取使用者IP
function UserIP(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
   return($ip);
}

//判斷IP資料
function ip_info(){
	$ch = curl_init();
	$timeout = 5;
	$ip = UserIP();
	$url = "http://ip-api.com/php/{$ip}";
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch); //網站回傳的數據，型態為字串
	curl_close($ch);
	//寫入記錄
    $SQL_U = "Insert into ip_log Set ";
	$SQL_U .= " strLink = '".$_SERVER['PHP_SELF']."',";
	$SQL_U .= " Contents = '".SqlFilter($data,'tab')."',";
	$SQL_U .= " UserIP = '".SqlFilter($ip,'tab')."',";
	$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."' ";
	execute_sql($SQL_U);
	
	$left = stripos($data,'{');
	$right = strripos($data,'}');
	$iplist = mb_substr($data,$left+1,$right-$left-2,'utf-8');	
	return explode(';',$iplist);
}

function ip_country($str,$ip_info){
	$flag = false;
	foreach ($ip_info as $ip) {
		if(stripos($ip,$str)){
			$flag = true;
			break;
		}
	}
	return $flag;
}

function product_history($Product_PKey,$Product_Name,$SqlCommand,$strLink,$UserID){
	$ip = UserIP();
	//寫入記錄
    $SQL_U = "Insert into product_h Set ";
	$SQL_U .= " Product_PKey = '".SqlFilter($Product_PKey,'tab')."',";
	$SQL_U .= " Product_Name = '".SqlFilter($Product_Name,'tab')."',";
	$SQL_U .= " strLink = '".SqlFilter($strLink,'tab')."',";
	$SQL_U .= " SqlCommand = '".SqlFilter($SqlCommand,'tab')."',";
	$SQL_U .= " UserIP = '".SqlFilter($ip,'tab')."',";
	$SQL_U .= " UserID = '".SqlFilter($UserID,'tab')."',";
	$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."' ";
	execute_sql($SQL_U);
}

function member_history($Member_PKey,$Member_Name,$SqlCommand,$strLink,$UserID){
	$ip = UserIP();
	//寫入記錄
    $SQL_U = "Insert into member_h Set ";
	$SQL_U .= " Member_PKey = '".SqlFilter($Member_PKey,'tab')."',";
	$SQL_U .= " Member_Name = '".SqlFilter($Member_Name,'tab')."',";
	$SQL_U .= " strLink = '".SqlFilter($strLink,'tab')."',";
	$SQL_U .= " SqlCommand = '".SqlFilter($SqlCommand,'tab')."',";
	$SQL_U .= " UserIP = '".SqlFilter($ip,'tab')."',";
	$SQL_U .= " UserID = '".SqlFilter($UserID,'tab')."',";
	$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."' ";
	execute_sql($SQL_U);
}

function manage_history($Module_PKey,$Module_Name,$SqlCommand,$strLink,$UserID){
	$ip = UserIP();
	//寫入記錄
    $SQL_U = "Insert into managelog Set ";
	$SQL_U .= " Module_PKey = '".SqlFilter($Module_PKey,'int')."',";
	$SQL_U .= " Module_Name = '".SqlFilter($Module_Name,'tab')."',";
	$SQL_U .= " strLink = '".SqlFilter($strLink,'tab')."',";
	$SQL_U .= " SqlCommand = '".SqlFilter($SqlCommand,'tab')."',";
	$SQL_U .= " UserIP = '".SqlFilter($ip,'tab')."',";
	$SQL_U .= " UserID = '".SqlFilter($UserID,'tab')."',";
	$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."' ";
	execute_sql($SQL_U);
}

//產生每月上傳檔案目錄
function makedirs($dirpath, $mode=0775) {
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	clearstatcache();
}

//回傳檔案年月值
function monthforder($str){
	$forder = explode('_',$str);
	$forder = left($forder[1],6).'/';
	return $forder;
}

//判斷是否允許刪除列表資料
function chkTable($name){
	$flag = false;
	$sql = "Select TABLE_NAME from information_schema.tables Where TABLE_NAME = '".SqlFilter($name,'str')."' ";
	$rs = new recordset($sql);
	if(! $rs->eof){
		$flag = true;
	}
	return $flag;
}

/*
*function：檢查字符串是否由纯英文，纯中文，中英文混合组成
*param string
*return 1:纯英文;2:纯中文;3:中英文混合
*/
function check_str($str=''){
    $string = array(0,0);
	$eng = 0;
	$zhtw = 0;
	$length = 0;
    $m=mb_strlen($str,'utf-8');
    $s=strlen($str);
    if($s==$m){
        $string[0] = 1;	
        $string[1] = $s;
    }else{
		if($s%$m==0&&$s%3==0){
			$string[0] = 2;	
			$string[1] = $m;
		}		
	}
	return $string;
}
?>
<? require_once("../_inc.php");?>
<?
	$ModuleNo = 1;
	
	//參數解碼
	if ($_REQUEST["PKey"] <> ""){
		$Update_PKey = authcode($_REQUEST["PKey"],'DECODE');
	}
	
	/***表單檔案驗證***/
	if ($_REQUEST['Submit'] == "送出"){

		$MSG = "";
	
		/*檢查馬上刊登是否被選取*/
		/*馬上刊登被選取時刊登日期預設為當天*/
		if ($_POST['NoOpenDate'] == 0){
			$OpenDate = date("Y/m/d");
		}else{
			$OpenDate = $_POST['OpenDate'];
		}
	
		/*檢查下架日期無是否被選取*/
		/*檢查下架日期無被選取時下架日期預設為西元年+10*/
		if ($_POST['NoEndDate'] == 0){
			$EndDate = date("Y/m/d",mktime(0,0,0,date("m"),date("d"),date("Y")+10));
		}else{
			$EndDate = $_POST['EndDate'];
		}
		
		if (strLen($OpenDate) == 0 || strLen($EndDate) == 0){
			$MSG .= "【刊登日期】或【下架日期】請勿空白\n";
		}else{
			if(datediff('day',$OpenDate,$EndDate) < 0){
				$MSG .= "【刊登日期大於下架日期】\\n";
			}
		}
			
		/*判斷順序*/
		if (is_numeric($_POST['Sort'])==false){
			$MSG .= "【順序】空白或非數字格式!\\n";
		}
		
		/*判斷主要類別*/
		if (strLen($_POST['Class1']) == 0){
			$MSG .= "【主要活動類別】請選擇!\\n";
		}
		
		/*判斷類別*/
		if (strLen($_POST['Class2']) == 0){
			$MSG .= "【活動類別】請選擇!\\n";
		}
		
		/*判斷標題*/
		if (strLen($_POST['strName']) == 0){
			$MSG .= "【標題】不可空白\\n";
		}
		
		/***判斷資料是否存在(是-更新；否-新增)及圖片處理程式***/
		if ($MSG == ""){
			
			/*****圖片檢查程式(2圖)*****/
			
			// 上傳檔將存入此路徑裡的 uploads 資料夾
			$upload_dir = "../../Upload/news/";
			//檔案前置名
			$ForderName = "news_";
			// 上傳檔總數
			$total_uploads = 2;
			// 上傳檔大小限制，此處限制為600KB
			$size_bytes = 600 * 1024;
			// 副檔名限制
			$limitedext = array(".gif",".jpg",".jpeg",".png");
		
			// 用迴圈讀取上傳檔案資料
			for ($i = 1; $i <= $total_uploads; $i++) {
			   $new_file = $_FILES['Photo'.$i];
			   // 讀取上傳檔名
			   $file_name = $new_file['name'];
				// 把檔名中的空格替換成 "_"
			   $file_name = str_replace(' ', '_', $file_name);
			   // 存入暫存區的檔名
			   $file_tmp = $new_file['tmp_name'];
			   // 檔案大小
			   $file_size = $new_file['size'];
			   // 判斷檔案是否指定上傳檔案…
			   if (is_uploaded_file($file_tmp)) {
				// 若有上傳檔，則取出該檔案的副檔名
				 $ext = strrchr($file_name,'.');
				 // 判斷副檔名是否符合預期
				 if (!in_array(strtolower($ext),$limitedext)) {
					// 不符合預期，顯示錯誤訊息。
					$MSG .="檔案 $i: ($file_name) 的檔案副檔名有誤（只允許GIF和JPEG檔） <br />";
				 }else{
					// 檢查檔案是否太大
				   if ($file_size > $size_bytes){
					   $MSG .="檔案 $i: ($file_name) 無法上傳，請檢查檔案是否小於 ". $size_bytes / 1024 ." KB。<br />";
				   }else{
		
						$file_name = $ForderName. strftime("%Y%m%d%H%M%S").$i.$ext;      //更改上傳的圖檔名稱.
		
						// 放入陣列
						$Photo[$i] = $file_name;       //存入資料庫的 檔案存取路徑
					   if (move_uploaded_file($file_tmp,$upload_dir.$file_name)) {
							// 取得上傳圖片
							$src = getimagesize($upload_dir.$file_name);
							// 取得來源圖片長寬
							$PhotoW[$i] = $src[0];
							$PhotoH[$i] = $src[1];
					   }
				   }
				 }
			   }
			}

			$SQL = "Select * From news Where PKey =".SqlFilter($Update_PKey,"int");
			$DR1 = new recordset($SQL);
			if ($DR1->field("PKey")!=""){
				$News_PKey = $DR1->field("PKey");
				$SQL_U = " Update news set ";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " class1_PKey = '".SqlFilter($_POST['Class1'],"int")."',";
				$SQL_U .= " class2_PKey = '".SqlFilter($_POST['Class2'],"int")."',";
				$SQL_U .= " showindex = '".SqlFilter($_POST['showIndex'],"tab")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " contents1 = '".SqlFilter($_POST['contents1'],"tab")."',";
				$SQL_U .= " youtubeID = '".SqlFilter($_POST['youtubeID'],"tab")."',";
				$SQL_U .= " OpenDate = '".SqlFilter($OpenDate,"tab")."',";
				$SQL_U .= " NoEndDate = '".SqlFilter($_POST['NoEndDate'],"tab")."',";
				$SQL_U .= " EndDate = '".SqlFilter($EndDate,"tab")."',";
				$SQL_U .= " PoName = '".SqlFilter($_SESSION["UserName"],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				$SQL_U .= " Where Pkey =".SqlFilter($Update_PKey,"int");
				execute_sql($SQL_U);
				$show = "修改成功!";
			}
			else{
				$SQL_U = "Insert Into news Set ";
				$SQL_U .= " Sort = '".SqlFilter($_POST['Sort'],"int")."',";
				$SQL_U .= " intLang = '2',";
				$SQL_U .= " class1_PKey = '".SqlFilter($_POST['Class1'],"int")."',";
				$SQL_U .= " class2_PKey = '".SqlFilter($_POST['Class2'],"int")."',";
				$SQL_U .= " showindex = '".SqlFilter($_POST['showIndex'],"tab")."',";
				$SQL_U .= " strName = '".SqlFilter($_POST['strName'],"tab")."',";
				$SQL_U .= " contents1 = '".SqlFilter($_POST['contents1'],"tab")."',";
				$SQL_U .= " youtubeID = '".SqlFilter($_POST['youtubeID'],"tab")."',";
				$SQL_U .= " OpenDate = '".SqlFilter($OpenDate,"tab")."',";
				$SQL_U .= " NoEndDate = '".SqlFilter($_POST['NoEndDate'],"tab")."',";
				$SQL_U .= " EndDate = '".SqlFilter($EndDate,"tab")."',";
				$SQL_U .= " PoName = '".SqlFilter($_SESSION["UserName"],"tab")."',";
				$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
				$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
				$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
				//取出主鍵值
				$News_PKey = execute_sql($SQL_U);
				$show = "新增成功!";
			}
	
			/***寫入圖檔***/
			for ($i = 1; $i <= $total_uploads; $i++) {
				if (strLen($Photo[$i]) > 10){
					
					/*縮圖程式open*/
					$image = new Resize_Image;
					$cropW = 690;/*預設縮圖寬*/
					$cropH = $PhotoH[$i]/($PhotoW[$i]/$cropW);/*預設縮圖高*/
					$image->new_width = $cropW;
					$image->new_height = $cropH;
					
					$image->image_to_resize = $upload_dir.$Photo[$i]; // Full Path to the file
					$image->ratio = true; // Keep Aspect Ratio?
					// Name of the new image (optional) - If it's not set a new will be added automatically
					$image->new_image_name = 's_'.$Photo[$i];//縮圖後檔名
					$image->save_folder = $upload_dir;
					$process = $image->resize();
					//縮圖程式end

					$sql = "Select * From news_img Where News_PKey=".$News_PKey." AND Sort =".$i;
					$rs = new recordset($sql);
					if (!$rs->eof){
						//刪除原始圖檔
						DelFile($upload_dir.$rs->field("Photo1"));
						DelFile($upload_dir.'s_'.$rs->field("Photo1"));
						$SQL_U = " Update news_img set ";
						$SQL_U .= " News_PKey = '".SqlFilter($News_PKey,"int")."',";
						$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
						$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',";
						$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',";
						$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
						$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
						$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
						$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
						$SQL_U .= " Where PKey =".$rs->field("PKey");
					}else{
						$SQL_U = " Insert into news_img set ";
						$SQL_U .= " News_PKey = '".SqlFilter($News_PKey,"int")."',";
						$SQL_U .= " Sort = '".SqlFilter($i,"int")."',";
						$SQL_U .= " Photo1 = '".SqlFilter($Photo[$i],"tab")."',";
						$SQL_U .= " PhotoW1 = '".SqlFilter($PhotoW[$i],"int")."',";
						$SQL_U .= " PhotoH1 = '".SqlFilter($PhotoH[$i],"int")."',";
						$SQL_U .= " UserID ='".SqlFilter($_SESSION['Login_ID'],"tab")."',";
						$SQL_U .= " dtUDate = '".strftime("%Y/%m/%d %H:%M:%S")."',";
						$SQL_U .= " dtDate = '".strftime("%Y/%m/%d %H:%M:%S")."'";
					}
					execute_sql($SQL_U);
				}
			}
			
			//清除Session變數
			unset($_SESSION["Pkey_".$ModuleNo]);
	
			echo "<script language=\"javascript\">" ;
			echo "alert('".$show."');";
			echo "location.href='list.php';";
			echo "</script>";
		}
		else{
			echo "<script language=\"javascript\">" ;
			echo "alert('發生錯誤，請填寫下列欄位\\n".$MSG."');";
			echo "location.href='javascript:history.back()';";
			echo "</script>";
			}
	}
?>
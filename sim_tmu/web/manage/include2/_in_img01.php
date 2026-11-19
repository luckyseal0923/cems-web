<input name="Photo1" type="file" id="Photo1" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo1) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo1;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo1;?>','<?php echo $PhotoW1;?>','<?php echo $PhotoH1;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&pnid=".$pnid."&s_ok=".$s_ok."&fm=".$fm."&ppage=".$ppage."&ppage2=".$ppage2.$search_go_str;?>&motion=del&imgNo=1&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo1HaveUrl == 1 ){
			echo $img_url.$Photo1;
		}
		
	} else {
		echo "[無圖]";	
	}

	if ( $thisPageType == "photo_detail"  ){
		$img_tag_size    = "size=\"20\" ";
	}

	//圖說
	if ( $Photo1HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM1\" type=\"text\" id=\"PhotoM1\" class=\"m-input\" value=\"" . $PhotoM1 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo1_Size != "" ){
		echo "<span class=\"red\">　" . $Photo1_Size . "</span>";
	}
?>
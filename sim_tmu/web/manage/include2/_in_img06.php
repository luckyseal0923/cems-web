<input name="Photo6" type="file" id="Photo6" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo6) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo6;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo6;?>','<?php echo $PhotoW6;?>','<?php echo $PhotoH6;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=6&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo6HaveUrl == 1 ){
			echo $img_url.$Photo6;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo6HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM6\" type=\"text\" id=\"PhotoM6\" value=\"" . $PhotoM6 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo6_Size != "" ){
		echo "<span class=\"red\">　" . $Photo6_Size . "</span>";
	}
?>
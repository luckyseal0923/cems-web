<input name="Photo3" type="file" id="Photo3" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo3) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo3;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo3;?>','<?php echo $PhotoW3;?>','<?php echo $PhotoH3;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=3&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo3HaveUrl == 1 ){
			echo $img_url.$Photo3;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo3HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM3\" type=\"text\" id=\"PhotoM3\" value=\"" . $PhotoM3 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo3_Size != "" ){
		echo "<span class=\"red\">　" . $Photo3_Size . "</span>";
	}
?>
<input name="Photo5" type="file" id="Photo5" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo5) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo5;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo5;?>','<?php echo $PhotoW5;?>','<?php echo $PhotoH5;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=5&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo5HaveUrl == 1 ){
			echo $img_url.$Photo5;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo5HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM5\" type=\"text\" id=\"PhotoM5\" value=\"" . $PhotoM5 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo5_Size != "" ){
		echo "<span class=\"red\">　" . $Photo5_Size . "</span>";
	}
?>
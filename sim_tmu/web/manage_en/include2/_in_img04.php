<input name="Photo4" type="file" id="Photo4" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo4) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo4;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo4;?>','<?php echo $PhotoW4;?>','<?php echo $PhotoH4;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=4&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo4HaveUrl == 1 ){
			echo $img_url.$Photo4;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo4HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM4\" type=\"text\" id=\"PhotoM4\" value=\"" . $PhotoM4 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo4_Size != "" ){
		echo "<span class=\"red\">　" . $Photo4_Size . "</span>";
	}
?>
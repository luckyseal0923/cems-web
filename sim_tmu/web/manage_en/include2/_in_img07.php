<input name="Photo7" type="file" id="Photo7" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo7) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo7;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo7;?>','<?php echo $PhotoW7;?>','<?php echo $PhotoH7;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=7&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo7HaveUrl == 1 ){
			echo $img_url.$Photo7;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo7HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM7\" type=\"text\" id=\"PhotoM7\" value=\"" . $PhotoM7 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo7_Size != "" ){
		echo "<span class=\"red\">　" . $Photo7_Size . "</span>";
	}
?>
<input name="Photo2" type="file" id="Photo2" <?php echo $file_tag_size;?> />
<?php
	if ( strLen($Photo2) > 4 ){
?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo2;?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 . $Photo2;?>','<?php echo $PhotoW2;?>','<?php echo $PhotoH2;?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=2&act_type=pic';}else{return false;}">刪</a>]
<?php
		//顯示檔案位置
		if ( $Photo2HaveUrl == 1 ){
			echo $img_url.$Photo2;
		}
		
	} else {
		echo "[無圖]";	
	}
	
	//圖說
	if ( $Photo2HaveTxt == 1 ){
		echo "　圖說：<input name=\"PhotoM2\" type=\"text\" id=\"PhotoM2\" value=\"" . $PhotoM2 . "\" " . $img_tag_size . " maxlength=\"255\">";
	}
	
	//顯示建議尺寸文字
	if ( $Photo2_Size != "" ){
		echo "<span class=\"red\">　" . $Photo2_Size . "</span>";
	}
?>
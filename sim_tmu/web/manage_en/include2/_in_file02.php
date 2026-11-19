<table border="0" cellspacing="0" cellpadding="2">
 <?php if( $file2HaveName == 1 ){ ?>
 <tr>
   <td align="left" valign="top" nowrap="nowrap" style="padding-left:53px;">名稱：</td>
   <td><input name="FileName2" type="text" id="FileName2" class="m-input" value="<?php echo $FileName2;?>" maxlength="20" /></td>
 </tr>
 <?php } ?>
 <tr>
	<td width="100" valign="top" nowrap="nowrap"><input name="FileType2" type="radio" id="FileType2" value="0" <?php if( $FileType2 == 0 ){ echo "checked=\"checked\"";} ?>>
     連結網址：</td>
	<td>
	<input name="FileLink2" type="text" id="FileLink2" class="m-input" value="<?php echo $FileLink2;?>" onfocus="setCheckedValue(document.forms['form1'].elements['FileType2'], '0');" size="70" maxlength="255">
    <?php echo $t_link2;?>
    <?php if( $file2HaveSize == 1 ){ ?><br>Size：<input name="FileSize2" type="text" id="FileSize2" class="m-input" value="<?php echo $FileSize2;?>" size="10" maxlength="50"><?php echo $remark_fileSize;?><?php } ?>
    </td>
 </tr>
 <tr>
   <td width="100" nowrap="nowrap"><input type="radio" name="FileType2" id="FileType2" value="1" <?php if( $FileType2 == 1 ){ echo "checked=\"checked\"";} ?>>
     上傳檔案：</td>
   <td>
    <input name="File2" type="file" id="File2" <?php echo $file_tag_size;?> onfocus="setCheckedValue(document.forms['form1'].elements['FileType2'], '1');" />
    <?php if(strLen($File2) > 4){?>
    ---
    [<a href="<?php echo $uploadUrl1.$File2;?>" target="_blank" class="red">預覽</a>]
    [<a href="#" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=2&act_type=file';}else{return false;}">刪</a>]
    <?php }else{ ?>
    [無檔案]
    <?php } ?>
   </td>
 </tr>
</table>
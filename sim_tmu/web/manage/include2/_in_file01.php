<table border="0" cellspacing="0" cellpadding="2">
 <?php if( $file1HaveName == 1 ){ ?>
 <tr>
   <td align="left" valign="top" nowrap="nowrap" style="padding-left:53px;">名稱：</td>
   <td><input name="FileName1" type="text" id="FileName1" class="m-input" value="<?php echo $FileName1;?>" maxlength="20" /></td>
 </tr>
 <?php } ?>
 <tr>
	<td width="100" valign="top" nowrap="nowrap"><input name="FileType1" type="radio" id="FileType1" value="0" <?php if( $FileType1 == 0 ){ echo "checked=\"checked\"";} ?>>
     連結網址：</td>
	<td>
	<input name="FileLink1" type="text" id="FileLink1" class="m-input" value="<?php echo $FileLink1;?>" onfocus="setCheckedValue(document.forms['form1'].elements['FileType1'], '0');" size="70" maxlength="255">
    <?php echo $t_link2;?>
    <?php if( $file1HaveSize == 1 ){ ?><br>Size：<input name="FileSize1" type="text" id="FileSize1" class="m-input" value="<?php echo $FileSize1;?>" size="10" maxlength="50"><?php echo $remark_fileSize;?><?php } ?>
    </td>
 </tr>
 <tr>
   <td nowrap="nowrap"><input type="radio" name="FileType1" id="FileType1" value="1" <?php if( $FileType1 == 1 ){ echo "checked=\"checked\"";} ?>>
     上傳檔案：</td>
   <td>
    <input name="File1" type="file" id="File1" <?php echo $file_tag_size;?> onfocus="setCheckedValue(document.forms['form1'].elements['FileType1'], '1');" />
    <?php if( strLen($File1) > 4 ){?>
    ---
    [<a href="<?php echo $uploadUrl1.$File1;?>" target="_blank" class="red">預覽</a>]
    [<a href="#" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=1&act_type=file';}else{return false;}">刪</a>]
    <?php }else{ ?>
    [無檔案]
    <?php } ?>
   </td>
 </tr>
</table>
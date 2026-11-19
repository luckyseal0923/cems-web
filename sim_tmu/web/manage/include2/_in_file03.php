<table border="0" cellspacing="0" cellpadding="2">
 <?php if( $file3HaveName==1 ){ ?>
 <tr>
   <td align="left" valign="top" nowrap="nowrap" class="line-d" style="padding-left:53px;">名稱：</td>
   <td class="line-d"><input name="FileName3" type="text" id="FileName3" value="<?php echo $FileName3;?>" maxlength="20" /></td>
 </tr>
 <?php } ?>
 <tr>
	<td width="100" valign="top" nowrap="nowrap" class="line-d"><input name="FileType3" type="radio" id="FileType3" value="0" <?php if($FileType3==0) {echo "checked=\"checked\"";}?>>
	連結網址：</td>
	<td class="line-d">
	<input name="FileLink3" type="text" id="FileLink3" value="<?php echo $FileLink3;?>" onfocus="setCheckedValue(document.forms['form1'].elements['FileType3'], '0');" size="70" maxlength="255">
    <?php echo $t_link2;?>
	<?php if( $file3HaveSize==1 ){ ?><br>Size：<input name="FileSize3" type="text" id="FileSize3" value="<?php echo $FileSize3;?>" size="10" maxlength="50"><?php echo $remark_fileSize;?><?php } ?>
    </td>
 </tr>
 <tr>
   <td width="100" nowrap="nowrap"><input type="radio" name="FileType3" id="FileType3" value="1" <?php if($FileType3==1) {echo "checked=\"checked\"";}?>>
     上傳檔案：</td>
   <td>
    <input name="File3" type="file" id="File3" <?php echo $file_tag_size ?> onfocus="setCheckedValue(document.forms['form1'].elements['FileType3'], '1');" />
    <?php if(strLen($File3) > 4){?>
    ---
    [<a href="<?php echo $uploadUrl1.$File3 ?>" target="_blank" class="red">預覽</a>]
    [<a href="#" class="red" onClick="if(confirm('<?php echo $warn_del1 ?>')){location.href='<?php echo $_SERVER['PHP_SELF']?>?nid=<?php echo $_SESSION["PKey_".$ModuleNo];?>&s_ok=<?php echo $s_ok ?>&fm=<?php echo $fm ?><?php echo $search_go_str ?>&ppage=<?php echo $ppage ?>&motion=del&imgNo=3&act_type=file';}else{return false;}">刪</a>]
    <?php } else { ?>
    [無檔案]
    <?php } ?>
   </td>
 </tr>
</table>
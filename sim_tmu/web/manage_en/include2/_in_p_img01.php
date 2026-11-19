<input name="Photo1" type="file" id="Photo1" <?php echo $file_tag_size ?> />
<?php if(strLen($Photo1) > 4){?>
    ---
    [<a href="javascript:;" title="<?php echo $Photo1 ?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1 ?><?php echo $Photo1 ?>','<?php echo $PhotoW1 ?>','<?php echo $PhotoH1 ?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1 ?>')){location.href='<?php echo $_SERVER['PHP_SELF']?>?nid=<?php echo SqlFilter($_SESSION["PKey_".$ModuleNo],"int") ?>&pnid=<?php echo $pnid ?>&s_ok=<?php echo $s_ok ?>&fm=<?php echo $fm ?>&ppage=<?php echo $ppage ?>&ppage2=<?php echo $ppage2 ?><?php echo $search_go_str ?>&motion=del&imgNo=1&act_type=pic';}else{return false;}">刪</a>]

	<?php if ( $Photo1HaveUrl==1 ) { ?>
    	<?php echo $img_url ?><?php echo $Photo1 ?>
    <?php } ?>

<?php } else { ?>
    [無圖]
<?php } ?>

<?php if ( $Photo1HaveTxt==1 ) { ?>
　圖說：<input name="PhotoM1" type="text" id="PhotoM1" value="<?php echo $PhotoM1 ?>" <?php echo $img_tag_size ?> maxlength="255">
<?php } ?>
<?php if ( $Photo1_Size!="" ) { ?><span class="red">　<?php echo $Photo1_Size ?></span><?php } ?>
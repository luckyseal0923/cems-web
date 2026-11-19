<tr>
  <td valign=top nowrap class="line-d0">審核</td>
  <td class="line-d">
  <?php
  	if ( $subitem=="m3-1" ){
		$chk_ok_str = "前台顯示該專案";
		
	}elseif ( $subitem=="m3-4") {
		$chk_ok_str = "專屬企業顯示";
	}
  ?>
  <input type="checkbox" name="chk_ok" id="chk_ok" value="1" <?php if($chk_ok==1) {echo "checked=\"checked\"";}?>>是，審核通過，<?php echo $chk_ok_str ?></td>
</tr>
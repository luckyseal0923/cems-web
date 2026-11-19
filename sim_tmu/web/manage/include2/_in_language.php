<tr>
	<td valign="top" nowrap class="column-th">顯示語系<i class="fa fa-asterisk"></i></td>
	<td>
	<?php
        if ($nid=="" or $nid==0 ){
            //$language_c = 1;
            //$'language_e = 1;
            //$language_th = 1;
        }
    ?>
    <input type="checkbox" name="language_c" value="1"<?php if( $language_c == 1 ){ echo " checked"; } ?>>繁體
    <input type="checkbox" name="language_e" value="1"<?php if( $language_e == 1 ){ echo " checked"; } ?>>英文
	</td>
</tr>
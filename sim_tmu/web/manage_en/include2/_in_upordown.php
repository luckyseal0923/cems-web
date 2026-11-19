<tr>
	<td class="column-th"><?php echo $t_show_item ?></td>
	<td>
    <select name="upordown" id="upordown" class="m-select">
      <option value="1" <?php if ($upordown==1){ echo "selected=\"selected\"";}?>>上架</option>
      <option value="0" <?php if ($upordown==0){ echo "selected=\"selected\"";}?>>下架</option>
    </select>
	</td>
</tr>
上下架：
<select name="list_upordown" id="list_upordown" class="m-select">
    <option value="" >全部顯示</option>
    <option value="1" <?php if ($list_upordown=="1"){ echo "selected=\"selected\"";}?>>上架</option>
    <option value="0" <?php if ($list_upordown=="0"){ echo "selected=\"selected\"";}?>>下架</option>
</select>
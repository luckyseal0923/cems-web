<select name="birth_y" id="birth_y" class="input1">
    <option value="">請選擇</option>
    <?php
        for ($i=1931;$i<=date("Y");$i++){
    ?>
    <option value="<?php echo $i ?>" <?php if(strval($birth_y)==strval($i)) {echo "selected=\"selected\"";} ?>><?php echo $i ?></option>
    <?php	}  ?>
</select>年　

<select name="birth_m" id="birth_m" class="input1">
    <option value="">請選擇</option>
    <?php
        for ($i=1;$i<=12;$i++){
    ?>
    <option value="<?php echo AddZero($i) ?>" <?php if(strval($birth_m)==strval($i)) {echo "selected=\"selected\"";} ?>><?php echo AddZero($i) ?></option>
    <?php	} ?>
</select>月　

<select name="birth_d" id="birth_d" class="input1">
    <option value="">請選擇</option>
    <?php
        for ($i=1;$i<=31;$i++){
    ?>
  <option value="<?php echo AddZero($i) ?>" <?php if(strval($birth_d)==strval($i)) {echo "selected=\"selected\"";} ?>><?php echo AddZero($i) ?></option>
    <?php	} ?>
</select>日
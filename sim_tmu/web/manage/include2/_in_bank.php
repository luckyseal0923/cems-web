    <select name="bank" id="bank" class="input2">
        <option value="">請選擇</option>
        <?php
            foreach($bank_array as $key => $bank_value){
        ?>
        <option value="<?php echo $bank_value;?>" <?php if(strval($bank)==strval($bank_value)) {echo "selected=\"selected\"";}?>><?php echo get_bank($bank_value);?></option>
        <?php
            }
        ?>
    </select>
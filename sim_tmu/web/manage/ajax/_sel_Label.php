<? require("../_inc.php") ?>
<div style="padding:10px;text-align:left;">熱門標籤：
  <div class="lablist">
      <ul>
        <?php
			$i = 0;
			$sql = "SELECT strName, PKey From dblabel";
			$rs = new recordset($sql);
			while (! $rs->eof){
		  ?>
        <li>
          <input name="labName[]" type="checkbox" value="<?php echo $rs->field("strName")?>">
          <?php echo $rs->field("strName")?></li>
        <?php 
		$rs->movenext();}
		?>
      </ul>
  </div>
  <div class="red" style="margin-top:50px;clear:both">操作說明：選擇標籤，然後按加入按鈕，可一次加入多個標籤。</div>
    <p align="right">
      <input name="AddSel" type="button" class="btn btn-info" id="AddSel" value="加入" onclick="selLabel()" />
      <input name="close" type="button" class="btn btn-info" onclick="closeClass('apDiv')" value="回到編輯頁面" />
    </p>
</div>

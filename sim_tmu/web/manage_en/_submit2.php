<div align="center" style="padding-top:15px;" id="sendadd">
  <input name="toreset" type="reset" class="btn btn-info" value="重設" />
  &nbsp;
  <input name="Submit" type="submit" class="btn btn-info" id="Submit" value="送出" />&nbsp;
  <input name="ColorM" type="submit" class="btn btn-info"  value="繼續管理尺寸顏色數量" id="ColorM" />
  <? if (! stristr($_SERVER["PHP_SELF"],"a.php")) {?>
  <input name="Page" type="hidden" id="Page" value="<?php echo $_REQUEST['Page']?>" />
  <input name="PKey" type="hidden" id="PKey" value="<?php echo $_REQUEST['PKey']?>" />
  <input type="hidden" name="Send" id="Send" />
  <input type="hidden" name="Q_OpenDate" id="Q_OpenDate" value="<? echo $_REQUEST["OpenDate"]?>" />
  <input type="hidden" name="Q_EndDate" id="Q_EndDate" value="<? echo $_REQUEST["EndDate"]?>" />
  <input type="hidden" name="Q_Upload" id="Q_Upload" value="<? echo $_REQUEST["Upload"]?>" />
  <input type="hidden" name="Q_Keywords" id="Q_Keywords" value="<? echo $_REQUEST["Keywords"]?>" />
  <? } ?>
</div>

<div class="m-btnWrap" align="center">
  <input name="Submit" type="submit" class="btn btn-primary m-submit" id="Submit" value="送出" />
  <? if (! stristr($_SERVER["PHP_SELF"],"a.php")) {?>
  <input name="Page" type="hidden" id="Page" value="<?php echo $_REQUEST['Page']?>" />
  <input name="PKey" type="hidden" id="PKey" value="<?php echo authcode($Update_PKey,'ENCODE')?>" />
  <input type="hidden" name="Send" id="Send" />
  <input type="hidden" name="Q_OpenDate" id="Q_OpenDate" value="<? echo $_REQUEST["OpenDate"]?>" />
  <input type="hidden" name="Q_EndDate" id="Q_EndDate" value="<? echo $_REQUEST["EndDate"]?>" />
  <input type="hidden" name="Q_Upload" id="Q_Upload" value="<? echo $_REQUEST["Upload"]?>" />
  <input type="hidden" name="Q_intLocal" id="Q_intLocal" value="<? echo $_REQUEST["intLocal"]?>" />
  <input type="hidden" name="Q_Keywords" id="Q_Keywords" value="<? echo $_REQUEST["Keywords"]?>" />
  <input type="hidden" name="Q_Class1" id="Q_Class1" value="<? echo $_REQUEST["Class1"]?>" />
  <input type="hidden" name="Q_Class2" id="Q_Class2" value="<? echo $_REQUEST["Class2"]?>" />
  <? } ?>
</div>

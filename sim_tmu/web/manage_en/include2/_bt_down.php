<div class="m-btnWrap">
	<?php if ( $mainitem == "m10" ){ ?>
    	<input name="Submit" type="submit" id="Submit" class="btn btn-primary m-submit" value="送出" />
    
    <?php } else { ?>
    	<input name="Submit" type="button" id="Submit" class="btn btn-primary m-submit" value="送出" onclick="sbForm();" />
	<?php } ?>
    
  <?php if( $subitem == "aaaaa" ){ ?>
		<input name="print" type="button" id="print" class="btn btn-primary m-submit" value="列印" onClick="javascript:window.print()" />
    <?php } ?>
    
    <input name="Page" type="hidden" id="Page" value="<?php echo SqlFilter($_REQUEST["Page"],"int");?>" />
    <input name="PKey" type="hidden" id="PKey" value="<?php echo SqlFilter($_REQUEST["PKey"],"int");?>" />
    <input type="hidden" name="Send" id="Send" />
    <input type="hidden" name="Q_OpenDate" id="Q_OpenDate" value="<?php echo SqlFilter($_REQUEST["OpenDate"],"tab");?>" />
    <input type="hidden" name="Q_EndDate" id="Q_EndDate" value="<?php echo SqlFilter($_REQUEST["EndDate"],"tab");?>" />
    <input type="hidden" name="Q_Upload" id="Q_Upload" value="<?php echo SqlFilter($_REQUEST["Upload"],"tab");?>" />
    <input type="hidden" name="Q_Keywords" id="Q_Keywords" value="<?php echo SqlFilter($_REQUEST["Keywords"],"tab");?>" />
<!--m-btnWrap --></div>
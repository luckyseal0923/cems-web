<select name="strCountry" id="strCountry" class="input1" onchange="changeZone(document.form1.strCountry, document.form1.strCity, document.form1.PostCode)">
</select>

<select name="strCity" id="strCity" class="input1" onchange="showZipCode(document.form1.strCountry, document.form1.strCity, document.form1.PostCode)">
</select>
<?php if( $pageName=="p8" ){ echo "<br/><br/>"; } ?>
<input name="PostCode" type="text" class="input1" id="PostCode" value="<?php echo $PostCode ?>" size="2" readonly="readonly" />
<!--<input name="PostCode" type="hidden" id="PostCode" value="<?php echo $PostCode ?>" /> -->
<input name="address" type="text" class="input1" id="address" value="<?php echo $address ?>" size="35" maxlength="100" />
<script type="text/javascript"> 
	initCounty2(document.form1.strCountry,"<?php echo $strCountry ?>");
	initZone2(document.form1.strCountry, document.form1.strCity, document.form1.PostCode,"<?php echo $strCity ?>");
</script>
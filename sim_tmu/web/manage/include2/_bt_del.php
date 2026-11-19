<script>
<?php if ( $thisPageType == "photo_list" ){ ?>
	/*-----------------------------------------*/
	function selectAll(){
		var obj = document.getElementsByName("pnid[]");
		for (var i = 0; i < obj.length; i++){
			obj[i].checked = true;
		}		
	}
	/*-----------------------------------------*/
	function selectNone(){
		var obj = document.getElementsByName("pnid[]");
		for (var i = 0; i < obj.length; i++){
			obj[i].checked = false;
		}		
	}
	/*-----------------------------------------*/
	function delSelect(){
		var obj = document.getElementsByName("pnid[]");
		var flag = false;
		for (var i = 0; i < obj.length; i++){
			if(obj[i].checked){
				flag = true;
				break;
			}
		}
		if(flag){
			if(confirm("<?php echo $warn_del1;?>")){
				document.form1.u.value="del";
				document.form1.submit();
			}
		}else{
			alert("<?php echo $warn_del2;?>");
		}			
	}
	/*-----------------------------------------*/
<?php } else { ?>
	/*-----------------------------------------*/
	function selectAll(){
		var obj = document.getElementsByName("nid[]");
		for (var i = 0; i < obj.length; i++){
			obj[i].checked = true;
		}		
	}
	/*-----------------------------------------*/
	function selectNone(){
		var obj = document.getElementsByName("nid[]");
		for (var i = 0; i < obj.length; i++){
			obj[i].checked = false;
		}		
	}
	/*-----------------------------------------*/
	function delSelect(){
		var obj = document.getElementsByName("nid[]");
		var flag = false;
		for (var i = 0; i < obj.length; i++){
			if(obj[i].checked){
				flag = true;
				break;
			}
		}
		if(flag){
			if(confirm("<?php echo $warn_del1;?>")){
				document.form1.u.value="del";
				document.form1.Action.value="del";
				document.form1.submit();
			}
		}else{
			alert("<?php echo $warn_del2;?>");
		}			
	}
	/*-----------------------------------------*/
<?php } ?>
</script>

<?php if ( $subitem != "aaa" ){ ?>
<input name="button" type="button" id="button" class="btn btn-default" value="全選" onclick="selectAll(this.form);">
<?php } ?>

<?php if ( $subitem != "aaa" ){ ?>
<input name="Del" type="button" id="Del" class="btn btn-default" value="刪除" onclick="delSelect(this.form);">
<?php } ?>

<?php if ( $subitem != "aaa" ){ ?>
<input name="cancel" type="button" id="cancel" class="btn btn-default" value="取消全選" onclick="selectNone(this.form);">
<?php } ?>

<input type="hidden" name="Action" value="">

<?php if ( $show_chg_bt == "1" ){ ?>
<span class="tips" data-tooltip="下方項目順序欄位修改完後，需按下此鈕才會立即變更順序"><input name="bt_chg1" type="button" id="bt_chg1" class="btn btn-info" value="<?php echo $bt_chg1;?>" onclick="sbForm();"></span>
<?php } ?>

<span class="m-ex">-點選以下項目來進行維護</span>
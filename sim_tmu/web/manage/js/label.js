//動態產生規格TR
$(function(){		
	$("#query").focusin(function(){
    //選項說明: http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
    $("#query").autocomplete("../ajax/_Label.php");
   });
   
	$("#Add").click(function(){
		var trTxt;
		var Total;
		var strName = $("#query").val();
		if (strName.length > 0){
			Total = parseInt($("#LabelTotal").val()) +1 ;
        	trTxt = "<li id=label"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delLabel("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Label_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"PKey"+Total+"\" type=\"hidden\" id=\"PKey"+Total+"\" value=\"0\" />";
			trTxt = trTxt + "<input name=\"Label_PKey"+Total+"\" type=\"hidden\" id=\"Label_PKey"+Total+"\" value=\"0\" /></li>";
		}
		$("#query").val("");
		$("#LabelTxt").append(trTxt);
		$("#LabelTotal").val(Total) ;
	})
	
})

function delLabel(index)
{
	Total = parseInt($("#LabelTotal").val());
	var PKey = $("#Label_PKey"+index).val() ;
	//刪除DB
	$.ajax({
		type: "POST",
		url: "../ajax/_del_Label.php",
		data: "PKey="+ PKey,
		success: function(){
		}
	});	
	$("li[id=\'label"+index+"\']").remove();
	$("#LabelTotal").val(Total);
}


//產生標籤選單
function ShowLabel(intClass){
	$.ajax({
		   type: "POST",
		   url: "../ajax/_sel_Label.php",
		   data: "",
		   success: function(html){
			    $("#Label").html(html);//將代碼做為純文本傳入
			  }
		});
	$("#Label").css({display:"block"});
 }
 
//產生標籤選取內容
function selLabel(){
	var obj = document.getElementsByName("labName[]");
	var trTxt="";
	var Total = parseInt($("#LabelTotal").val());
	for (var i = 0; i < obj.length; i++){
		if(obj[i].checked){
			var strName = obj[i].value;
			Total ++ ;
	    	trTxt = trTxt + "<li id=label"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delLabel("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Label_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"PKey"+Total+"\" type=\"hidden\" id=\"PKey"+Total+"\" value=\"0\" />";
			trTxt = trTxt + "<input name=\"Label_PKey"+Total+"\" type=\"hidden\" id=\"Label_PKey"+Total+"\" value=\"0\" /></li>";
		}
	}
	$("#LabelTxt").append(trTxt);
	$("#LabelTotal").val(Total) ;
	$("#Label").css({display:"none"});
 }
 
function closeClass(divName){       
	$("#Label").css({display:"none"});
 } 
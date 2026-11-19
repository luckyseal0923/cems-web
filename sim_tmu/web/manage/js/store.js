//動態產生規格TR
$(function(){		
	$("#Store_Q").focusin(function(){
    //選項說明: http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
    $("#Store_Q").autocomplete("../ajax/_store.php?RType=1");
   });
   
	$("#Store_Add").click(function(){
		var Store_ID = escape($("#Store_Q").val());
		if (Store_ID != ""){
			$.ajax({
				type: "POST",
				url: "../ajax/_Store.php",
				data: "RType=3&Store_ID="+ Store_ID,
				success: function(sText){
					if(sText.indexOf("【") >= 0)
					{		
						alert(sText);
						$("#Store_Q").val("");
					}
					else {
						var str = sText.split("|");
					    PKey = str[0];
					    strName = str[1];
					    strNo = str[2];
					    Store_addtr(PKey,strNo,strName);
					    $("#Store_Q").val("");
					}
				}
			});
		}
	})
})

function delStore(index)
{
	Total = parseInt($("#Store_Total").val());
	var PKey = $("#PKey"+index).val() ;
	var strType = $("#strType").val();
	//刪除DB
	$.ajax({
		type: "POST",
		url: "../ajax/_del_Store.php",
		data: "PKey="+ PKey+"&strType="+strType,
		success: function(){
		}
	});	
	$("li[id=\'Store"+index+"\']").remove();
	$("#Store_Total").val(Total);
}


function Store_addtr(PKey,strNo,strName)
{
	var trTxt;
	var Total;
	Total = parseInt($("#Store_Total").val()) +1 ;
	trTxt = "<li id=Store"+Total+"><span class=\"blue\">"+strNo+"</span> "+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delStore("+(Total)+");}else{return false;}\">-</a>] ";
	trTxt = trTxt + "<input name=\"Store_Name"+Total+"\" type=\"hidden\" id=\"Store_Name"+Total+"\" value=\""+strName+"\" />";
	trTxt = trTxt + "<input name=\"Store_ID"+Total+"\" type=\"hidden\" id=\"Store_ID"+Total+"\" value=\""+strNo+"\" />";
	trTxt = trTxt + "<input name=\"Store_PKey"+Total+"\" type=\"hidden\" id=\"Store_PKey"+Total+"\" value=\""+PKey+"\" />";
	trTxt = trTxt + "<input name=\"PKey"+Total+"\" type=\"hidden\" id=\"PKey"+Total+"\" value=\"0\" /></li>";
	$("#Store_Q").val("");
	$("#Store_Txt").append(trTxt);
	$("#Store_Total").val(Total) ;
}

//產生標籤選單
function ShowStore(intClass){
	$.ajax({
		   type: "POST",
		   url: "../ajax/_sel_Store.php",
		   data: "",
		   success: function(html){
			    $("#StoreList").html(html);//將代碼做為純文本傳入
			  }
		});
	$("#Store").css({display:"block"});
 }
 
//產生標籤選取內容
function selStore(){
	var obj = document.getElementsByName("StoreName[]");
	var trTxt="";
	var Total = parseInt($("#Store_Total").val());
	for (var i = 0; i < obj.length; i++){
		if(obj[i].checked){
			var strName = obj[i].value;
			Total ++ ;
	    	trTxt = trTxt + "<li id=Store"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delStore("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Store_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"Store_PKey"+Total+"\" type=\"hidden\" id=\"Store_PKey"+Total+"\" value=\"0\" /></li>";
		}
	}
	$("#Store_Txt").append(trTxt);
	$("#Store_Total").val(Total) ;
	$("#Store").css({display:"none"});
 }

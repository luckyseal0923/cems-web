//動態產生規格TR
$(function(){		
	$("#Relation_Q").focusin(function(){
    //選項說明: http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
    $("#Relation_Q").autocomplete("../ajax/_product.php?RType=6");
   });
   
	$("#Relation_Add").click(function(){
		var Product_ID = escape($("#Relation_Q").val());
		if (Product_ID != ""){
			$.ajax({
				type: "POST",
				url: "../ajax/_product.php",
				data: "RType=3&Product_ID="+ Product_ID,
				success: function(sText){
					if(sText.indexOf("【") >= 0)
					{		
						alert(sText);
						$("#Relation_Q").val("");
					}
					else {
						var str = sText.split("|");
					    PKey = str[0];
					    strName = str[1];
					    strNo = str[2];
					    Relation_addtr(PKey,strNo,strName);
					    $("#Relation_Q").val("");
					}
				}
			});
		}
	})
})

function delRelation(index)
{
	Total = parseInt($("#Relation_Total").val());
	var PKey = $("#PKey"+index).val() ;
	var strType = $("#strType").val();
	//刪除DB
	$.ajax({
		type: "POST",
		url: "../ajax/_del_Relation.php",
		data: "PKey="+ PKey+"&strType="+strType,
		success: function(){
		}
	});	
	$("li[id=\'relation"+index+"\']").remove();
	$("#Relation_Total").val(Total);
}


function Relation_addtr(PKey,strNo,strName)
{
	var trTxt;
	var Total;
	Total = parseInt($("#Relation_Total").val()) +1 ;
	trTxt = "<li id=relation"+Total+"><span class=\"blue\">"+strNo+"</span> "+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delRelation("+(Total)+");}else{return false;}\">-</a>] ";
	trTxt = trTxt + "<input name=\"Product_Name"+Total+"\" type=\"hidden\" id=\"Product_Name"+Total+"\" value=\""+strName+"\" />";
	trTxt = trTxt + "<input name=\"Product_ID"+Total+"\" type=\"hidden\" id=\"Product_ID"+Total+"\" value=\""+strNo+"\" />";
	trTxt = trTxt + "<input name=\"Product_PKey"+Total+"\" type=\"hidden\" id=\"Product_PKey"+Total+"\" value=\""+PKey+"\" />";
	trTxt = trTxt + "<input name=\"PKey"+Total+"\" type=\"hidden\" id=\"PKey"+Total+"\" value=\"0\" /></li>";
	$("#Relation_Q").val("");
	$("#Relation_Txt").append(trTxt);
	$("#Relation_Total").val(Total) ;
}

//產生標籤選單
function ShowRelation(intClass){
	$.ajax({
		   type: "POST",
		   url: "../ajax/_sel_Relation.php",
		   data: "",
		   success: function(html){
			    $("#RelationList").html(html);//將代碼做為純文本傳入
			  }
		});
	$("#RelationDiv").css({display:"block"});
 }
 
//產生標籤選取內容
function selRelation(){
	var obj = document.getElementsByName("RelationName[]");
	var trTxt="";
	var Total = parseInt($("#Relation_Total").val());
	for (var i = 0; i < obj.length; i++){
		if(obj[i].checked){
			var strName = obj[i].value;
			Total ++ ;
	    	trTxt = trTxt + "<li id=relation"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delRelation("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Relation_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"Relation_PKey"+Total+"\" type=\"hidden\" id=\"Relation_PKey"+Total+"\" value=\"0\" /></li>";
		}
	}
	$("#Relation_Txt").append(trTxt);
	$("#Relation_Total").val(Total) ;
	$("#RelationDiv").css({display:"none"});
 }

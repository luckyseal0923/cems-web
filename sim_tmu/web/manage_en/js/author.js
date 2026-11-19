//動態產生規格TR
$(function(){		
	$("#Author_Q").focusin(function(){
    //選項說明: http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
    $("#Author_Q").autocomplete("../ajax/_Author.php");
   });
   
	$("#Author_Add").click(function(){
		var trTxt;
		var Total;
		var strName = $("#Author_Q").val();
		if (strName.length > 0){
			Total = parseInt($("#Author_Total").val()) +1 ;
        	trTxt = "<li id=Author"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delAuthor("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Author_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"Author_PKey"+Total+"\" type=\"hidden\" id=\"Author_PKey"+Total+"\" value=\"0\" /></li>";
		}
		$("#Author_Q").val("");
		$("#Author_Txt").append(trTxt);
		$("#Author_Total").val(Total) ;
	})
	
})

function delAuthor(index)
{
	Total = parseInt($("#Author_Total").val());
	var PKey = $("#Author_PKey"+index).val() ;
	var strType = $("#strType").val() ;
	//刪除DB
	$.ajax({
		type: "POST",
		url: "../ajax/_del_Author.php",
		data: "PKey="+ PKey+"&strType="+strType,
		success: function(){
		}
	});	
	$("li[id=\'Author"+index+"\']").remove();
	$("#Author_Total").val(Total);
}


//產生標籤選單
function ShowAuthor(intClass){
	$.ajax({
		   type: "POST",
		   url: "../ajax/_sel_Author.php",
		   data: "",
		   success: function(html){
			    $("#Author").html(html);//將代碼做為純文本傳入
			  }
		});
	$("#Author").css({display:"block"});
 }
 
//產生標籤選取內容
function selAuthor(){
	var obj = document.getElementsByName("AuthorName[]");
	var trTxt="";
	var Total = parseInt($("#Author_Total").val());
	for (var i = 0; i < obj.length; i++){
		if(obj[i].checked){
			var strName = obj[i].value;
			Total ++ ;
	    	trTxt = trTxt + "<li id=Author"+Total+">"+strName +" [<a href=\"#\" class=\"red\" onclick=\"if(confirm(\'確定移除關連嗎？\')){delAuthor("+(Total)+");}else{return false;}\">-</a>] ";
			trTxt = trTxt + "<input name=\"Author_Name[]\" type=\"hidden\" value=\""+strName+"\" />";
			trTxt = trTxt + "<input name=\"Author_PKey"+Total+"\" type=\"hidden\" id=\"Author_PKey"+Total+"\" value=\"0\" /></li>";
		}
	}
	$("#Author_Txt").append(trTxt);
	$("#Author_Total").val(Total) ;
	$("#Author").css({display:"none"});
 }

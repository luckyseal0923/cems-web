$(function(){
	$("#Product_ID").focusin(function(){
    //選項說明: http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
    $("#Product_ID").autocomplete("../ajax/_product.php?RType=6");
    $("#Product_ID").result(function (event, data, formatted){
		var Product_ID = data;
		ShowProduct(Product_ID,1);
	}); 
   });
   
   $("#Product_ID").change(function(){
    var Product_ID = $("#Product_ID").val();
	ShowProduct(Product_ID,1);
   });
	
   //動態產生規格TR
   function ShowProduct(Product_ID,inum){
	   	if (Product_ID != ""){
			$.ajax({
				type: "POST",
				url: "../ajax/_product.php",
				data: "RType=7&Product_ID="+ Product_ID,
				success: function(sText){
					var str = sText.split("|");
					if(str < 1)
					{		
						alert(sText);
					}
					else {
						var str = sText.split("|");
					    $("#Product_PKey").val(str[0]);
					    $("#Product_Name").val(str[1]);
					    $("#intNo").val(str[2]);
					    //$("#Product_txt").text(str[1]+";期數"+str[2]);
					}
				}
			});
		}
   }
})
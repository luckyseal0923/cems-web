<?
//參數解碼
if ($_REQUEST["Customer_PKey"] <> ""){
	$Customer_PKey = authcode($_REQUEST["Customer_PKey"],'DECODE');
}

//取出客戶資料
$SQL = "Select * From customer Where PKey =".SqlFilter($Customer_PKey,"int");
$DR1 = new recordset($SQL);
if ($DR1->field("PKey") != ""){	
	$Customer_PKey = $DR1->field("PKey");
	$CustomerNo = $DR1->field("CustomerNo");
	$CustomerName = $DR1->field("CustomerName");
	$Contract = $DR1->field("Contract");
	$Tel = $DR1->field("Tel");
	$EMail = $DR1->field("EMail");
	$Address = $DR1->field("Address");
	$InvoiceTitle = $DR1->field("InvoiceTitle");
	$InvoiceNo = $DR1->field("InvoiceNo");
	$intType = $DR1->field("intType");
	$ManageType = $DR1->field("ManageType");
	$ContractDate = $DR1->field("ContractDate");
	$dtUDate = $DR1->field("dtUDate");
	$UserID = $DR1->field("UserID");
	$Cond = " Where Customer_PKey = ".$DR1->field("PKey");	
}
else{
	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('查無客戶資料!');" ;
	ECHO "location.href='m1-1.php';" ;
	ECHO "</script>" ;
	exit() ;
} 
?>
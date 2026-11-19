<?php
	require_once("../_inc.php");

	$PKey = $_REQUEST["PKey"];
	$RType = $_REQUEST["RType"];

	If ($RType !=""){
		$list = "";
		switch ($RType) {
		    case "Class2":
		        $SQL = "SELECT Pkey, strName From news_class2 Where class1_PKey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "Class3":
		        $SQL = "SELECT Pkey, strName From dbclass2 Where Class1_Pkey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "MClass3":
		        $SQL = "SELECT Pkey, strName From dbclass3 Where Class2_Pkey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "Course_Class2":
		        $SQL = "SELECT Pkey, strName From course_class2 Where class1_Pkey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "Store_Class2":
		        $SQL = "SELECT Pkey, strName From store_class2 Where Class1_Pkey =".SqlFilter($PKey,"int")." Order By strName";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "Local_Class2":
		        $SQL = "SELECT Pkey, strName From store_class2 Where Class1_Pkey =".SqlFilter($PKey,"int")." Order By strName";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		}

		if (strlen($list) > 2){
			$list = substr($list,0,strlen($list)-1);
			$list = "{data:[". $list. "]}";	
		}
		echo $list; 	
	}
?>
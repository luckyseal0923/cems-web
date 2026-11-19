<?phprequire("../_inc.php");?>
<?php

	$PKey = $_REQUEST["PKey"];
	$RType = $_REQUEST["RType"];

	If ($RType !=""){
		$list = "";
		switch ($RType) {
		    case "Class2":
		        $SQL = "SELECT Pkey, strName From dbClass2 Where Class1_Pkey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($SQL);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs->movenext();
		        }
		        break;
		    case "Class3":
		        $SQL = "SELECT Pkey, strName From dbClass3 Where Class2_Pkey =".SqlFilter($PKey,"int")." Order By Sort";
		        $rs = new recordset($sql);
				while (! $rs->eof){
		            $list .= "{ID:'".$rs->field("PKey")."',Name:'".$rs->field("strName")."'},";
		            $rs1->movenext();
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
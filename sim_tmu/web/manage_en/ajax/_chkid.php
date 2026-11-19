<?php
	require_once("../_inc.php");
	$EMail = SqlFilter($_REQUEST["EMail"],"str");
	$RType = $_REQUEST["RType"];

	if (CheckMail($EMail)) {
	    switch ($RType) {
		    case 1:
		        $SQL = "Select PKey From member Where strID = '".$strID."'";
		    	$DR1 = new recordset($SQL);
		    	if ($DR1->field("PKey")!=""){
		    		echo "【會員帳號】重複";
		    	}
		        break;
		    case 2:
/* 		        $SQL = "Select * From customer Where strID = '".$strID."'";
		        $rs = new recordset($SQL);
				if (! $rs->eof){
		            echo $rs->field("PKey")."|".$rs->field("strName")."|".$rs->field("Tel_Local")."|".$rs->field("Tel")."|".$rs->field("Ext")."|".$rs->field("Mobile")."|"
		            .$rs->field("strCounty1")."|".$rs->field("strCity1")."|".$rs->field("Address1")."|"
		            .$rs->field("strCounty2")."|".$rs->field("strCity2")."|".$rs->field("Address2");
		        }
		        else {
		        	echo "【會員帳號】無資料";
		        } */
		        break;
		}
	}else {
	    echo "【會員帳號】格式錯誤";
	}
?>
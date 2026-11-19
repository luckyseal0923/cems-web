<?php
	require_once("../_inc.php");
	$KeyWords = SqlFilter($_REQUEST["q"],"str");
	echo "\n";
	$SQL = "SELECT strName From dbauthor Where (Locate('".$KeyWords."',strName)> 0 ) Group By strName Order By strName ";
	$rs = new recordset($SQL);
	while (! $rs->eof){
		echo $rs->field("strName")."\n";
		$rs->movenext();
	}
?>
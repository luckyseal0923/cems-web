<?php
	require_once("../_inc.php");

	$PKey = $_REQUEST["PKey"];
	$Keywords = SqlFilter($_REQUEST["q"],"str");
	$SQL = "SELECT strName From dblabel Where (Locate('".SqlFilter($Keywords,"str")."',strName)> 0 ) Order By strName ";
	$rs = new recordset($SQL);
	while (! $rs->eof){
		echo $rs->field("strName")."\n";
		$rs->movenext();
	}
?>
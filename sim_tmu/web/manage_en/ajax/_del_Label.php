<?php
	require_once("../_inc.php");
	$PKey = $_REQUEST["PKey"];
	$Label_PKey = $_REQUEST["Label_PKey"];
	$strType = SqlFilter($_REQUEST["strType"],"str");
	switch($strType){
		Case "walker":
			$SQL = "delete from walker_label Where PKey = ".SqlFilter($PKey,"int");
			execute_sql ($SQL);
			break;
		Case "product":
			$SQL = "delete from product_label Where PKey = ".SqlFilter($PKey,"int");
			execute_sql ($SQL);
			break;
		default:
			$SQL = "delete From weekly_label Where PKey = ".SqlFilter($PKey,"int");
			execute_sql ($SQL);
			break;
	}
	//�ϥμƴ�1
	$SQL_U = "Update dblabel Set UseView = UseView - 1 Where PKey = ".SqlFilter($Label_PKey,"int");
	execute_sql($SQL_U);
?>
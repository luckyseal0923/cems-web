<?php
	require("_inc.php");
	
	//session_destroy();
	$_SESSION["Member_PKey"] = "";
	$_SESSION["Member_Name"] = "";

	ECHO "<script language=\"javascript\">" ;
	ECHO "alert('你已執行登出動作!!');";
	ECHO "location.href='p4_login.php';";
	ECHO "</script>";
	exit;
?>
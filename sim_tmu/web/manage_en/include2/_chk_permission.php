<?php
	//echo "Manage=" . $_SESSION["Manage"] . "<br>" . "Login_ID=" . strlen($_SESSION["Login_ID"]) . "<br>" ;
	if ( ( $_SESSION["Manage"] != "Yes" OR strlen($_SESSION["Login_ID"]) == 0 ) AND !stristr($_SERVER["PHP_SELF"],"index.php") ){
		ECHO "<script language=\"javascript\">" ;
		ECHO "alert(\"請先登入管理帳號!!\");";
		ECHO "location.href=\"../login/index.php\";";
		ECHO "</script>";
		exit();
	}

	if ( $mainitem != "index" and $mainitem != "login" ) {
		
		if ( !in_array($ModuleNo,explode(",",$_SESSION["FunctionID"])) ){
			ECHO "<script language=\"javascript\">" ;
			ECHO "alert('無進入[".$$mainitem."]權限!');";
			ECHO "location.href='../login/index.php';";
			ECHO "</script>";
			exit();
			
		} else {
			$login_user = $_SESSION["Login_ID"];//޲帳號

			if ( $login_user == $max_user_name ){
				//最大權限
				$is_max_user = "yes";
			}
			
			if ( $ModuleNo == 1 and $subitem == "L12" and $login_user != $max_user_name ){
				ECHO "<script language=\"javascript\">" ;
				ECHO "alert('無進入權限!');";
				ECHO "location.href='../login/index.php';";
				ECHO "</script>";
				exit();
			}

		}//if
	}
?>
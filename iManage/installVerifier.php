<?php
// check if ini.php already exist

//if(!file_exists("ini.php"))
//{
	
	// verify inputs
	$ms_add =  htmlspecialchars($_GET["mysql_address"],ENT_QUOTES);
	$ms_user =  htmlspecialchars($_GET["mysql_username"],ENT_QUOTES);
	$ms_pass =  htmlspecialchars($_GET["mysql_password"],ENT_QUOTES);
	$ms_db =  htmlspecialchars($_GET["mysql_db"],ENT_QUOTES);
	
	// validate user information
	
	// Temporarily Disable PHP error message //
	error_reporting(0);
	///////////////////////////////////////////
	
	$connection = new mysqli($ms_add,$ms_user, $ms_pass);
	if (!mysqli_connect_errno()) {
		$db_selected = $connection->select_db($ms_db);
		if ($db_selected) {
			// 1. clear database
			// 2. update database
			// 3. update admin user information
			// 3. write ini.php file
			echo "1";
		}
		else {
			echo "0";
		}
	}
	else {
		echo "0";
	}
//}
//else
//{
//	echo "-1";
//}

?>
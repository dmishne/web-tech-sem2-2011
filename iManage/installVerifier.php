<?php
function verifyInput($input)
{
	return stripslashes(htmlspecialchars($input));
}
	// verify inputs
	$ms_add =  verifyInput($_GET["mysql_address"]);
	$ms_user =  verifyInput($_GET["mysql_username"]);
	$ms_pass =  verifyInput($_GET["mysql_password"]);
	$ms_db =  verifyInput($_GET["mysql_db"]);
	
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
			// 3. write ini.php file (config.php)
			echo "1";
		}
		else {
			echo "0";
		}
	}
	else {
		echo "0";
	}
?>
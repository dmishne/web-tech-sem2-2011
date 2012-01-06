<?php
include "db.php";

function verifyInput($input)
{
	return stripslashes(htmlspecialchars($input));
}

error_reporting(0);
	// verify inputs
	$ms_add =  verifyInput($_POST["mysql_address"]);
	$ms_user =  verifyInput($_POST["mysql_username"]);
	$ms_pass =  verifyInput($_POST["mysql_password"]);
	$ms_db =  verifyInput($_POST["mysql_db"]);
	if ( isset($_POST["mysql_demo_info"]) && verifyInput($_POST['mysql_demo_info']) == '1')
	{
		$ms_demo = '1';
	}
	else {
		$ms_demo = '0';
	}
	
	$username = verifyInput($_POST['username']);
	$password = verifyInput($_POST['password']);
	$passwordr = verifyInput($_POST['passwordr']);
	
	if($password == $passwordr && $username != "")
	{
		$user_password_md5 = md5($password); 
		$connection = new mysqli($ms_add,$ms_user, $ms_pass);
		if (!mysqli_connect_errno()) {
			// 1. install db
			loadMySqlDump($ms_add,$ms_user,$ms_pass,$ms_db,$connection);
			// 2. update admin user information
			$connection->select_db($ms_db);			
			if (intval($ms_demo) == 1) {
				$res = $connection->multi_query("CALL installDB('$username','$user_password_md5',1)") or die(mysqli_error());
			}
			else {
				$res = $connection->multi_query("CALL installDB('$username','$user_password_md5',0)") or die(mysqli_error());
			}
			if($res)
			{
				// 4. write config.php
				$fp = fopen("config.php","w");
				fprintf($fp, "<?php \$serverInfo = array(\"address\" => \"%s\", \"username\" => \"%s\" , \"password\" => \"%s\", \"db\" => \"%s\"); ?>",$ms_add,$ms_user,$ms_pass,$ms_db);
				fclose($fp);
				session_start();
				session_unset();
				sleep(10);
				echo "1";
			}
			else {
				echo "-2";
			}
		}
		else {
			echo "0";
		}
	}
	else {
		echo "-2";
	}
?>
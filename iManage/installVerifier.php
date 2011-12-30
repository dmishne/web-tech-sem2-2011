<?php

////////////////Function Declarations///////////////
function verifyInput($input)
{
	return stripslashes(htmlspecialchars($input));
}

function loadMySqlDump($filename,$mysql_host,$mysql_username,$mysql_password,$mysql_database)
{
   /*
	* 
	* Thanks to Daniel15 - http://dan.cx/blog/2006/12/restore-mysql-dump-using-php
	* Modified. 
	*/
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	// Connect to MySQL server
	mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
	// Select database
	mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
	
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file($filename);
	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
		continue;
	
		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			// Reset temp variable to empty
			$templine = '';
		}
	}
	mysql_close();
}
////////////////End of Function Declarations///////////////



	// verify inputs
	$ms_add =  verifyInput($_POST["mysql_address"]);
	$ms_user =  verifyInput($_POST["mysql_username"]);
	$ms_pass =  verifyInput($_POST["mysql_password"]);
	$ms_db =  verifyInput($_POST["mysql_db"]);
	if ( isset($_POST["mysql_demo_info"]))
	{
		$ms_demo = verifyInput($_POST['mysql_demo_info']);
	}
	else {
		$ms_demo = '0';
	}
	
	
	$username = verifyInput($_POST['username']);
	$password = verifyInput($_POST['password']);
	$passwordr = verifyInput($_POST['passwordr']);
	
	// Temporarily Disable PHP error message //
	error_reporting(0);
	///////////////////////////////////////////
	if($password == $passwordr && $username != "")
	{
		$user_password_md5 = md5($password); 
		$connection = new mysqli($ms_add,$ms_user, $ms_pass);
		if (!mysqli_connect_errno()) {
			$db_selected = $connection->select_db($ms_db);
			if ($db_selected) {
				// 0. close connection - installing can take time - connection would be closed by then.
				$connection->close();
				// 1. install db
				loadMySqlDump("install_script.sql",$ms_add,$ms_user,$ms_pass,$ms_db);
				// 2. update admin user information
				$connection = new mysqli($ms_add,$ms_user, $ms_pass);
				if (mysqli_connect_errno()) {
					die('Could not connect: ' . mysqli_connect_error());
				}
				$connection->select_db($ms_db);
				if (intval($ms_demo) == 1) {
					$res = $connection->query("CALL installDB('$username',$user_password_md5,1)") or die(mysqli_error());
				}
				else {
					$res = $connection->query("CALL installDB('$username',$user_password_md5,0)") or die(mysqli_error());
				}
				$connection->close();
				if($res->num_rows > 1)
				{
					// 4. write config.php
					$fp = fopen("config.php","w");
					fprintf($fp, "\$serverInfo = array(\"address\" => \"%s\", \"username\" => \"%s\" , \"password\" => \"%s\", \"db\" => \"%s\");",$ms_add,$ms_user,$ms_pass,$ms_db);
					fclose($fp);
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
			echo "0";
		}
	}
	else {
		echo "-2";
	}
?>
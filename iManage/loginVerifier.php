<?php 
include "beforeLoadCheck.php";
session_start();

include_once "ini.php";

//Connect to database from here
$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db($serverInfo["db"]);

$username=verifyInput($_POST['username']);
$password=md5(verifyInput($_POST['password']));

//now validating the username and password
$res = $connection->query("CALL doLogin('$username', '$password')") or die(mysqli_error());
$userDetails = $res->fetch_array(MYSQLI_NUM);


if($userDetails[0] == 'locked account')
{
	echo "locked";
}
else if ($userDetails[0] == 'Account Deleted')
{
	echo "deleted";
}
else if ($userDetails[0] == 'Incorrect account details')
{
	echo "incorrect";
}
else if ($res->num_rows > 0)
{
	$_SESSION['login']    = "1";
	$_SESSION['username'] = $username;
	$_SESSION['firstname'] = $userDetails[0];
	$_SESSION['lastname'] = $userDetails[1];
	$_SESSION['DOB'] = $userDetails[2];
	$_SESSION['permissionid'] = $userDetails[4];
	$_SESSION['email'] = $userDetails[5];
	$_SESSION["last_usage"] = time();
	$res->free();
	//Impossible to submit any quesry after a SP, cause of some mysql glitch - known issue, 
	//this frees each row in the result of the SP
	while ($connection->next_result()) {
		//free each result.
		$result = $connection->use_result();
		if ($result instanceof mysqli_result) {
			$result->free();
		}
	}
	
	$newres = $connection->query("CALL getBalance('$username')") or die(mysqli_error());
	$bal = $newres->fetch_array(MYSQLI_NUM);
	if($newres->num_rows > 0)
	{
		$_SESSION['balance'] = round($bal[0],2);
	}
	else {
		$_SESSION['balance'] = 0;
	}
	echo "yes";
}
else
{
	echo "incorrect";
}
?>
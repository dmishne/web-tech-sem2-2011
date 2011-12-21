<?php 
include "beforeLoadCheck.php";
session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

/*
$_POST['username'] = 'daniel';
$_POST['password'] = '123123123';
*/

$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$password=md5($_POST['password']);

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
	$_SESSION['email'] = $userDetails[5];
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
<?php 
include "beforeLoadCheck.php";
session_start();

include_once "ini.php";

$errors = array();
$REG = 1;

$firstname=verifyInput($_POST['firstname']);
if(strlen($firstname) < 3 || $firstname != $_POST['firstname'] || strlen($firstname) > 10)
{
	$error['firstname'] = 1;
	$REG = 0;
}

$lastname=verifyInput($_POST['lastname']);
if(strlen($lastname) < 3 || $lastname != $_POST['lastname'] || strlen($lastname) > 10)
{
	$error['lastname'] = 1;
	$REG = 0;
}

$username=verifyInput($_POST['username']);
if(strlen($username) < 3 || $username != $_POST['username'] || strlen($username) > 10)
{
	$error['username'] = 1;
	$REG = 0;
}

$day=verifyInput($_POST['signUpDay']);
$month=verifyInput($_POST['signUpMonth']);
$year=verifyInput($_POST['signUpYear']);
if(!(is_numeric($day) && is_numeric($month) && is_numeric($year)) || (!checkdate(intval($month),intval($day),intval($year))))
{
	$error['date'] = 1;
	$REG = 0;
}

$password=md5($_POST['userpassword']);
$passwordconfirm=md5($_POST['userpasswordconfirm']);
if($password != $passwordconfirm)
{
	$error['password'] = 1;
	$REG = 0;
}

$email=verifyInput($_POST['email']);

if($REG == 1)
{
	//Connect to database from here
	$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
	if (mysqli_connect_errno()) {
		die('Could not connect: ' . mysqli_connect_error());
	}
	
	$connection->select_db($serverInfo["db"]);
	
	$res = $connection->query("CALL register('$username','$firstname','$lastname','$year-$month-$day',1,'$email','$password')") or die(mysqli_error());
	$userDetails = $res->fetch_array(MYSQLI_NUM);
	if($userDetails[0] == 0)
	{
		header("location:index.php");
	}
	else
	{
		$error['Reg'] = 1;
		$REG = 0;
	}
}

if($REG == 0)
{
	$_SESSION['signupError'] = $error;
	header("location:signuppage.php");
}

?>
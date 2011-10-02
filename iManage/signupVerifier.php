<?php session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

$firstname=htmlspecialchars($_POST['firstname'],ENT_QUOTES);
$lastname=htmlspecialchars($_POST['lastname'],ENT_QUOTES);
$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$day=htmlspecialchars($_POST['signUpDay'],ENT_QUOTES);
$month=htmlspecialchars($_POST['signUpMonth'],ENT_QUOTES);
$year=htmlspecialchars($_POST['signUpYear'],ENT_QUOTES);
$password=md5($_POST['userpassword']);
$passwordconfirm=md5($_POST['userpasswordconfirm']);
$email=htmlspecialchars($_POST['email'],ENT_QUOTES);
$res = "ERROR";

if($password == $passwordconfirm)
{
	$res = $connection->query("CALL register('$username','$firstname','$lastname','$year-$month-$day',1,'$email','$password')") or die(mysqli_error());
	$userDetails = $res->fetch_array(MYSQLI_NUM);
	if($userDetails[0] == 0)
	{
		$res = "OK";
	}
}

echo $res;





?>
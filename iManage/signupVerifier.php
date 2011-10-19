<?php session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

$errors = array();
$REG = 1;

$firstname=htmlspecialchars($_POST['firstname'],ENT_QUOTES);
if(strlen($firstname) < 3 || $firstname != $_POST['firstname'])
{
	$error['firstname'] = 1;
	$REG = 0;
}

$lastname=htmlspecialchars($_POST['lastname'],ENT_QUOTES);
if(strlen($lastname) < 3 || $lastname != $_POST['lastname'])
{
	$error['lastname'] = 1;
	$REG = 0;
}

$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
if(strlen($username) < 3 || $username != $_POST['username'])
{
	$error['username'] = 1;
	$REG = 0;
}

$day=htmlspecialchars($_POST['signUpDay'],ENT_QUOTES);
$month=htmlspecialchars($_POST['signUpMonth'],ENT_QUOTES);
$year=htmlspecialchars($_POST['signUpYear'],ENT_QUOTES);
if(!checkdate(intval($month),intval($day),intval($year)))
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

$email=htmlspecialchars($_POST['email'],ENT_QUOTES);

if($REG == 1)
{
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
<?php session_start();
// Verifies that user has logged in. Redirect to login page in case not logged in.
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

$errors = array();
$REG = 1;

$jobsname=htmlspecialchars($_POST['creatework_jobsname'],ENT_QUOTES);
if(strlen($jobsname) < 3 || $jobsname != $_POST['creatework_jobsname'])
{
	$error['creatework_jobsname'] = 1;
	$REG = 0;
}

$wage=htmlspecialchars($_POST['creatework_wagehour'],ENT_QUOTES);
if($jobsname != $_POST['creatework_wagehour'] && !is_numeric($wage))
{
	$error['creatework_wagehour'] = 1;
	$REG = 0;
}

$day=htmlspecialchars($_POST['creatework_pDay'],ENT_QUOTES);
$month=htmlspecialchars($_POST['creatework_pMonth'],ENT_QUOTES);
$year=htmlspecialchars($_POST['creatework_pYear'],ENT_QUOTES);
if(!(is_numeric($day) && is_numeric($month) && is_numeric($year)) || (!checkdate(intval($month),intval($day),intval($year))))
{
	$error['creatework_date'] = 1;
	$REG = 0;
}

$desc=htmlspecialchars($_POST['creatework_desc'],ENT_QUOTES);
if($desc != $_POST['creatework_desc'])
{
	$error['creatework_desc'] = 1;
	$REG = 0;
}


if($REG == 1)
{
	/*$res = $connection->query("CALL register('$username','$firstname','$lastname','$year-$month-$day',1,'$email','$password')") or die(mysqli_error());
	$userDetails = $res->fetch_array(MYSQLI_NUM);
	if($userDetails[0] == 0)
	{*/
		header("location:index.php");
	//}
	/*else
	{
		$error['Reg'] = 1;
		$REG = 0;
	}*/
}

if($REG == 0)
{
	$_SESSION['createWorkError'] = $error;
	header("location:createWork.php?error");
}

?>
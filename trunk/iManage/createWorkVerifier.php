<?php session_start();

include "ini.php";

// Verifies that user has logged in. Redirect to login page in case not logged in.
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}

$errors = array();
$REG = 1;

$jobsname=htmlspecialchars($_POST['creatework_jobsname'],ENT_QUOTES);
if(strlen($jobsname) < 3 || $jobsname != $_POST['creatework_jobsname'])
{
	$error['creatework_jobsname'] = 1;
	$REG = 0;
}

$wage=htmlspecialchars($_POST['creatework_wagehour'],ENT_QUOTES);
if($wage != $_POST['creatework_wagehour'] && !is_numeric($wage))
{
	$error['creatework_wagehour'] = 1;
	$REG = 0;
}

$day=htmlspecialchars($_POST['creatework_pDay'],ENT_QUOTES);
if(!(is_numeric($day) && $day >=1 && $day <= 31))
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
	
	//Connect to database from here
	$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
	if (mysqli_connect_errno()) {
		die('Could not connect: ' . mysqli_connect_error());
	}
	$connection->select_db($serverInfo["db"]);
	
	$username = $_SESSION['username'];
	$work_id = htmlspecialchars($_POST['create_work_id_selection'],ENT_QUOTES);
	
	if ($work_id == "")
	{
		$res = $connection->query("CALL insertJob('$username','$jobsname','$desc',$wage,'1970-01-$day')") or die(mysqli_error());
	}
	else {
		///////
		// 1. UPDATE JOB INFO editJobDetails - done
		// 2. Check if work_id belongs to user.
		///////
		$res = $connection->query("CALL editJobDetails('$work_id','$jobsname','$desc',$wage,'1970-01-$day')") or die(mysqli_error());
	}
	$userDetails = $res->fetch_array(MYSQLI_NUM);
	if($userDetails[0] == 0)
	{
		header("location:addincome.php");
	}
	else
	{
		$error['Reg'] = 1;
		$REG = 0;
	}
}

if($REG == 0)
{
	$_SESSION['createWorkError'] = $error;
	header("location:createWork.php?error");
}

?>
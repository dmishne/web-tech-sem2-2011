<?php 
include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();

include "ini.php";

$errors = array();
$REG = 1;

$jobsname=htmlspecialchars($_POST['creatework_jobsname'],ENT_QUOTES);
if(strlen($jobsname) < 3 || $jobsname != $_POST['creatework_jobsname'])
{
	$error['creatework_jobsname'] = 1;
	$REG = 0;
}

$wage=htmlspecialchars($_POST['creatework_wagehour'],ENT_QUOTES);
if($wage != $_POST['creatework_wagehour'] || !is_numeric($wage))
{
	$error['creatework_wagehour'] = 1;
	$REG = 0;
}

$day=htmlspecialchars($_POST['creatework_pDay'],ENT_QUOTES);
if(!(is_numeric($day) && $day >=1 && $day <= 31))
{
	$error['creatework_pDay'] = 1;
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
		$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m")+1,$day,date("Y")));
		$res = $connection->query("CALL insertJob('$username','$jobsname','$desc',$wage,'$year_mon_day')") or die(mysqli_error());
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
	else {
		$jobsarray = $_SESSION["jobsarray"];
		$isWorkIdCorrect = 0;
		foreach ($jobsarray as &$job){
			if ($job["recTrans"] == $work_id)
			{
				$isWorkIdCorrect = 1;
				break;
			}
		}
		if ($isWorkIdCorrect == 1) {
			$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m")+1,$day,date("Y")));
			$res = $connection->query("CALL editJobDetails($work_id,'$jobsname','$desc',$wage,'$year_mon_day')") or die(mysqli_error());
			$userDetails = $res->fetch_array(MYSQLI_NUM);
			if($userDetails[0] == $year_mon_day)
			{
				header("location:addincome.php");
			}
			else
			{
				$error['Reg'] = 1;
				$REG = 0;
			}
		}
		else {
			$errorp["Reg"] = 1;
			$REG = 0;
		}
	}
}

if($REG == 0)
{
	$_SESSION['createWorkError'] = $error;
	header("location:createWork.php?error");
}

?>
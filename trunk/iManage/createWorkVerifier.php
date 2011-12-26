<?php 
include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();

include_once "ini.php";

if (!isset($_POST["job_to_del"]))
{
	
	$errors = array();
	$REG = 1;
	
	$jobsname=verifyInput($_POST['creatework_jobsname']);
	if(strlen($jobsname) < 3 || $jobsname != $_POST['creatework_jobsname'])
	{
		$error['creatework_jobsname'] = 1;
		$REG = 0;
	}
	
	$wage=verifyInput($_POST['creatework_wagehour']);
	if($wage != $_POST['creatework_wagehour'] || !is_numeric($wage))
	{
		$error['creatework_wagehour'] = 1;
		$REG = 0;
	}
	
	$day=verifyInput($_POST['creatework_pDay']);
	if(!(is_numeric($day) && $day >=1 && $day <= 31))
	{
		$error['creatework_pDay'] = 1;
		$REG = 0;
	}
	
	$desc=verifyInput($_POST['creatework_desc']);
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
		$work_id = verifyInput($_POST['create_work_id_selection']);
		
		if ($work_id == "")
		{
			If ($day < intval(date("d")) )
			{
				$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m")+1,$day,date("Y")));
			} 
			else {
				$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m"),$day,date("Y")));
			}
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
				If ($day < intval(date("d")) )
				{
					$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m")+1,$day,date("Y")));
				} 
				else {
					$year_mon_day = date("Y-m-d",mktime(0,0,0,date("m"),$day,date("Y")));
				}
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
}
else
{
	$job_to_del = verifyInput($_POST["job_to_del"]);
	if($job_to_del != $_POST["job_to_del"])
	{
		header("location:createWork.php?error");
	}
	else {
		$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
		if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
		}
		$connection->select_db($serverInfo["db"]);
		
		$username = $_SESSION['username'];
		$year_mon_day = date("Y-m-d");
		$res = $connection->query("CALL deleteTransaction('$username',$job_to_del,1,3,'$year_mon_day')") or die(mysqli_error());
		$userDetails = $res->fetch_array(MYSQLI_NUM);
		if($userDetails[0] == 0)
		{
			header("location:createWork.php");
		}
		else {
			header("location:createWork.php?error");
		}
	}	
}

?>
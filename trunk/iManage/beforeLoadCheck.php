<?php
	// check if site installed
	error_reporting(0);
	if(!file_exists("config.php"))
	{
		header("location:notinstalled.php");
		exit();
	}
	include "config.php";
	if(!isset($serverInfo))
	{
		header("location:notinstalled.php");
		exit();
	}
	$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
	if (mysqli_connect_errno()) {
		header("location:noconnection.php");
		exit();
	}
	
?>
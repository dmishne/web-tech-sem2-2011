<?php
	// check if site installed
	error_reporting(0);
	if(!file_exists("config.php"))
	{
		header("location:notinstalled.php");
		exit();
	}
	include "config.php";
?>
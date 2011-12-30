<?php
	// check if site installed
	if(!file_exists("config.php"))
	{
		header("location:notinstalled.php");
		exit();
	}
	include "config.php";
?>
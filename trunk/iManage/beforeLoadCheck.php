<?php
	// check if site installed
	if(!file_exists("ini.php"))
	{
		header("location:notinstalled.php");
	}
?>
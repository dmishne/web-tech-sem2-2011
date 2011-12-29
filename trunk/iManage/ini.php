<?php
// set default time zone
date_default_timezone_set("UTC");
$serverInfo = array("address" => "remote-mysql4.servage.net", "username" => "webtech" , "password" => "12345678", "db" => "webtech");

function verifyInput($input)
{
	if(is_array($input))
	{
		foreach($input as &$value)
		{
			$value = verifyInput($value);
		}
		return $input;
	}
	else
	{
		return stripslashes(htmlspecialchars($input));
	}
}


?>
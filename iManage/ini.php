<?php
// set default time zone
date_default_timezone_set("UTC");

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
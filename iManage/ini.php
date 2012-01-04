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

function isDateValid($str)
{
	$stamp = strtotime($str);
	if (!is_numeric($stamp))
	return FALSE;

	//checkdate(month, day, year)
	if ( checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)))
	{
		return TRUE;
	}
	return FALSE;
}


?>
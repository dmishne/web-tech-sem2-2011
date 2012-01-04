<?php
 if ( !isset ($_SESSION) ) session_start();
//connecting to database:
header('Refresh: 10');

include "beforeLoadCheck.php";
include "ini.php";
	
	$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
	if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
	}
                        
    $connection->select_db($serverInfo["db"]);
		
	
	$hours=date('H');
	$minutes=date('i');
	$seconds=date('s');

	
	if (($hours= 1) && ($minutes > 0) && ($minutes <4))
	{	
		monitor($connection);
	}
	if (($hours = 1)&& ($minutes > 15) && ($minutes <16))
	{	
		jobHours($connection);
	}
	if (($hours = 1) && ($minutes > 20) && ($minutes <21))
	{	
		sendmails($connection);
	}
	
function monitor($connection)
{
	$sql="CALL commitDailyTrans();";		
	$result = $connection->query($sql) or die(mysqli_error());
}


function jobHours($connection)
{
	$sql="CALL commitJobHours()";	
	$result = $connection->query($sql) or die(mysqli_error());
}

function sendmails($connection)
{
	$sql="CALL commitDailyNotifications();";		
	
	//notId INT(10), recId INT (10), recName VARCHAR(45), email VARCHAR(45), notType INT

	$result = $connection->query($sql) or die(mysqli_error());

	if ($result->num_rows > 0 )
	{
		
		echo "num of rows: '",$result->num_rows."' , num of fields: '".mysqli_num_fields($result)."'<br>";
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$email=$row['email'];
			$notType=$row['notType'];
			$recName=$row['recName'];
			
			if ($notType == 1)
			{
				$emailContent="Hello, This is the first notification of the payment $recName occurring today";
			}
			else
			{
				$emailContent="Hello, This is the second notification of the payment $recName occurring today";
			}
		
			$subject = "iManage notification";
			$headers = 'From: imanage.noreply@gmail.com' . "\r\n";
			$headers.= 'Reply-To: No reply' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			@mail($email, $subject, $emailContent, $headers );				
						
		}
	}

	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

	print strftime('%c');
	
?>

</body>
</html>
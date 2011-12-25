<?php 
include "beforeLoadCheck.php";
session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

$flag = htmlspecialchars($_POST['flag'],ENT_QUOTES);


if($flag == 1)   // search button
{
	$user = htmlspecialchars($_POST['search_username'],ENT_QUOTES);
	$res = $connection->query("CALL getUserInfo('$user')") or die(mysqli_error());
	if($res->num_rows > 0){		
		$row = $res->fetch_array(MYSQLI_ASSOC);				
		 echo json_encode($row, JSON_FORCE_OBJECT);					  
	}
	else  {
	   echo "User Not Found!";
	}
}
else if($flag == 2)   // save button
{
	$username = htmlspecialchars($_POST['Username'],ENT_QUOTES);
	$firstname = htmlspecialchars($_POST['FName'],ENT_QUOTES);
	$lastname = htmlspecialchars($_POST['LName'],ENT_QUOTES);
	$bdate = htmlspecialchars($_POST['BD'],ENT_QUOTES);
	$status = htmlspecialchars($_POST['Status'],ENT_QUOTES);
	$emailAddress = htmlspecialchars($_POST['EmailAdd'],ENT_QUOTES);
	$res = $connection->query("CALL editUser('$username','$firstname','$lastname','$bdate','$emailAddress','$status')") or die(mysqli_error());
	if($res->num_rows > 0)
	{
		$result = $res->fetch_array(MYSQLI_NUM);
		if($result[0] == "Loginname is incorrect")
		{
			echo "Loginname is incorrect";
		}
	}
}
else if($flag == 3)   // lock\unlock button
{
	$username = htmlspecialchars($_POST['Username'],ENT_QUOTES);
	$comment = htmlspecialchars($_POST['log'],ENT_QUOTES);
	$res = $connection->query("CALL updateUserLock('$username','$comment')") or die(mysqli_error());
	echo 0;
}
else if($flag == 4)   // delete button
{
	$username = htmlspecialchars($_POST['Username'],ENT_QUOTES);
	$res = $connection->query("CALL deleteUser('$username')") or die(mysqli_error());
	echo 0;
}
?>
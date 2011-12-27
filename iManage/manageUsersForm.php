<?php 
include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();

include_once "ini.php";

//Connect to database from here
$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
		if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
		}
$connection->select_db($serverInfo["db"]);
$isAdmin = $_SESSION['permissionid'];
$flag = verifyInput($_POST['flag'],ENT_QUOTES);

if($isAdmin != 3)
{
	echo "AccessDenied";
}
else {
		if($flag == 1)   // search button
		{
			$user = verifyInput($_POST['search_username'],ENT_QUOTES);
			$res = $connection->query("CALL getUserInfo('$user')") or die(mysqli_error());
			if($res->num_rows > 0){						
				$row = $res->fetch_array(MYSQLI_ASSOC);
				if(isset($row["-1"]) && $row["-1"] == -1){							     
				     echo "UserNotFound";
				 }
			    else {
			    	 echo json_encode($row, JSON_FORCE_OBJECT);
			     }
			}
		}
		else if($flag == 2)   // save button
		{
			$username = verifyInput($_POST['Username'],ENT_QUOTES);
			$firstname = verifyInput($_POST['FName'],ENT_QUOTES);
			$lastname = verifyInput($_POST['LName'],ENT_QUOTES);
			$bdate = verifyInput($_POST['BD'],ENT_QUOTES);
			$status = verifyInput($_POST['Status'],ENT_QUOTES);
			$emailAddress = verifyInput($_POST['EmailAdd'],ENT_QUOTES);
			$res2 = $connection->query("CALL editUser('$username','$firstname','$lastname','$bdate','$emailAddress','$status')") or die(mysqli_error());
			if($res2->num_rows > 0)
			{
				$result = $res2->fetch_array(MYSQLI_NUM);
				if($result[0] == "Loginname or permission is incorrect")
				{
					echo "Edit fail";
				}
			}
		}
		else if($flag == 3)   // lock\unlock button
		{
			$username = verifyInput($_POST['Username'],ENT_QUOTES);
			$comment = verifyInput($_POST['log'],ENT_QUOTES);
			$res3 = $connection->query("CALL updateUserLock('$username','$comment')") or die(mysqli_error());
			if($res3->num_rows > 0)
			{
				$row3 = $res3->fetch_array(MYSQLI_NUM);
				if($row3[0] == 0) {
					echo "succ";
				}
				else if($row3[0] == -1) {
					echo "fail";
				}
			}
			echo $res3;
		}
		else if($flag == 4)   // delete button
		{
			$username = verifyInput($_POST['Username'],ENT_QUOTES);
			$res4 = $connection->query("CALL deleteUser('$username')") or die(mysqli_error());
			if($res4->num_rows > 0)
			{
			   $row4 = $res4->fetch_array(MYSQLI_NUM);
			   if($row4[0] == 0) {	echo "deleted"; }
			   else if($row4[0] == -1) { echo "fail"; }
			}
		}
		
		else if($flag == 5)
		{
			
			$mailAdd = verifyInput($_POST['MailAddress'],ENT_QUOTES);
			$mailSubj = verifyInput($_POST['MailSubject'],ENT_QUOTES);
			$mailBody = verifyInput($_POST['MailBody'],ENT_QUOTES);
			// spamcheck
			//address using FILTER_SANITIZE_EMAIL
			$CheckedMailAdd=filter_var($mailAdd, FILTER_SANITIZE_EMAIL);	
			//filter_var() validates the e-mail
			//address using FILTER_VALIDATE_EMAIL
			if(!filter_var($CheckedMailAdd, FILTER_VALIDATE_EMAIL))
			{
				echo "fail";
			}
			else
			{//send email
				$headers = 'From: imanage.noreply@gmail.com' . "\r\n" .
		                   'Reply-To: No reply' . "\r\n" .
		                   'X-Mailer: PHP/' . phpversion();
				mail($CheckedMailAdd, $mailSubj, $mailBody, $headers );
				echo "sended";
			}
		}
}
?>
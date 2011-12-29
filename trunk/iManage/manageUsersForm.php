<?php 
include "beforeLoadCheck.php";
include "sessionVerifier.php";

if('3' != $_SESSION['permissionid'])
{
	header("location:index.php");
	exit();
}
include_once "ini.php";

//Connect to database from here
$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}
$connection->select_db($serverInfo["db"]);
$isAdmin = $_SESSION['permissionid'];
$flag = verifyInput($_POST['flag']);

if($isAdmin != 3)
{
	echo "AccessDenied";
}
else {
		if($flag == 1)   // search button
		{
			$user = verifyInput($_POST['search_username']);
			$res = $connection->query("CALL getUserInfo('$user')") or die(mysqli_error());
			if($res->num_rows > 0){						
				$row = $res->fetch_array(MYSQLI_BOTH);				
				if($row[0] == -1){							     
				     echo "UserNotFound";
				 }
			    else {
			    	 echo json_encode((object)$row);
			     }
			}
		}
		else if($flag == 2)   // save button
		{
			$username = verifyInput($_POST['Username']);
			$firstname = verifyInput($_POST['FName']);
			$lastname = verifyInput($_POST['LName']);
			$bdate = verifyInput($_POST['BD']);
			$status = verifyInput($_POST['Status']);
			$emailAddress = verifyInput($_POST['EmailAdd']);
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
			$username = verifyInput($_POST['Username']);
			$comment = verifyInput($_POST['log']);
			$userStatus = verifyInput($_POST['userStatus']);
			$currentDate = date("d.m.Y H:i");
			if($userStatus == "block")  // was locked
			{
			    $newComment = "$comment \nUser Unlocked - $currentDate";
			}
			else if($userStatus == "none")  // was unlocked
			{
				$newComment = "$comment \nUser Locked - $currentDate";
			}
			$res3 = $connection->query("CALL updateUserLock('$username','$newComment')") or die(mysqli_error());
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
			$username = verifyInput($_POST['Username']);
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
			
			$mailAdd = verifyInput($_POST['MailAddress']);
			$mailSubj = verifyInput($_POST['MailSubject']);
			$mailBody = verifyInput($_POST['MailBody']);
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
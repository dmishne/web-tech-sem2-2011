<?php session_start();

/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
header("location:login.php");
}*/

$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');
$username= $_SESSION['firstname'];  // from current user session submited on login

/* $result = $connection->query();
if (!$result) {
echo 'Could not run query: ' . mysql_error();
exit;
}
$delData['res'] = $result;*/
?>
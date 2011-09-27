<?php session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');

$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$password=md5($_POST['password']);

//now validating the username and password
$res = $connection->query("CALL doLogin('$username', '$password')") or die(mysqli_error());
$userDetails = $res->fetch_array(MYSQLI_NUM);

if($res->num_rows > 0){
	$_SESSION['login']    = "1";
	$_SESSION['username'] = $username;
	$_SESSION['firstname'] = $userDetails[0];
	echo "yes";
}
else{
	echo "no"; //Invalid Login
}
?>
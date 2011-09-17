<?php session_start();

//Connect to database from here
$connection = mysql_connect("remote-mysql4.servage.net", "webtech", "12345678"); 
if (!$connection) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('webtech'); 

$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$password=md5($_POST['password']);

//now validating the username and password
$res = mysql_query("CALL doLogin('$username', '$password')");
$userDetails = mysql_fetch_array($res);

if(mysql_num_rows($res)>0){
	$_SESSION['login']    = "1";
	$_SESSION['username'] = $username;
	echo "yes";
}
else{
	echo "no"; //Invalid Login
}
?>
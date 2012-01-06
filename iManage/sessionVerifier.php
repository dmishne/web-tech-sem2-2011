<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == '1')) {
	header("Location: login.php");
	exit();
}
if (time() - $_SESSION["last_usage"] > 1800 )
{
	header("Location: index.php?logout=1");
	exit();
}
$_SESSION["last_usage"] = time();
?>

<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0' && ($_SESSION['last_usage'] - time() < 1800 ) )) {
	header("location:login.php");
}
$_SESSION["last_usage"] = time();
?>

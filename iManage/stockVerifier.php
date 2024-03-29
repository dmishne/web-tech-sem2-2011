<?php
include "str_getcsv.php";

include "beforeLoadCheck.php";
include "sessionVerifier.php";

if('3' != $_SESSION['permissionid'] && '2' != $_SESSION['permissionid'])
{
	header("location:index.php");
	exit();
}
include_once "ini.php";

$action=verifyInput($_POST['action']);

if($action == "add")
{
	$error = 0;
	
	$symbol=verifyInput($_POST['symbol']);
	$amount=verifyInput($_POST['amount']);
	$curr_value=0;
	$username= $_SESSION['username'];
	
	$tempCsvString = file_get_contents("http://download.finance.yahoo.com/d/quotes.csv?s=". $symbol ."&f=snp");
	$stockData=explode("\r\n",$tempCsvString);
	$stockData = csvstring_to_array($stockData[0]);
	
	if(isset($stockData[0][2]) && is_numeric($stockData[0][2]))
	{
		$curr_value = floatval($stockData[0][2]);
	}
	else
	{
		$error++;
	}
	
	if (is_numeric($amount) && floatval($amount) > 0 && floatval($amount) < 1000000 && floatval($amount) > -1000000)
	{
		$amount = floatval($amount);
	} 
	else {
		$error++;
	}
	
	if ($error == 0)
	{
		$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
		if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
		}
		$connection->select_db($serverInfo["db"]);
		$year_mon_day = date("Y-m-d");
		$res = $connection->query("CALL createInvestment('$username','$symbol',$amount,'$year_mon_day',$curr_value)") or die(mysqli_error());
		$qres = $res->fetch_array(MYSQLI_NUM);
		if ($qres[0] != "-1")
		{
			echo $qres[0];
		}
		else
		{
			echo "no";
		}
	}
	else {
		echo "no";
	}
} 
else if($action == "del") {
	
	$id=verifyInput($_POST['id']);	
	if(is_numeric($id))
	{
		$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
		if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
		}
		$connection->select_db($serverInfo["db"]);
		$res = $connection->query("CALL deleteInvestment($id)") or die(mysqli_error());
		$qres = $res->fetch_array(MYSQLI_NUM);
		if ($qres[0] == "0")
		{
			echo "yes";
		}
		else
		{
			echo "no";
		}		
	}
	else {
		echo "no";
	}
}
else {
	echo "no";
}



?>
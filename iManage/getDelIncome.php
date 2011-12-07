<?php session_start();

/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
header("location:login.php");
}*/

$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
if (mysqli_connect_errno()) {
	die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');
$username= $_SESSION['username'];  // from current user session submited on login
$delmonth = htmlspecialchars($_POST['delMonth'],ENT_QUOTES);
$delyear = htmlspecialchars($_POST['delYear'],ENT_QUOTES);
$delDate = sprintf('%4d-%02d-%02d', $delyear, $delmonth, '01');
$result = $connection->query("CALL getTransToDelete('date','$username')") or die(mysqli_error());
if (!$result) {
echo 'Could not run query: ' . mysql_error();
exit;
}
//$delArr = array();

/*while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	$i = 1;
   if($row['lbl'] != null  && $row['prnt'] == null){
   	  $delArr[$row['lbl']][0] = $row;
   }
   else if($row['lbl'] == null && $row['prnt'] != null){
   	
   	  $delArr[$row['prnt']][$i] = $row;
   }
}

$delData['res'] = $result;*/
?>
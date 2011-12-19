<?php session_start();

/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}*/

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');
$username= $_SESSION['username'];  // from current user session submited on login
$form = htmlspecialchars($_POST['delete'],ENT_QUOTES);
list($which, $maxid) = explode('+', $form);

if($which == "income") 
{
    $checkedArr = $_POST['formDelInc'];   // arrey of checked checkboxes values
    foreach ($checkedArr as $value)
    {
    	list($idtypeid, $deltypeS, $deldate) = explode(',', $value);
    	    list($idtypeS, $idS) = explode('-', $idtypeid); 
    	    $id = (int)$idS;
    	    $deltype = (int)$deltypeS;
    	    $idtype = (int)$idtypeS;
    	$res = $connection->query("CALL deleteTransaction('$username','$id','$idtype','$deltype','$deldate')") or die(mysqli_error());
    	while ($connection->next_result()) {
    		//free each result.
    		$result = $connection->use_result();
    		if ($result instanceof mysqli_result) {
    			$result->free();
    		}
    	}
    }
    $_SESSION['update'] = 1;
    header("location:delincome.php");
}

else if($which == "payout")   
{
	$checkedArr = $_POST['formDelPay'];   // arrey of checked checkboxes values
    foreach ($checkedArr as $value)
    {
    	list($idtypeid, $deltype, $deldate) = explode(',', $value);
    	    list($idtype, $id) = explode('-', $idtypeid); 
    	    (int)$id;
    	    (int)$deltype;
    	    (int)$idtype;
    	$res = $connection->query("CALL deleteTransaction('$username','$id','$idtype','$deltype','$deldate')") or die(mysqli_error());
    	while ($connection->next_result()) {
    		//free each result.
    		$result = $connection->use_result();
    		if ($result instanceof mysqli_result) {
    			$result->free();
    		}
    	}
    }
    $_SESSION['update'] = 1;
    header("location:delpayout.php");
}


function leap_year($year) {
	return (!($year % 4) && ($year < 1582 || $year % 100 || !($year % 400))) ? true : false;
}

function nextday($y,$m,$d){
	if(($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 12) && $d == 31)
	     $d = 1;
    else if(($m == 4 || $m == 6 || $m == 9 || $m == 11 ) && $d == 30)
    	 $d = 1;	
    else if($m == 2){
    	if(!leap_year($y) && $d == 28)          $d = 1;
    	else if(leap_year($y) && $d == 29)      $d = 1;}
    return $d;	
}

function nextdaydate($y,$m,$d){
	if($m == 12 && $d == 31){
	    $y = $y+1;
		$m = 1;
		$d = 1;}
	else if(nextday($y, $m, $d) == 1){
		$m = $m+1;
		$d = 1;}
	else $d = $d+1;
	$date[0] = $y;
	$date[1] = $m;
	$date[2] = $d;
	return $date;
}



function chktimeH($h){
	if(!is_numeric($h))
	    return null;
	if($h < 0 || $h > 24)
	    return null;
	return 1;
}

function chktimeM($m){
	if(!is_numeric($m))
	    return null;
	if($m < 0 || $m > 60)
	    return null;
	return 1;
}


?>

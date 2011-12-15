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
$formN = htmlspecialchars($_POST['panel'],ENT_QUOTES);
$description = htmlspecialchars($_POST['desc'],ENT_QUOTES);



if($formN == 4) //  add recuring payout
{
	$pass = 1;
	$transtypeid = 6;
	$selected = htmlspecialchars($_POST['rtPayout'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['pay2name'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['p2amount'],ENT_QUOTES);
	if($amount !=null && (!is_numeric($amount))){
		$usrinpt['amount']="error";
		$usrinpt['err4'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount > 0)){
		$amount = $amount * (-1);
	}
	$sday = htmlspecialchars($_POST['pday2'],ENT_QUOTES);
	$smonth = htmlspecialchars($_POST['pmonth2'],ENT_QUOTES);
	$syear = htmlspecialchars($_POST['pyear2'],ENT_QUOTES);
	$sday2 = htmlspecialchars($_POST['pdayU'],ENT_QUOTES);
	$smonth2 = htmlspecialchars($_POST['pmonthU'],ENT_QUOTES);
	$syear2 = htmlspecialchars($_POST['pyearU'],ENT_QUOTES);
	if(!checkdate(intval($smonth),intval($sday),intval($syear))){
		$usrinpt['date'] = "error";
		$usrinpt['err4'] = 1;
		$pass = 0;
	}
	$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	$recurrance = htmlspecialchars($_POST['r_period'],ENT_QUOTES);
	$sdate = sprintf('%02d.%02d.%4d', $sday, $smonth, $syear);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err4'] = null;
	   if($selected == 'New'){
	          $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname','$recurrance','$transtypeid',null,'$description')") or die(mysqli_error());
	   }
	   else if($selected != 'New'){
	   	      $period = htmlspecialchars($_POST['pchangeP'],ENT_QUOTES);
	   	      $transdate = sprintf('%4d-%02d-%02d', $syear2, $smonth2, $sday2);
	   	      if(!$period){
	   	      	$period = '3';
	   	      }
	   	      $res = $connection->query("CALL editRecurringTransDetails('$selected','$transcustomname','$description','$recurrance','$amount','$period','$transdate')") or die(mysqli_error());
	   }
	   
	   $_SESSION['update'] = 1;
	   header("location:addpayout.php?date=$sdate&month=$smonth&year=$syear");}
	else {
	   $_SESSION['transfer'] = $usrinpt;
	   $pass = 1;
	   header("location:addpayout.php?date=$sdate&month=$smonth&year=$syear");}
}

else if($formN == 5)   // add one time payout
{
	$pass = 1;
	$transtypeid = 5;
	$selected = htmlspecialchars($_POST['rPayout'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['payname'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['pamount'],ENT_QUOTES);
	if($amount !=null && (!is_numeric($amount))){
		$usrinpt['pamount']="error";
		$usrinpt['err5'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount > 0)){
		$amount = $amount * (-1);
	}
	$tday = htmlspecialchars($_POST['pday3'],ENT_QUOTES);
	$tmonth = htmlspecialchars($_POST['pmonth3'],ENT_QUOTES);
	$tyear = htmlspecialchars($_POST['pyear3'],ENT_QUOTES);
	if(!checkdate(intval($tmonth),intval($tday),intval($tyear))){
		$usrinpt['date'] = "error";
		$usrinpt['err5'] = 1;
		$pass = 0;
	}
	$transdate = sprintf('%4d-%02d-%02d', $tyear, $tmonth, $tday);
	$tdate = sprintf('%02d.%02d.%4d', $tday, $tmonth, $tyear);
	if($pass == 1){
		$usrinpt['date'] = null;
		$usrinpt['amount']=null;
		$usrinpt['err5'] = null;
		if($selected == 'New')
		     $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname',null,'$transtypeid',null,'$description')") or die(mysqli_error());
		else if($selected != 'New'){
		     $res = $connection->query("CALL editOneTimeTransDetails('$selected','$transcustomname','$description','$amount')") or die(mysqli_error());
		    }
		$_SESSION['update'] = 1;
	   header("location:addpayout.php?date=$tdate&month=$tmonth&year=$tyear");
	}
	else if ($pass == 0){
		$_SESSION['transfer'] = $usrinpt;
		header("location:addpayout.php?date=$tdate&month=$tmonth&year=$tyear");
	}
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
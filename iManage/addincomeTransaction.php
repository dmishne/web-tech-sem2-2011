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

if($formN == 1)  // Update working hours
{
	$pass = 1;
	$transtypeid = 3;  
	$workname = htmlspecialchars($_POST['workname'],ENT_QUOTES); 
	$amount = htmlspecialchars($_POST['wage'],ENT_QUOTES);
	if(!is_numeric($amount) || (is_numeric($amount) && $amount < 0)){
		$usrinpt['amount']="error";
		$usrinpt['err1'] = 1;
		$pass =0;
	}
/*	$sday = htmlspecialchars($_POST['day'],ENT_QUOTES);
	$smonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
	$syear = htmlspecialchars($_POST['year'],ENT_QUOTES);
	if(!checkdate(intval($smonth),intval($sday),intval($syear))){
		$usrinpt['date'] = "error";
		$usrinpt['err1'] = 1;
		$pass = 0;
	}*/
	$sH = htmlspecialchars($_POST['starth'],ENT_QUOTES);
	$sM = htmlspecialchars($_POST['startm'],ENT_QUOTES);
	$eH = htmlspecialchars($_POST['endh'],ENT_QUOTES);
	$eM = htmlspecialchars($_POST['endm'],ENT_QUOTES);
	if(!chktimeH($sH) || !chktimeM($sM)){
		$usrinpt['time1'] = "error";
		$usrinpt['err1'] = 1;
		$pass = 0;
	}
	if(!chktimeH($eH) || !chktimeM($eM)){
		$usrinpt['time2'] = "error";
		$usrinpt['err1'] = 1;
		$pass = 0;
	}
	$startHour = sprintf('%02d:%02d', $sH, $sM);
	$endHour = sprintf('%02d:%02d', $eH, $eM);
	//$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	//$recurrance = htmlspecialchars($_POST['r_period'],ENT_QUOTES);
	if($pass == 1){
		//$usrinpt['date'] = null;
		$usrinpt['amount']=null;
		$usrinpt['time1'] = null;
		$usrinpt['time2']=null;
		$usrinpt['err1'] = null;
		
		$dd = "2011-10-30";
		$rec = "Daily";
		$transcustomname = $workname;
		
		//$res = $connection->query("CALL insertTransaction('$amount','$username','$dd','$transcustomname','$rec','$transtypeid',null,'$startHour','$endHour','$description')") or die(mysqli_error());
		$_SESSION['update'] = 1;
		header("location:addincome.php");
	}
	else {
		$_SESSION['transfer'] = $usrinpt;
		$pass = 1;
		header("location:addincome.php");
	}
}

else if($formN == 2) //  add recuring income
{
	$pass = 1;
	$transtypeid = 2;
	$selected = htmlspecialchars($_POST['rtIncome'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['inname'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
	if(!is_numeric($amount)){
		$usrinpt['amount']="error";
		$usrinpt['err2'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount < 0)){
		$usrinpt['sign']="error";
		$usrinpt['err2'] = 1;
		$pass =0;
	}
	$sday = htmlspecialchars($_POST['day'],ENT_QUOTES);
	$smonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
	$syear = htmlspecialchars($_POST['year'],ENT_QUOTES);
	if(!checkdate(intval($smonth),intval($sday),intval($syear))){
		$usrinpt['date'] = "error";
		$usrinpt['err2'] = 1;
		$pass = 0;
	}
	$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	$recurrance = htmlspecialchars($_POST['r_period'],ENT_QUOTES);
	$sdate = sprintf('%02d.%02d.%4d', $sday, $smonth, $syear);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err2'] = null;
	   if($selected == 'New')
	          $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname','$recurrance','$transtypeid',null,'$description')") or die(mysqli_error());
	   /*else if($selected != 'New'){
	   	      $res = $connection->query("CALL editJobDetails('$selected','$transcustomname','$description','$amount','$transdate')") or die(mysqli_error());
	   }*/
	   
	   $_SESSION['update'] = 1;
	   header("location:addincome.php?date=$sdate&month=$smonth&year=$syear");}
	else {
	   $_SESSION['transfer'] = $usrinpt;
	   $pass = 1;
	   header("location:addincome.php?date=$sdate&month=$smonth&year=$syear");}
}

else if($formN == 3)   // add one time income
{
	$pass = 1;
	$transtypeid = 1;
	$selected = htmlspecialchars($_POST['rIncome'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['inname'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
	if(!is_numeric($amount)){
		$usrinpt['amount']="error";
		$usrinpt['err3'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount < 0)){
		$usrinpt['sign']="error";
		$usrinpt['err3'] = 1;
		$pass =0;
	}	    
	$tday = htmlspecialchars($_POST['day'],ENT_QUOTES);
	$tmonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
	$tyear = htmlspecialchars($_POST['year'],ENT_QUOTES);
	if(!checkdate(intval($tmonth),intval($tday),intval($tyear))){
		$usrinpt['date'] = "error";
		$usrinpt['err3'] = 1;
		$pass = 0;
	}
	$transdate = sprintf('%4d-%02d-%02d', $tyear, $tmonth, $tday);
	$tdate = sprintf('%02d.%02d.%4d', $tday, $tmonth, $tyear);
	if($pass == 1){
		$usrinpt['date'] = null;
		$usrinpt['amount']=null;
		$usrinpt['err3'] = null;
		if($selected == 'New')
		     $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname',null,'$transtypeid',null,'$description')") or die(mysqli_error());
		else if($selected != 'New'){
		    /* $res = $connection->query("CALL editJobDetails('$selected','$transcustomname','$description','$amount','$transdate')") or die(mysqli_error());*/
		    }
		$_SESSION['update'] = 1;
		header("location:addincome.php?date=$tdate&month=$tmonth&year=$tyear");
	}
	else if ($pass == 0){
		$_SESSION['transfer'] = $usrinpt;
		header("location:addincome.php?date=$tdate&month=$tmonth&year=$tyear");
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
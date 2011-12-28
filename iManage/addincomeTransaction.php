<?php 

include "beforeLoadCheck.php";
include "sessionVerifier.php";

include_once "ini.php";

//Connect to database from here
$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db($serverInfo["db"]);
$username= $_SESSION['username'];  // from current user session submited on login
$formN = verifyInput($_POST['panel']);
if (isset($_POST['desc']))
{
	$description = verifyInput($_POST['desc']);
}

if($formN == 1)  // Update working hours
{
	$pass = 1;
	$timeupdate = 0;
	$transtypeid = 3;  
	$jobId = verifyInput($_POST['workid']); 
	if($jobId != 'clear'){
			//$workName = verifyInput($_POST['workname']);   // marked out for security reasons 
			$amount = verifyInput($_POST['wage']);
			if($amount !=null && (!is_numeric($amount) || (is_numeric($amount) && $amount < 0))){
				$usrinpt['amount']="error";
				$usrinpt['err1'] = 1;
				$pass =0;
			}
			$pday = verifyInput($_POST['day1']);
			$pmonth = verifyInput($_POST['month1']);
			$pyear = verifyInput($_POST['year1']);
			if(!checkdate(intval($pmonth),intval($pday),intval($pyear))){
				$usrinpt['date'] = "error";
				$usrinpt['err1'] = 1;
				$pass = 0;
			}
			$pdate = sprintf('%4d-%02d-%02d', $pyear, $pmonth, $pday);
			$sH = verifyInput($_POST['starth']);
			$sM = verifyInput($_POST['startm']);
			$eH = verifyInput($_POST['endh']);
			$eM = verifyInput($_POST['endm']);
			if($sH && $sM && $eH && $eM){
				$timeupdate = 1;
			}
			if($timeupdate && (!chktimeH($sH) || !chktimeM($sM))){
				$usrinpt['time1'] = "error";
				$usrinpt['err1'] = 1;
				$pass = 0;
			}
			if($timeupdate && (!chktimeH($eH) || !chktimeM($eM))){
				$usrinpt['time2'] = "error";
				$usrinpt['err1'] = 1;
				$pass = 0;
			}	
			$cDay = verifyInput($_POST['curday']);
			$cMonth = verifyInput($_POST['curmonth']);
			$cYear = verifyInput($_POST['curyear']);
			$cDay2 = $cDay;
			$cMonth2 = $cMonth;
			$cYear2 = $cYear;
			if($sH > $eH || (($sH == $eH) && ($sM > $eM)) ){
				$newdate = nextdaydate($cYear, $cMonth, $cDay);
				$cDay2 = $newdate[2];
				$cMonth2 = $newdate[1];
				$cYear2 = $newdate[0];
			}
			$startHour = sprintf('%4d-%02d-%02d %02d:%02d:%02d',$cYear, $cMonth, $cDay, $sH, $sM, 0);
			$endHour = sprintf('%4d-%02d-%02d %02d:%02d:%02d',$cYear2, $cMonth2, $cDay2, $eH, $eM, 0);
			if($pass == 1){
				$usrinpt['amount']=null;
				$usrinpt['time1'] = null;
				$usrinpt['time2']=null;
				$usrinpt['err1'] = null;
				$usrinpt['notallowed'] = null;
				$eres = $connection->query("CALL editJobDetails('$jobId',null,null,'$amount','$pdate')") or die(mysqli_error());
		        if($timeupdate)
		        {
		        	if(is_object($eres)) {
		        		$eres->free(); 
		        	}
					while ($connection->next_result()) {
						//free each result.
						$result = $connection->use_result();
						if ($result instanceof mysqli_result) {
							$result->free();
						}
					}
					$res2 = $connection->query("CALL updateWorkingHours('$jobId','$startHour','$endHour',null)") or die(mysqli_error());
		        }
				$_SESSION['update'] = 1;
				header("location:addincome.php");
			}
			else {
				$_SESSION['transfer'] = $usrinpt;
				$pass = 1;
				header("location:addincome.php");
			}
	  }
	  else {
	  	$usrinpt['notallowed'] = "error";
	  	$usrinpt['err1'] = 1;
	  	$_SESSION['transfer'] = $usrinpt;
	  	$pass = 1;
	  	header("location:addincome.php");
	  }
}

else if($formN == 2) //  add recuring income
{
	$pass = 1;
	$transtypeid = 2;
	$selected = verifyInput($_POST['rtIncome']);    // get values - "New" or jobId
	$transcustomname = verifyInput($_POST['inname']);
	$amount = verifyInput($_POST['amount']);
	if($amount !=null && (!is_numeric($amount) || (is_numeric($amount) && $amount < 0))){
		$usrinpt['amount']="error";
		$usrinpt['err2'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount < 0)){
		$usrinpt['sign']="error";
		$usrinpt['err2'] = 1;
		$pass =0;
	}
	$sday = verifyInput($_POST['day2']);
	$smonth = verifyInput($_POST['month2']);
	$syear = verifyInput($_POST['year2']);
	$sday2 = verifyInput($_POST['dayU']);
	$smonth2 = verifyInput($_POST['monthU']);
	$syear2 = verifyInput($_POST['yearU']);
	if(($selected != 'New') && (!checkdate(intval($smonth2),intval($sday2),intval($syear2))))  // it's UPDATE - check DATE2
	{
		$usrinpt['date'] = "error";
		$usrinpt['err2'] = 1;
		$pass = 0;
	}
	else if(!checkdate(intval($smonth),intval($sday),intval($syear)))  // it's new Income - check DATE
	{
		$usrinpt['date'] = "error";
		$usrinpt['err2'] = 1;
		$pass = 0;
	}
	$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	$recurrance = verifyInput($_POST['r_period']);
	$sdate = sprintf('%02d.%02d.%4d', $sday, $smonth, $syear);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err2'] = null;
	   if($selected == 'New')
	          $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname','$recurrance','$transtypeid',null,'$description')") or die(mysqli_error());
	   else if($selected != 'New'){
	   	      $period = verifyInput($_POST['changeP']);
	   	      
	   	      $transdate = sprintf('%4d-%02d-%02d', $syear2, $smonth2, $sday2);
	   	      if(!$period){ $period = '3';}
	   	      $res = $connection->query("CALL editRecurringTransDetails('$selected','$transcustomname','$description','$recurrance','$amount','$period','$transdate')") or die(mysqli_error());
	   }
	   
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
	$selected = verifyInput($_POST['rIncome']);    // get values - "New" or jobId
	$transcustomname = verifyInput($_POST['inname']);
	$amount = verifyInput($_POST['amount']);
	if($amount !=null && (!is_numeric($amount) || (is_numeric($amount) && $amount < 0))){
		$usrinpt['amount']="error";
		$usrinpt['err3'] = 1;
		$pass =0;
	}
	if((is_numeric($amount) && $amount < 0)){
		$usrinpt['sign']="error";
		$usrinpt['err3'] = 1;
		$pass =0;
	}	    
	$tday = verifyInput($_POST['day3']);
	$tmonth = verifyInput($_POST['month3']);
	$tyear = verifyInput($_POST['year3']);
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
		     $res = $connection->query("CALL editOneTimeTransDetails('$selected','$transcustomname','$description','$amount')") or die(mysqli_error());
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
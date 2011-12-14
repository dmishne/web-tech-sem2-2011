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
	$timeupdate = 0;
	$transtypeid = 3;  
	$jobId = htmlspecialchars($_POST['workid'],ENT_QUOTES); 
	if($jobId != 'clear'){
			//$workName = htmlspecialchars($_POST['workname'],ENT_QUOTES);   // marked out for security reasons 
			$amount = htmlspecialchars($_POST['wage'],ENT_QUOTES);
			if($amount !=null && (!is_numeric($amount) || (is_numeric($amount) && $amount < 0))){
				$usrinpt['amount']="error";
				$usrinpt['err1'] = 1;
				$pass =0;
			}
			$pday = htmlspecialchars($_POST['day1'],ENT_QUOTES);
			$pmonth = htmlspecialchars($_POST['month1'],ENT_QUOTES);
			$pyear = htmlspecialchars($_POST['year1'],ENT_QUOTES);
			if(!checkdate(intval($pmonth),intval($pday),intval($pyear))){
				$usrinpt['date'] = "error";
				$usrinpt['err1'] = 1;
				$pass = 0;
			}
			$pdate = sprintf('%4d-%02d-%02d', $pyear, $pmonth, $pday);
			$sH = htmlspecialchars($_POST['starth'],ENT_QUOTES);
			$sM = htmlspecialchars($_POST['startm'],ENT_QUOTES);
			$eH = htmlspecialchars($_POST['endh'],ENT_QUOTES);
			$eM = htmlspecialchars($_POST['endm'],ENT_QUOTES);
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
			$cDay = htmlspecialchars($_POST['curday'],ENT_QUOTES);
			$cMonth = htmlspecialchars($_POST['curmonth'],ENT_QUOTES);
			$cYear = htmlspecialchars($_POST['curyear'],ENT_QUOTES);
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
		        	$eres->free();
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
	$selected = htmlspecialchars($_POST['rtIncome'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['inname'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
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
	$sday = htmlspecialchars($_POST['day2'],ENT_QUOTES);
	$smonth = htmlspecialchars($_POST['month2'],ENT_QUOTES);
	$syear = htmlspecialchars($_POST['year2'],ENT_QUOTES);
	$sday2 = htmlspecialchars($_POST['dayU'],ENT_QUOTES);
	$smonth2 = htmlspecialchars($_POST['monthU'],ENT_QUOTES);
	$syear2 = htmlspecialchars($_POST['yearU'],ENT_QUOTES);
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
	$recurrance = htmlspecialchars($_POST['r_period'],ENT_QUOTES);
	$sdate = sprintf('%02d.%02d.%4d', $sday, $smonth, $syear);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err2'] = null;
	   if($selected == 'New')
	          $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname','$recurrance','$transtypeid',null,'$description')") or die(mysqli_error());
	   else if($selected != 'New'){
	   	      $period = htmlspecialchars($_POST['changeP'],ENT_QUOTES);
	   	      
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
	$selected = htmlspecialchars($_POST['rIncome'],ENT_QUOTES);    // get values - "New" or jobId
	$transcustomname = htmlspecialchars($_POST['inname'],ENT_QUOTES);
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
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
	$tday = htmlspecialchars($_POST['day3'],ENT_QUOTES);
	$tmonth = htmlspecialchars($_POST['month3'],ENT_QUOTES);
	$tyear = htmlspecialchars($_POST['year3'],ENT_QUOTES);
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
<?php session_start();

//Connect to database from here
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection->select_db('webtech');
$username= $_SESSION['firstname'];  // from current user session submited on login
$formN = htmlspecialchars($_POST['panel'],ENT_QUOTES);
$transcustomname = htmlspecialchars($_POST['inname'],ENT_QUOTES);
$description = htmlspecialchars($_POST['desc'],ENT_QUOTES);
//echo $pass;

if($formN == 1)
{
	$pass = 1;
	$transtypeid = 1;
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
	if(!is_numeric($amount)){
	    $usrinpt['amount']="error";
	    $usrinpt['err1'] = 1;
	    $pass =0;}
	$tday = htmlspecialchars($_POST['day'],ENT_QUOTES);
	$tmonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
	$tyear = htmlspecialchars($_POST['year'],ENT_QUOTES);
	if(!checkdate(intval($tmonth),intval($tday),intval($tyear))){
	    $usrinpt['date'] = "error";
	    $usrinpt['err1'] = 1;
	    $pass = 0;}
	$transdate = sprintf('%4d-%02d-%02d', $tyear, $tmonth, $tday);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err1'] = null;
	   $res = $connection->query("CALL insertTransaction('$amount','$username','$transdate','$transcustomname',null,'$transtypeid',null,null,null,'$description')") or die(mysqli_error());
	   header("location:addincome.php");
	   }
    else if ($pass == 0){
       $_SESSION['addincome'] = $usrinpt;
       header("location:addincome.php");}
}

else if($formN == 2)
{
	$pass = 1;
	$transtypeid = 2;
	$amount = htmlspecialchars($_POST['amount'],ENT_QUOTES);
	if(!is_numeric($amount)){
		$usrinpt['amount']="error";
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
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['err2'] = null;
	   $res = $connection->query("CALL insertTransaction('$transtypeid','$username','$amount','$transdate','$transcustomname','$recurrance','$description')") or die(mysqli_error());
	   header("location:addincome.php");}
	else {
	   $_SESSION['addincome'] = $usrinpt;
	   $pass = 1;
	   header("location:addincome.php");}
}

else if($formN == 3)
{
	$pass = 1;
	$transtypeid = 3;
    $amount = htmlspecialchars($_POST['wage'],ENT_QUOTES);
    if(!is_numeric($amount)){
    	$usrinpt['amount']="error";
    	$usrinpt['err3'] = 1;
    	$pass =0;
    }
		$sday = htmlspecialchars($_POST['day'],ENT_QUOTES);
		$smonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
		$syear = htmlspecialchars($_POST['year'],ENT_QUOTES);
	if(!checkdate(intval($smonth),intval($sday),intval($syear))){
			$usrinpt['date'] = "error";
			$usrinpt['err3'] = 1;
			$pass = 0;
	}	
		$sH = htmlspecialchars($_POST['starth'],ENT_QUOTES);
		$sM = htmlspecialchars($_POST['startm'],ENT_QUOTES);
		$eH = htmlspecialchars($_POST['endh'],ENT_QUOTES);
		$eM = htmlspecialchars($_POST['endm'],ENT_QUOTES);
	if(!chktimeH($sH) || !chktimeM($sM)){
			$usrinpt['time1'] = "error";
			$usrinpt['err3'] = 1;
			$pass = 0;
	}	
	if(!chktimeH($eH) || !chktimeM($eM)){
		$usrinpt['time2'] = "error";
		$usrinpt['err3'] = 1;
		$pass = 0;
	}		
	$startHour = sprintf('%02d:%02d', $sH, $sM);
	$endHour = sprintf('%02d:%02d', $eH, $eM);
	$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	$recurrance = htmlspecialchars($_POST['r_period'],ENT_QUOTES);
	if($pass == 1){
	   $usrinpt['date'] = null;
	   $usrinpt['amount']=null;
	   $usrinpt['time1'] = null;
	   $usrinpt['time2']=null;
	   $usrinpt['err3'] = null;
	   $res = $connection->query("CALL insertTransaction('$transtypeid','$username','$amount','$transdate','$startHour','$endHour','$transcustomname','$recurrance','$description')") or die(mysqli_error());
	   header("location:addincome.php");}
    else {
	   $_SESSION['addincome'] = $usrinpt;
	   $pass = 1;
       header("location:addincome.php");}
}

else if($formN == 4)
{
	$pass = 1;
	$transtypeid = 4;
    $amount = htmlspecialchars($_POST['wage'],ENT_QUOTES);
    if(!is_numeric($amount)){
    	$usrinpt['amount']="error";
    	$usrinpt['err4'] = 1;
    	$pass =0;
    }
	    $sday = htmlspecialchars($_POST['day'],ENT_QUOTES);
		$smonth = htmlspecialchars($_POST['month'],ENT_QUOTES);
		$syear = htmlspecialchars($_POST['year'],ENT_QUOTES);
		$wday = htmlspecialchars($_POST['wday'],ENT_QUOTES);
		$wmonth = htmlspecialchars($_POST['wmonth'],ENT_QUOTES);
		$wyear = htmlspecialchars($_POST['wyear'],ENT_QUOTES);
		if(!checkdate(intval($smonth),intval($sday),intval($syear))){
			$usrinpt['date'] = "error";
			$usrinpt['err4'] = 1;
			$pass = 0;
		}
		else if(!checkdate(intval($wmonth),intval($wday),intval($wyear))){
			$usrinpt['date2'] = "error";
			$usrinpt['err4'] = 1;
			$pass = 0;
		}	
		$sH = htmlspecialchars($_POST['starth'],ENT_QUOTES);
		$sM = htmlspecialchars($_POST['startm'],ENT_QUOTES);
		$eH = htmlspecialchars($_POST['endh'],ENT_QUOTES);
		$eM = htmlspecialchars($_POST['endm'],ENT_QUOTES);
	if(!chktimeH($sH) || !chktimeM($sM)){
		$usrinpt['time1'] = "error";
		$usrinpt['err4'] = 1;
		$pass = 0;
	}
	if(!chktimeH($eH) || !chktimeM($eM)){
		$usrinpt['time2'] = "error";
		$usrinpt['err4'] = 1;
		$pass = 0;
	}	
	$startHour = sprintf('%4d-%02d-%02d %02d:%02d:%02d',$wyear, $wmonth, $wday, $sH, $sM, 00);
	if( $sH > $eH || (($sH == $eH) && ($sM > $eM)) ){
	   $newdate = nextdaydate($wyear, $wmonth, $wday);
	   $endHour = sprintf('%4d-%02d-%02d %02d:%02d:%02d',$newdate[0], $newdate[1], $newdate[2], $eH, $eM, 00);}
	else 
	   $endHour = sprintf('%4d-%02d-%02d %02d:%02d:%02d',$wyear, $wmonth, $wday, $eH, $eM, 00);
	$transdate = sprintf('%4d-%02d-%02d', $syear, $smonth, $sday);
	if($pass == 1){
		$usrinpt['date'] = null;
		$usrinpt['amount']=null;
		$usrinpt['time1'] = null;
		$usrinpt['time2']=null;
		$usrinpt['date2']=null;
		$usrinpt['err4'] = null;
	    $res = $connection->query("CALL insertTransaction('$transtypeid','$username','$amount','$transdate','$transcustomname','$description')") or die(mysqli_error());
	    header("location:addincome.php");}
    else {
	   $_SESSION['addincome'] = $usrinpt;
	   $pass = 1;
       header("location:addincome.php");}
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
	if($h < 0 || $h > 24)
	return null;
	return 1;
}

function chktimeM($m){
	if($m < 0 || $m > 60)
	return null;
	return 1;
}


?>
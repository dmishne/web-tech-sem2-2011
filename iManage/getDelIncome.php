<?php

include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();
include_once "ini.php";

$delmonth = verifyInput($_POST['delMonth']);
$delyear = verifyInput($_POST['delYear']);
$delDate = sprintf('%4d-%02d-%02d', $delyear, $delmonth, '01');

$_SESSION['deletedate']=$delDate;
$_SESSION['deletemonth']=$delmonth;
$_SESSION['deleteyear']=$delyear;
$formD = verifyInput($_POST['deleteform']);
  if ( $formD == "deleteIncome")
      {$where = "location:delincome.php";}
  else if ( $formD == "deletePayout")
      {$where = "location:delpayout.php";}
     header($where)
?>
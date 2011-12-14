<?php session_start();

/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
header("location:login.php");
}*/
$delmonth = htmlspecialchars($_POST['delMonth'],ENT_QUOTES);
$delyear = htmlspecialchars($_POST['delYear'],ENT_QUOTES);
$delDate = sprintf('%4d-%02d-%02d', $delyear, $delmonth, '01');

$_SESSION['deletedate']=$delDate;
$_SESSION['deletemonth']=$delmonth;
$_SESSION['deleteyear']=$delyear;
$formD = htmlspecialchars($_POST['deleteform'],ENT_QUOTES);
  if ( $formD == "deleteIncome")
      {$where = "location:delincome.php";}
  else if ( $formD == "deletePayout")
      {$where = "location:delpayout.php";}
     header($where)
?>
<?php 
include "beforeLoadCheck.php";
session_start();
include_once "ini.php";
if (isset($_GET['logout']) && verifyInput($_GET['logout']) == 1) {
	session_unset();
}
$loggedin = 0;
if(isset($_SESSION['login']) && $_SESSION['login'] != '0')
{
	$loggedin = intval($_SESSION['login']);
}
?>

<?php 
		if($loggedin)
		{
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
				
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3);
			$month = date('F');
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, 01);
			$monthSum = $connection->query("CALL getTopMonthlyTransactions('$username','$date2')") or die(mysqli_error());
			$incomes = array();
			$payouts = array();
			if($monthSum->num_rows > 0){
				while ($rowm = $monthSum->fetch_array(MYSQLI_ASSOC)){
					$transname = $rowm['transname'];
					$amnt = $rowm['amount'];
					$trnstype = $rowm['transtype'];
					$descript = $rowm['description'];
					$trdate = $rowm['transdate'];
					if ($amnt > 0){
						$incomes[] = array('transname' => $transname, 'amount' => $amnt , 'transtype' => $trnstype, 'description' => $descript , 'transdate' => $trdate);
					}
					else if ($amnt < 0){
						$payouts[] = array('transname' => $transname, 'amount' => $amnt , 'transtype' => $trnstype, 'description' => $descript , 'transdate' => $trdate);
					}
				}
			}
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> iManage </title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<link rel="icon" href="images/logo.ico" />
	<link rel="apple-touch-icon" href="images/icon_apple.png" />
	<?php include "include.php"; ?>
	<script type="text/javascript" src="JQueryUI/jquery-ui-1.8.16.custom.min.js"> </script>
	<link rel="stylesheet" href="JQueryUI/jquery-ui-1.8.16.custom.css" type="text/css"/>
	<style type="text/css">
		.ui-widget {
			font-size: 0.75em;
		}	
	</style>
	<script type="text/javascript">
		$(function() {
			$( '#tabs' ).tabs();
		});
	</script>
	
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php"; ?>
	</div>
	
	<div id="middle">
		<div class="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
				Home Page
			</div>
			<div id="content-middle">
		           <div id="tabs">
		           		<ul>
							<li><a href='#tabs-1'>Overview</a></li>
							<li><a href='#tabs-2'>Incomes</a></li>
							<li><a href='#tabs-3'>Payouts</a></li>
							<li><a href='#tabs-4'>Investments</a></li>
						</ul>
						<div id='tabs-1'>
							<p>aaaa</p>
						</div>
						<div id='tabs-2' style="margin: 0px auto 0px auto; text-align:center; width:100%;">
						<?php 
							if(!empty($incomes))
							{ 
								echo "<table style='margin: 0px auto 0px auto;'>";
								echo "<tr> <th colspan='4'> Last Top Incomes of $month </th></tr>";
					            foreach ($incomes as &$in)
					            {
					            	$transname = $in['transname'];
					            	$amnt = $in['amount'];
					            	$trnstype = $in['transtype'];
					            	$descript = $in['description'];
					            	$transdate = $in['transdate'];
					            	echo "<tr>";
					            	$div1 = "<td class=\"greeninc \" style=\"cursor:help float:left;\" title=\"$descript\">";
					            	$div2 = "<td class=\"greeninc roundedinccntr\" style=\"cursor:help\" title=\"$descript\">";
					            	$div3 = "<td class=\"greeninc \" style=\"cursor:help\" title=\"$descript\">";
					            	$div4 = "<td class=\"greeninc \" style=\"cursor:help\" title=\"$descript\">";
					            	echo "{$div4}$transdate </td>";
					            	echo "{$div1}$trnstype</td>";
					            	echo "{$div1}$transname</td>";
					            	echo "{$div3}$amnt$ </td>";
					            	echo "</tr>";
					            }
					            echo "</table>";
							}
							else {
								echo "<p> No Incomes Available </p>";
							}
				             
						?>
						</div>
						<div id='tabs-3' style="margin: 0px auto 0px auto; text-align:center; width:100%;">
							<?php 
							if(!empty($payouts))
							{ 
								echo "<table style='margin: 0px auto 0px auto;'>";
								echo "<tr> <th colspan='4'> Last Top Payouts of $month</th></tr>";
					            foreach ($payouts as &$out)
					            {
					            	$transname = $out['transname'];
					            	$amnt = $out['amount'];
					            	$trnstype = $out['transtype'];
					            	$descript = $out['description'];
					            	$transdate = $out['transdate'];
					            	echo "<tr>";
					            	$div1 = "<td class=\"redinc \" style=\"cursor:help\" title=\"$descript\">";
					            	$div2 = "<td class=\"redinc roundedinccntr\" style=\"cursor:help\" title=\"$descript\">";
					            	$div3 = "<td class=\"redinc \" style=\"cursor:help\" title=\"$descript\">";
					            	$div4 = "<td class=\"redinc \" style=\"cursor:help\" title=\"$descript\">";
					            	echo "{$div4}$transdate </td>";
					            	echo "{$div1}$trnstype</td>";
					            	echo "{$div1}$transname</td>";
					            	echo "{$div3}$amnt$ </td>";
					            	echo "</tr>";
					            }
					            echo "</table>";
							}
							else {
								echo "<p> No Payouts Available </p>";
							}   
						?>
						</div>
						<div id='tabs-4'>
							<p>dddd</p>
						</div>
		           </div>
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->

</body>
</html>
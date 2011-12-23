<?php 

include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();
include_once "ini.php";
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
	
	<!--  Highlight Charts Source -->
	<script type="text/javascript" src="chart/highcharts.js"></script>
	<!--  Highlight Charts Theme -->
	<script type="text/javascript" src="chart/gray.js"></script>
	<!--  Highlight Charts Exporting Module -->
	<script type="text/javascript" src="chart/exporting.js"></script>
	
	<script type="text/javascript">
	<?php 
			$username= $_SESSION['username'];
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			$connection->select_db($serverInfo["db"]);
			
			$res = $connection->query("CALL balanceYearlyReport('$username')") or die(mysqli_error());
			$userYearReport = array();
			$months = array();
			if($res->num_rows > 0)
			{
				$i = 0;
				$j = 0;
				$totalm = 0;
				while ($r = $res->fetch_array(MYSQLI_NUM)){
					$userYearReport[$i][$j] = is_null($r[1])?0:floatval($r[1]);
					$months[$j] = substr($r[2],0,3);
					$totalm+=$userYearReport[$i][$j];
					$i++;
					if( $i == 5 )
					{
						$userYearReport[$i][$j] = $totalm;
						$i = 0;
						$j++;
					}
				}
				echo "var userYearReport = " . json_encode($userYearReport, true) . ";";
				echo "var months = " . json_encode($months, true) . ";";
			}
			else {
				echo "var userYearReport = {};";
			}
	?>















	
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'line',
					marginRight: 130,
					marginBottom: 25
				},
				title: {
					text: 'Yearly Report',
					x: -20 //center
				},
				subtitle: {
					text: 'Last Twelve Months',
					x: -20
				},

				credits: {
			        enabled: false
			    },
			    
				xAxis: {
					categories: months
				},
				yAxis: {
					title: {
						text: 'Income ($)'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
			                return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ this.y +'$';
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: [{
					name: 'Profit',
					data: userYearReport[5]
				},  {
					name: 'One Time Income',
					data: userYearReport[0]
				}, {
					name: 'Recurring Income',
					data: userYearReport[1]
				}, {
					name: 'Jobs',
					data: userYearReport[2]
				}, {
					name: 'One Time Payout',
					data: userYearReport[3]
				}, {
					name: 'Recurring Payout',
					data: userYearReport[4]
				}]
			});
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
		           General Yealy Report
			</div>
			<div id="content-middle">
		          <div id="container" style="min-width: 500px; height: 500px; margin: 0px auto auto auto"></div>
			</div>
		</div>
	</div>
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>
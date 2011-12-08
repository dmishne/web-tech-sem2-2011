<?php session_start();

/**
 * Get user's stock information!!!!!!!!
 * something like that:
 * 
 *  
 *  
$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678"); 
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}
$connection->select_db('webtech');
$username= $_SESSION['username'];  // from current user session submited on login
res = $connection->query("CALL getUserStocksInformation('$username')") or die(mysqli_error());
$stocks = $res->fetch_array(MYSQLI_NUM);
 *  
 *  
 * 
 */
$stocks[0] = "GOOG";
$stocks[1] = "AAPL";
$stocks[2] = "INTC";
$stocks[3] = "GE";
$stocks[4] = "F";

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
	
	<!--  Highlight Stocks Source -->
	<script type="text/javascript" src="chart/highstock.js"></script>
	<!--  Highlight Charts Theme -->
 	<script type="text/javascript" src="chart/gray.js"></script>
	<!--  Highlight Charts Exporting Module -->
	<script type="text/javascript" src="chart/exporting.js"></script>
	<script type="text/javascript" src="jquery.csv.min.js"></script>
	<script type="text/javascript">
	/*
	$(function() {
		var seriesOptions = [],
			yAxisOptions = [],
			seriesCounter = 0,
			names = ['MSFT', 'AAPL', 'GOOG'],
			colors = Highcharts.getOptions().colors;

	
		$.each(names, function(i, name) {
			
			$.get('geturl.php',{url:'http://ichart.yahoo.com/table.csv?s='+ name +'&a=0&b=1&c=2009&g=d&ignore=.csv'}, function(to_do_data) {				

				dataArray = jQuery.csv()(to_do_data);
				data = [];
				$.each(dataArray, function(k, value) {
					if(k!=0)
					{
						data[k-1] = [Date.parse(value[0]),value[4]];
					}
				});
				data.reverse();
				
				seriesOptions[i] = {
					name: name,
					data: data
				};
				
				// As we're loading the data asynchronously, we don't know what order it will arrive. So
				// we keep a counter and create the chart when all the data is loaded.
				seriesCounter++;
				if (seriesCounter == names.length) {
					createChart();
				}
			});
		});

		*/
	
	// create the chart when all data is loaded
	function createChart() {
		chart = new Highcharts.StockChart({
		    chart: {
		        renderTo: 'container-stock'
		    },

		    rangeSelector: {
		        selected: 4
		    },

		    yAxis: {
		    	labels: {
		    		formatter: function() {
		    			return (this.value > 0 ? '+' : '') + this.value + '%';
		    		}
		    	},
		    	plotLines: [{
		    		value: 0,
		    		width: 2,
		    		color: 'silver'
		    	}]
		    },
		    plotOptions: {
		    	series: {
		    		compare: 'percent'
		    	}
		    },
		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
		    	yDecimals: 2
		    },
		    legend: {
				enabled: true,
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			},
		    series: seriesOptions
		});
	}
		
//	});
	
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
		           Content Head
			</div>
			<div id="content-middle">
				  <div id="stockInfo"></div>
		                 
		          <div id="userStock">
		          	<table id="userStockTable">
		          		<tr>
		          			<th>Symbol</th>
		          			<th>Name</th>
		          			<th>Amount Invested</th>
		          			<th>Start Value</th>
		          			<th>Today Value</th>
		          			<th>Change</th>
		          			<th>Profit</th>
		          		</tr>
		          		
		          	
		          	
		          	</table>		                   

		          </div>       
		          <div id="container-stock"> 
		          <?php include "YahooStock.php";
		          		$y = new YahooStockPage($stocks);
						$y->showStockPage(); ?>
						<img style="margin-top:200px;" src="images/loading.gif"></img>
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
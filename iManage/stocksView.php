<?php
include "beforeLoadCheck.php"; 
include "sessionVerifier.php";
session_start();

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
	var seriesOptions = [];
	var stockData = {};
	var chart = null;
	var names = ['MSFT', 'AAPL', 'GOOG', 'INTC'];
	
	var createTableRow = function(stocksymbol) {
		$('#stocksTable tr:last').after('<tr> <td>'+ stocksymbol +'</td> <td>' + stockData[stocksymbol][0] + '</td> <td> amount </td> <td> sdate </td> <td> svalue</td> <td>' + stockData[stocksymbol][1] + '</td> <td> Change </td> <td> Profit </td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + stocksymbol + '\')\"> View </div> </td> </tr>');
	}
	
	// create chart of single stock
	var createChartSingle = function(stocksymbol) {
		singlechart = new Highcharts.StockChart({
			chart : {
				renderTo : 'container-stock'
			},
			rangeSelector : {
				selected : 1
			},
			title : {
				text : stocksymbol + ' Stock Price'
			},
			xAxis : {
				maxZoom : 14 * 24 * 3600000 // fourteen days
			},
		    credits: {
		        enabled: false
		    },
			series : [{
				name : stocksymbol,
				data : stockData[stocksymbol][2],
				tooltip: {
					yDecimals: 2
				}
			}]
		});
	}
	
	// create the chart of many variables
	var createChart = function() {
		if (chart != null)
		{
			
			$.each(names, function(i, name) {
				seriesOptions[i] = {
						name: name,
						data: stockData[name][2]
					};
			});
		}
		chart = new Highcharts.StockChart({
		    chart: {
		        renderTo: 'container-stock'
		    },
		    rangeSelector: {
		        selected: 4
		    },
		    title : {
				text : 'Compare Your Stocks'
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
		    credits: {
		        enabled: false
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

	$(function() {
		var yAxisOptions = [],
			seriesCounter = 0,
			colors = Highcharts.getOptions().colors;

	
		$.each(names, function(i, name) {
			stockData[name] = [];
			$.get('geturl.php',{url:'http://download.finance.yahoo.com/d/quotes.csv?s=' + name +'&f=snp'}, function(data) {
				dataArray = jQuery.csv()(data);
				stockData[name][0] = dataArray[0][1];
				stockData[name][1] = parseFloat(dataArray[0][2]);
				$.get('geturl.php',{url:'http://ichart.yahoo.com/table.csv?s='+ name +'&a=0&b=1&c=2009&g=d&ignore=.csv'}, function(to_do_data) {				

					dataArray = jQuery.csv()(to_do_data);
					data = [];
					$.each(dataArray, function(k, value) {
						if(k!=0)
						{
							sdate = value[0].split("-");
							tdate = new Date(Date.UTC(sdate[0],sdate[1]-1,sdate[2]));
							data[k-1] = [Math.round(tdate.getTime()),parseFloat(value[4])];
						}
					});
					data.reverse();
					stockData[name][2] = data;
					seriesOptions[i] = {
						name: name,
						data: data
					};
					
					// As we're loading the data asynchronously, we don't know what order it will arrive. So
					// we keep a counter and create the chart when all the data is loaded.
					createTableRow(name);
					seriesCounter++;
					if (seriesCounter == names.length) {
						$('#stocksTable tr:last').after("<tr> <td colspan=9> <div class=\"blue buttonStyle medium\" onclick=\"createChart()\"> Compare </div></td></tr>");
						createChart();
					}
				});
			});
			
			
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
		           Virtual Portfolio
			</div>
			<div id="content-middle">
	                 
		          <div id="userStock">
		          	<table class="stocksTablesStyle" id="stocksTable">
		          		<tr style="background-color:#0099ff; display: table-row;">
		          			<th>Symbol</th>
		          			<th>Name</th>
		          			<th>Amount Invested</th>
		          			<th>Start Date</th>
		          			<th>Start Value</th>
		          			<th>Last Value</th>
		          			<th>Change</th>
		          			<th>Profit</th>
		          			<th></th>
		          		</tr>
		          	</table>		                   
		          </div>       
		          <div id="container-stock"> 
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
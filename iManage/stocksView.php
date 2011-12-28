<?php
	include "beforeLoadCheck.php"; 
	include "sessionVerifier.php";
	session_start();
	if('3' != $_SESSION['permissionid'] && '2' != $_SESSION['permissionid'])
	{
		header("location:index.php");
	}
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
	
	<!--  Highlight Stocks Source -->
	<script type="text/javascript" src="chart/highstock.js"></script>
	<!--  Highlight Charts Theme -->
 	<script type="text/javascript" src="chart/gray.js"></script>
	<script type="text/javascript" src="jquery.csv.min.js"></script>
	<script type="text/javascript">
	<?php 
			$username= $_SESSION['username'];
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			$connection->select_db($serverInfo["db"]);
			
			$res = $connection->query("CALL getAllInvestments('$username')") or die(mysqli_error());
			$userStockInformation = array();
			if($res->num_rows > 0)
			{
				while ($r = $res->fetch_array(MYSQLI_NUM)){
					if($r[0] != null)
					{
						$userStockInformation[$r[0]] = $r;
					}
				}
			}
			if (!empty($userStockInformation)) {
				echo "var userStockInfo = " . json_encode($userStockInformation, true) . ";";
			}
			else {
				echo "var userStockInfo = {};";
			}
	?>
	var seriesOptions = [];
	var seriesCounter = 0;
	var stockData = {};
	var counter = 0;
	var chart = null;
	var names = ['MSFT', 'AAPL', 'GOOG', 'INTC'];

	var createTableRow = function(id) {
		symbol = userStockInfo[id][1];
		name = stockData[symbol][0];
		amount_inv = (parseFloat(userStockInfo[id][2])).toFixed(2);
		sdate = userStockInfo[id][3];
		svalue = parseFloat(userStockInfo[id][4]).toFixed(2);
		lvalue = (stockData[symbol][1]).toFixed(2);
		change = (((lvalue-svalue)*100)/svalue).toFixed(2);
		profit = (change*amount_inv/100).toFixed(2);
		$('#stocksTable tr:last').after('<tr> <td>'+ symbol +'</td> <td>' + name + '</td> <td>' + amount_inv + '</td> <td>' + sdate + '</td> <td>' + svalue + '</td> <td>' + lvalue + '</td> <td>' +  change   + '% </td> <td>' + profit + '</td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + symbol + '\')\"> View </div> </td> </tr>');
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
			var scount = 0;
			for( sdata in stockData )
			{
				seriesOptions[scount] = {
					name: sdata,
					data: stockData[sdata][2]
				};
				scount++
			}
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

function getAssocArrayLength(tempArray) 
{
	var result = 0;
	for ( tempValue in tempArray ) {
		result++;
	}	
	return result;
}

function waitForElement(i,symbol){
    if(typeof (stockData[symbol][2]) != "undefined"){
    	createTableRow(i);
    	counter++;
		if (counter == getAssocArrayLength(userStockInfo))
		{
			$('#stocksTable tr:last').after("<tr> <td colspan=9> <div class=\"blue buttonStyle medium\" onclick=\"createChart()\"> Compare </div></td></tr>");
		}
    }
    else{
        setTimeout(function(){
            waitForElement(i,symbol);
        },250);
    }
}
 
var addStockInformation = function (symbol, f) {
	if (typeof stockData[symbol]=="undefined")
	{
		stockData[symbol] = [];
		$.get('geturl.php',{url:'http://download.finance.yahoo.com/d/quotes.csv?s=' + symbol +'&f=snp'}, function(data) {
			dataArray = jQuery.csv()(data);
			if (typeof(dataArray[0][2]) != "undefined" && !isNaN(dataArray[0][2]))
			{
				stockData[symbol][0] = dataArray[0][1];
				stockData[symbol][1] = parseFloat(dataArray[0][2]);
				$.get('geturl.php',{url:'http://ichart.yahoo.com/table.csv?s='+ symbol +'&a=0&b=1&c=2009&g=d&ignore=.csv'}, function(to_do_data) {				
					dataArray = jQuery.csv()(to_do_data);
					data = [];
					if (dataArray[0].length == 7)
					{
						$.each(dataArray, function(k, value) {
							if(k!=0)
							{
								sdate = value[0].split("-");
								tdate = new Date(Date.UTC(sdate[0],sdate[1]-1,sdate[2]));
								data[k-1] = [tdate.getTime(),parseFloat(value[4])];
							}
						});
						stockData[symbol][2] = data;
						data.reverse();
						if (typeof f == "function") 
						{
							f(symbol,"new");
						}
					}
					else {
						document.getElementById("container-stock").innerHTML="";
					}			
				});
			}
			else {
				document.getElementById("container-stock").innerHTML="";
			}
		});
	}
	else {
		if (typeof f == "function") 
		{
			f(symbol,"exist");
		}
	}
}

$(function() {
	var yAxisOptions = [],
		colors = Highcharts.getOptions().colors,
		colCounter = 0,
		datacount = 0;
	var length = getAssocArrayLength(userStockInfo);
	if(length != 0)
	{
		$.each(userStockInfo, function(i, stock) {
			symbol = stock[1];
			addStockInformation(symbol,function (symbol , isexist) { 
				colCounter++;
				if (isexist == "new")
				{
					seriesOptions[seriesCounter] = {
						name: symbol,
						data: stockData[symbol][2]
					};
					// As we're loading the data asynchronously, we don't know what order it will arrive. So
					// we keep a counter and create the chart when all the data is loaded.
					seriesCounter++;
					if (colCounter == length) {
						createChart();
					}
				}
			});
			datacount++;
		});
		if(datacount == length)
		{
			$.each(userStockInfo, function(i, stock) {
				symbol = stock[1];
				waitForElement(i,symbol);
			});	
		}
	}
	else {
		emptyTableRow();
		document.getElementById("container-stock").innerHTML="";
	}
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
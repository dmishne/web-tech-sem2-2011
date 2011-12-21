<?php 
include "beforeLoadCheck.php";
include "sessionVerifier.php";
session_start();
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
	var lc = 0;
	var stockData = {};
	var chart = null;
	var names = ['MSFT', 'AAPL', 'GOOG', 'INTC'];

	var createTableRow = function(stocksymbol) {
		lc++;
		$('#stocksTable tr:last').after('<tr id=\"SM_\"'+ lc +'> <td>'+ stocksymbol +'</td> <td>' + stockData[stocksymbol][0] + '</td> <td> amount </td> <td> sdate </td> <td> svalue</td> <td>' + stockData[stocksymbol][1] + '</td> <td> Change </td> <td> Profit </td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + stocksymbol + '\')\"> View </div> </td> <td> <div class=\"redh buttonStyle small\" onclick=\"createChartSingle(\'SM_' + lc + '\')\"> Delete </div> </td> </tr>');
	}
	
	var emptyTableRow = function() {
		$('#stocksTable tr:last').after('<tr> <td colspan=8>'+ '<form id=\"new_stock_form\" action=\"\" method=\"get\"> \n <label for="new_stock_symbol">Symbol:</label> <input type="text" style="width:90px;" name="new_stock_symbol" id="new_stock_symbol" /> \n <label for="new_stock_amount">Amount to Invest:</label> <input type="text" style="width:90px;" name="new_stock_amount" id="new_stock_amount" /> \n <label for="curr_amount">Last Value:</label> <input type="text" style="width:90px;" name="curr_amount" id="curr_amount" readonly=\"readonly\" /> </form>' +'<td> <div class=\"blue buttonStyle small\" onclick=\"viewNewSymbol()\"> View </div> </td> <td> <div class=\"greenh buttonStyle small\" onclick=\"addStockToUser()\"> Add </div> </td> </tr>');
	}

	var viewNewSymbol = function() {
		symbol = document.getElementById("new_stock_symbol").value.toUpperCase();
		document.getElementById("container-stock").innerHTML="<img style=\"margin-top:200px;\" src=\"images/loading.gif\"></img>";
		addStockInformation(symbol,createChartSingle);
	}

	var addStockToUser = function() {
		symbol = document.getElementById("new_stock_symbol").value.toUpperCase();
		amount = document.getElementById("new_stock_amount").value;
		if (amount!="" && !isNaN(amount) && symbol!="" &&(typeof symbol == "string"))
		{
			document.getElementById("container-stock").innerHTML="<img style=\"margin-top:200px;\" src=\"images/loading.gif\"></img>";
			$.post('stockVerifier.php',{symbol : symbol , amount : amount}, function(res) {
				if (res == "yes")
				{
					addStockInformation(symbol, function () {
						document.getElementById("error_msg").innerHTML = "";
						$('#stocksTable tr:last').before('<tr> <td>'+ symbol +'</td> <td>' + stockData[symbol][0] + '</td> <td> amount </td> <td> sdate </td> <td> svalue</td> <td>' + stockData[symbol][1] + '</td> <td> Change </td> <td> Profit </td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + symbol + '\')\"> View </div> </td> <td> <div class=\"redh buttonStyle small\"> Delete </div> </td> </tr>');
						document.getElementById("container-stock").innerHTML="";
						document.getElementById("new_stock_symbol").value = "";
						document.getElementById("new_stock_amount").value = "";
					});
				}
				else
				{
					document.getElementById("error_msg").innerHTML = "Error, Temporarily can't add the stock. Please try again later.";
					document.getElementById("container-stock").innerHTML="";
				}
			});
		}
		else {
			document.getElementById("container-stock").innerHTML="";
			document.getElementById("error_msg").innerHTML = "Error, Wrong input!";
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
							document.getElementById("error_msg").innerHTML = "";
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
								f(symbol);
								document.getElementById("curr_amount").value = stockData[symbol][1];
							}
						}
						else {
							document.getElementById("error_msg").innerHTML = "Stock does not exist! Please try again!";
						}			
					});
				}
				else {
					document.getElementById("error_msg").innerHTML = "Stock does not exist! Please try again!";
				}
			});
		}
		else {
			f(symbol);
		}
	}
	
	// create chart of single stock
	var createChartSingle = function(symbol) {
		document.getElementById("error_msg").innerHTML = "";
		singlechart = new Highcharts.StockChart({
			chart : {
				renderTo : 'container-stock'
			},
			rangeSelector : {
				selected : 1
			},
			title : {
				text : symbol + ' Stock Price'
			},
			xAxis : {
				maxZoom : 14 * 24 * 3600000 // fourteen days
			},
		    credits: {
		        enabled: false
		    },
			series : [{
				name : symbol,
				data : stockData[symbol][2],
				tooltip: {
					yDecimals: 2
				}
			}]
		});
	}


// onload
	$(function() {
		var yAxisOptions = [],
			colors = Highcharts.getOptions().colors,
			counter = 0;
	
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
							data[k-1] = [tdate.getTime(),parseFloat(value[4])];
						}
					});
					data.reverse();
					stockData[name][2] = data;
					createTableRow(name);
					counter++;
					if (counter == names.length)
					{
						emptyTableRow();
						document.getElementById("container-stock").innerHTML="";
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
		           Content Head
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
		          			<th></th>
		          		</tr>
		        	</table>		                   
		        </div>
		        <div id="error_msg" class="error" style="text-align:center;"></div>       
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
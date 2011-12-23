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
	var stockData = {};
	var chart = null;
	var counter = 0;
	var createTableRow = function(id) {
		symbol = userStockInfo[id][1];
		name = stockData[symbol][0];
		amount_inv = (parseFloat(userStockInfo[id][2])).toFixed(2);
		sdate = userStockInfo[id][3];
		svalue = parseFloat(userStockInfo[id][4]).toFixed(2);
		lvalue = (stockData[symbol][1]).toFixed(2);
		change = (((lvalue-svalue)*100)/svalue).toFixed(2);
		profit = (change*amount_inv/100).toFixed(2);
		$('#stocksTable tr:last').after('<tr id=SM_' + id +'> <td>'+ symbol +'</td> <td>' + name + '</td> <td>' + amount_inv + '</td> <td>' + sdate + '</td> <td>' + svalue + '</td> <td>' + lvalue + '</td> <td>' +  change   + '% </td> <td>' + profit + '</td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + symbol + '\')\"> View </div> </td> <td> <div class=\"redh buttonStyle small\" onclick=\"delStockFromUser('+ id +')\"> Delete </div> </td> </tr>');
	}
	
	var emptyTableRow = function() {
		$('#stocksTable tr:last').after('<tr> <td colspan=8>'+ '<form id=\"new_stock_form\" action=\"\" method=\"get\"> \n <label for="new_stock_symbol">Symbol:</label> <input type="text" style="width:90px;" name="new_stock_symbol" id="new_stock_symbol" /> \n <label for="new_stock_amount">Amount to Invest:</label> <input type="text" style="width:90px;" name="new_stock_amount" id="new_stock_amount" /> \n <label for="curr_amount">Last Value:</label> <input type="text" style="width:90px;" name="curr_amount" id="curr_amount" readonly=\"readonly\" /> </form>' +'<td> <div class=\"blue buttonStyle small\" onclick=\"viewNewSymbol()\"> View </div> </td> <td> <div class=\"greenh buttonStyle small\" onclick=\"addStockToUser()\"> Add </div> </td> </tr>');
	}

	var viewNewSymbol = function() {
		symbol = document.getElementById("new_stock_symbol").value.toUpperCase();
		document.getElementById("container-stock").innerHTML="<img style=\"margin-top:200px;\" src=\"images/loading.gif\"></img>";
		addStockInformation(symbol, function () {
					createChartSingle(symbol);
					document.getElementById("curr_amount").value = stockData[symbol][1];
		});
	}

	var addStockToUser = function() {
		symbol = document.getElementById("new_stock_symbol").value.toUpperCase();
		amount = document.getElementById("new_stock_amount").value;
		if (amount!="" && !isNaN(amount) && symbol!="" &&(typeof symbol == "string"))
		{
			document.getElementById("container-stock").innerHTML="<img style=\"margin-top:200px;\" src=\"images/loading.gif\"></img>";
			$.post('stockVerifier.php',{symbol : symbol , amount : amount , action : "add"}, function(res) {
				if (res != "no")
				{
					addStockInformation(symbol, function () {
						document.getElementById("error_msg").innerHTML = "";
						var currentTime = new Date();
						var month = currentTime.getMonth() + 1;
						var day = currentTime.getDate();
						var year = currentTime.getFullYear();
						$('#stocksTable tr:last').before('<tr id=SM_'+ res + '> <td>'+ symbol +'</td> <td>' + stockData[symbol][0] + '</td> <td>' + amount + '</td> <td>' + year + '-' + month + '-' + day + '</td> <td>' + stockData[symbol][1] + '</td> <td>' + stockData[symbol][1] + '</td> <td> 0.00% </td> <td> 0.00 </td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + symbol + '\')\"> View </div> </td> <td> <div class=\"redh buttonStyle small\" onclick=\"delStockFromUser('+ res +')\"> Delete </div> </td> </tr>');
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

	var delStockFromUser = function(id) {
		if (!isNaN(id))
		{
			document.getElementById("container-stock").innerHTML="<img style=\"margin-top:200px;\" src=\"images/loading.gif\"></img>";
			$.post('stockVerifier.php',{id : id , action : "del"}, function(res) {
				if (res == "yes")
				{
					$('#SM_' + id).remove();
					document.getElementById("error_msg").innerHTML = "";
					document.getElementById("container-stock").innerHTML="";
				}
				else
				{
					document.getElementById("error_msg").innerHTML = "Error, Temporarily can't delete the stock. Please try again later.";
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
							}
						}
						else {
							document.getElementById("error_msg").innerHTML = "Stock does not exist! Please try again!";
							document.getElementById("container-stock").innerHTML="";
						}			
					});
				}
				else {
					document.getElementById("error_msg").innerHTML = "Stock does not exist! Please try again!";
					document.getElementById("container-stock").innerHTML="";
				}
			});
		}
		else {
			if (typeof f == "function") 
			{
				f(symbol);
			}
		}
	}
	
	// create chart of single stock
	var createChartSingle = function(symbol) {
		document.getElementById("error_msg").innerHTML = "";
		document.getElementById("curr_amount").value = "";
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
				emptyTableRow();
				document.getElementById("container-stock").innerHTML="";
				document.getElementById("error_msg").innerHTML = "";
			}
	    }
	    else{
	        setTimeout(function(){
	            waitForElement(i,symbol);
	        },250);
	    }
	}
	
// onload
	$(function() {
		var yAxisOptions = [],
			colors = Highcharts.getOptions().colors,
			datacount = 0;
		var length = getAssocArrayLength(userStockInfo);
		if(length != 0)
		{
			$.each(userStockInfo, function(i, stock) {
				symbol = stock[1];
				addStockInformation(symbol);
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
			document.getElementById("error_msg").innerHTML = "";
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
		           Content Head
			</div>
			<div id="content-middle">
				<div id="userStock">
		          	<table class="stocksTablesStyle" id="stocksTable">
		          		<tr style="background-color:#0099ff; display: table-row;">
		          			<th>Symbol</th>
		          			<th>Name</th>
		          			<th>Amount Invested</th>
		          			<th style="width:85px;">Start Date</th>
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
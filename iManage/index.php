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
	$per = intval($_SESSION['permissionid']);
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
			while ($connection->more_results() && $connection->next_result()) {
				//free each result.
				$result = $connection->use_result();
				if ($result instanceof mysqli_result) {
					$result->free();
				}
			}
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
	<script type="text/javascript" src="jquery.csv.min.js"></script>
	<script type="text/javascript" src="JQueryUI/jquery-ui-1.8.16.custom.min.js"> </script>
	<link rel="stylesheet" href="JQueryUI/jquery-ui-1.8.16.custom.css" type="text/css"/>
	
	<style type="text/css">
		.ui-widget {
			font-size: 0.75em;
		}	
	</style>
	<script type="text/javascript">
<?php 
if($loggedin && ($per == 2 || $per==3))
{
	if (!empty($userStockInformation)) {
		echo "var userStockInfo = " . json_encode((object)$userStockInformation) . ";";
	}
	else {
		echo "var userStockInfo = {};";
	}
?>

	var stockData = {};

	var addStockInformation = function (symbol, f) {
		$.ajaxSetup({
  error: function(xhr, status, error) {
    alert('An AJAX error occured: ' + status + '\nError:'+ error);  }
});
	if (typeof stockData[symbol]=='undefined')
	{
		stockData[symbol] = [];
		$.get('geturl.php',{url:'http://download.finance.yahoo.com/d/quotes.csv?s=' + symbol +'&f=snp'}, function(data) {
			dataArray = jQuery.csv()(data);
			if (typeof(dataArray[0][2]) != 'undefined' && !isNaN(dataArray[0][2]))
			{
				stockData[symbol][0] = dataArray[0][1];
				stockData[symbol][1] = parseFloat(dataArray[0][2]);
				f(symbol,'new');
			}
			else {
				stockData[symbol] = null;
			}
		});
	}
	else {
		if (typeof f == 'function') 
		{
			f(symbol,'exist');
		}
	}
}
	<?php 
	echo "
	var getAssocArrayLength = function (tempArray) 
	{
		var result = 0;
		for ( tempValue in tempArray ) {
			result++;
		}	
		return result;
	}

	var waitForElement = function (i,symbol){
	    if(typeof (stockData[symbol][1]) != 'undefined'){
	    	createTableRow(i);
	    }
	    else{
	        setTimeout(function(){
	            waitForElement(i,symbol);
	        },250);
	    }
	}

	var createTableRow = function(id) {
		symbol = userStockInfo[id][1];
		name = stockData[symbol][0];
		amount_inv = (parseFloat(userStockInfo[id][2])).toFixed(2);
		sdate = userStockInfo[id][3];
		svalue = parseFloat(userStockInfo[id][4]).toFixed(2);
		lvalue = (stockData[symbol][1]).toFixed(2);
		change = (((lvalue-svalue)*100)/svalue).toFixed(2);
		profit = (change*amount_inv/100).toFixed(2);
		$('#I_stocksTable tr:last').after('<tr> <td>'+ symbol +'</td> <td>' + name + '</td> <td>' + amount_inv + '</td> <td>' + sdate + '</td> <td>' + svalue + '</td> <td>' + lvalue + '</td> <td>' +  change   + '% </td> <td>' + profit + '</td> <td> <div class=\"blue buttonStyle small\" onclick=\"createChartSingle(\'' + symbol + '\')\"> View </div> </td> </tr>');
	}";
}
?>
	
	$(function() {
		$( '#tabs' ).tabs();
<?php 
if($loggedin && ($per == 2 || $per==3))
{
	echo "var length = getAssocArrayLength(userStockInfo);
		var datacount = 0;
		if(length != 0)
		{
			$.each(userStockInfo, function(i, stock) {
				symbol = stock[1];
				addStockInformation(symbol,function (symbol , isexist) { 
					datacount++;
				});
			});
			if(datacount == length)
			{
				$.each(userStockInfo, function(i, stock) {
					symbol = stock[1];
					waitForElement(i,symbol);
				});	
			}
		}";
}
?>	
	});
	</script>
	                      
	<link rel="stylesheet" type="text/css" href="engine1/style.css"/>
	<style type="text/css">a#vlb{display:none}</style>
	<script type="text/javascript" src="engine1/wowslider.js"></script>
	                      
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
			
			
<?php 		if($loggedin)
			{
		         echo " <div id='tabs'>
		           		<ul>
							<li><a href='#tabs-1'>Overview</a></li>
							<li><a href='#tabs-2'>Incomes</a></li>
							<li><a href='#tabs-3'>Payouts</a></li>
							<li><a href='#tabs-4'>Investments</a></li>
						</ul>
						<div id='tabs-1'>
                             <p>pppp</p>
						</div>
						<div id='tabs-2' style='margin: 0px auto 0px auto; text-align:center; width:100%;'>";
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
				             
						echo "</div>
						<div id='tabs-3' style='margin: 0px auto 0px auto; text-align:center; width:100%;'>";
							
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
						
						echo " </div>
						<div id='tabs-4'>

							<div id='userStock'>
					          	<table class='stocksTablesStyle' id='I_stocksTable'>
					          		<tr style='background-color:#0099ff; display: table-row;'>
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
						</div>
		           </div> ";
		           
		}       
		else
		{
			echo "		<div id='wowslider-container1'>
						    <div class='ws_images'>
								<span><img src='data1/images/image1.jpg' alt='image1' title='image1' id='wows0'/></span>
								<span><img src='data1/images/image2.jpg' alt='image2' title='image2' id='wows1'/></span>
								<span><img src='data1/images/image3.jpg' alt='image3' title='image3' id='wows2'/></span>
								<span><img src='data1/images/image4.jpg' alt='image4' title='image4' id='wows3'/></span>
								<span><img src='data1/images/image5.jpg' alt='image5' title='image5' id='wows4'/></span>
							</div>
							<div class='ws_bullets'>
							    <div>
									<a href='#wows0' title='image1'><img src='data1/tooltips/image1.jpg' alt='image1'/>1</a>
									<a href='#wows1' title='image2'><img src='data1/tooltips/image2.jpg' alt='image2'/>2</a>
									<a href='#wows2' title='image3'><img src='data1/tooltips/image3.jpg' alt='image3'/>3</a>
									<a href='#wows3' title='image4'><img src='data1/tooltips/image4.jpg' alt='image4'/>4</a>
									<a href='#wows4' title='image5'><img src='data1/tooltips/image5.jpg' alt='image5'/>5</a>
							   </div>
					        </div>		
						<div class='ws_shadow'></div>
					</div>
						<script type='text/javascript' src='engine1/script.js'></script>";
		}
?>          
		           
		           
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->

</body>
</html>
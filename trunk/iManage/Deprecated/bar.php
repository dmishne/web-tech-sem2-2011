<?php 
include_once('YahooStock.php');
?>

<div id="barArea">
    <div style="vertical-align:middle;">
    DEMO --
 	<?php 
	/*	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
			echo "Hello Guest";
		}	
		else{
			echo "Hello ".  $_SESSION['firstname'];
		}							   
	*/   
 	
 	$objYahooStock = new YahooStock;
 	
 	/**
 	 Add format/parameters to be fetched
 	
 	 s = Symbol
 	 n = Name
 	 l1 = Last Trade (Price Only)
 	 d1 = Last Trade Date
 	 t1 = Last Trade Time
 	 c = Change and Percent Change
 	 v = Volume
 	 */
 	$objYahooStock->addFormat("snl1d1t1cv");
 	
 	/**
 	 Add company stock code to be fetched
 	
 	 msft = Microsoft
 	 amzn = Amazon
 	 yhoo = Yahoo
 	 goog = Google
 	 aapl = Apple
 	 */
 	$objYahooStock->addStock("msft");
 	$objYahooStock->addStock("amzn");
 	$objYahooStock->addStock("yhoo");
 	$objYahooStock->addStock("goog");
 	$objYahooStock->addStock("vgz");
 	
 	/**
 	 * Printing out the data
 	 */
 	foreach( $objYahooStock->getQuotes() as $code => $stock)
 	{
 		?>
 		<div class="stockBarInfo blue">
 	    <?php echo $stock[0]; ?> - 	 
 	    <?php echo $stock[2]; ?>
 	    </div>  	  
 	    <?php
 	}
 	
 	
 	?>
 	-- DEMO 
	</div>
</div>




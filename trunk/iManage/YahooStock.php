<?php
class YahooStockPage
{
	private $mStocks = null;
	private $mStocksData = null;
	
	public function __construct($stocks) {
		if (!is_array($stocks)){
			throw new Exception("Constructor didn't recieved ARRAY of names of stocks");
		}
		$this->mStocks = $stocks;
	}
	
	public function showStockPage()
	{
		if ($this->mStocks == null)
		{
			echo "<p>You don't have any stocks registered<\p>
			      </br>
			      <a href=\"stockManage.php\"> click here to register for stocks </a>";
			return;
		}
		$this->loadStockData();
		foreach ($this->mStocksData as &$stockData) 
		{
			unset($stockData[0]);					// Remove Header
			$stockData = array_values($stockData);
			$n = count($stockData);
			for ($i = 0; $i < $n; $i++)
			{
				$stockData[$i][0] = strtotime($stockData[$i][0])*1000; 		//  Unix timestamp with microseconds
				$stockData[$i] = array( 0 => $stockData[$i][0] , 1 => floatval($stockData[$i][4]));
			}
			$stockData = array_reverse($stockData);
		}
		$this->dataToJavaScript();
	}
	
	private function dataToJavaScript()
	{
		echo "<script type=\"text/javascript\">\n";
		echo "var data = [] , \n
				  names = [] ,
			      seriesOptions = [];\n";
		$i = 0;
		foreach ($this->mStocksData as &$stockData){
			$tname = $this->mStocks[$i];
			echo "data[$i] =" . json_encode($stockData) . ";\n";
			echo "names[$i] = '$tname';\n";
			echo "seriesOptions[$i] = { name : names[$i] ,\n data : data[$i]};\n";
			$i++;
		}
		echo "createChart();\n";
		echo "</script>";
	}
	
	private function loadStockData()
	{
		foreach($this->mStocks as &$stock)
		{
			$tempCsvString = file_get_contents("http://ichart.yahoo.com/table.csv?s=" . $stock . "&a=0&b=1&c=20011&g=d&ignore=.csv");
			$this->mStocksData[$stock] = $this->csvToArray($tempCsvString);
		}
	}
	
	private function csvToArray($csvString)
	{
		$csv_data = str_getcsv($csvString, "\n"); // split to csv rows
		foreach ($csv_data as &$row)
		{
			$row = str_getcsv($row);
		}
		return $csv_data;
	}
	
	
}

?>

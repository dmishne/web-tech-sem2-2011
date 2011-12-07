function getDataForChart()
{	
	var myarray;
	jQuery.get('http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0&e=31&f=2010&g=w&ignore=.csv', function(data) { myarray = jQuery.csv()(data); });
	return myarray;
}
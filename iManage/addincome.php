<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<?
  // PREDEFINED DATA
  // get GPC data:
  if(isset($_REQUEST['date'])) $date = $_REQUEST['date'];
  if(isset($_REQUEST['year'])) $year = $_REQUEST['year'];
  if(isset($_REQUEST['month'])) $month = $_REQUEST['month'];
  if(isset($_REQUEST['offset'])) $offset = $_REQUEST['offset'];
  
  // set PHP_SELF:
  if(isset($_SERVER['PHP_SELF'])) $PHP_SELF = $_SERVER['PHP_SELF'];
?>


<html>

<head>
	<title> iManage </title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<link rel="icon" href="images/logo.ico" />
	<link rel="apple-touch-icon" href="images/icon_apple.png" />
	<?php include "include.php" ?>
	
	<?php
	echo "<script type=\"text/javascript\">
		  $.mon_year = {};";
	if(isset($_REQUEST['year']) && isset($_REQUEST['month']))
	{
		echo "$.mon_year.year = {$_REQUEST[year]} ;" . "
		   	  $.mon_year.month =  {$_REQUEST[month]} ;";
	}
	else
	{
		echo "$.mon_year.year = " . date("Y") . ";
			  $.mon_year.month = " . date("m") . ";
		";
	}
	echo "</script>";
	?>
	
	<script type="text/javascript"> 
         $(document).ready(function(){
           slidetgl();
           initCalendar();
       });
	</script>
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php" ?>
	</div>
	
	<div id="middle">
		<div id="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		           Add Incomes
			</div>
			<div id="contentaddincome">	
			
			
			         
		         <div id="incomechoser" >
		           <!---------------------------------------------------------------> 
		           <!--------------------------------------------------------------->   
		           <?php  if(isset($date))
							                     list($curDay, $curMonth, $curYear)= explode('.', $date,3);
							                else
							                     list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3); ?>     
		             <p class="flip"  style="text-align:center;"> One Time Income</p>
					 <button class="green rounded" id="frst"><img id="1a" src="images/arrows_down.png" /></button>					 
		             <div class="panel1">
		             <form method="post" action="" id="panel1_form">
					    <table width="100%">
					        <td width="63%">
					          <table>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Amount: </td>
							         <td width="55%"><input type="text" class="inpt" style="color:green" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Income Date (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></thead>
							         <tbody><td><textarea rows="8" cols="28" class="inpt"></textarea></td></tbody>
							         <tfoot><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tfoot>
						         </table> 
						     </td>  
					    </table>
					    </form>
					 </div>	
					 <p class="line1"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->					 						 
					 <p class="flip"  style="text-align:center;"> Recurring Income</p>
					 <button class="green rounded" id="scnd"><img id="2a" src="images/arrows_down.png" /></button>	
					 <div class="panel2">
						<form method="post" action="" id="panel2_form">	
                          <table width="100%">
					        <td width="63%">
					          <table>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Amount: </td>
							         <td width="55%"><input type="text" class="inpt" style="color:green" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="50%" class="pfont">From (dd/mm/yyyy): </td>
							         <td width="50%"><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							       <tr>
							          <td width="50%" class="pfont">Recurring Period: </td>
							          <td width="50%">
							             <select name="r_period" class="inpt" style="width:136px">
											<option value="daily">Daily</option>
											<option value="weekly">Weekly</option>
											<option value="2weeks">Fortnightly</option>
											<option value="monthly">Monthly</option>
										 </select>
							          </td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></thead>
							         <tbody><td><textarea rows="8" cols="28" class="inpt"></textarea></td></tbody>
							         <tfoot><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tfoot>
						         </table> 
						     </td>  
					    </table>
                       </form>
					 </div>
					 <p class="line2"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->							 
					 <p class="flip"  style="text-align:center;"> Recurring Generated Income</p>
				     <button class="green rounded" id="thrd"><img  id="3a" src="images/arrows_down.png" /></button>		
					 <div class="panel3">
						<form method="post" action="" id="panel3_form">	
							<table width="100%">
					        <td width="63%">
					          <table>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Hours per Day (hh:mm): </td>
							         <td width="55%"><input type="text" class="inpt" size="6" maxlength="2" id="rhpd" value="0" onchange="rDayWageTotal()"/>
							                 <b>:</b><input type="text" class="inpt" size="6" maxlength="2" id="rmpd" value="0" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Wage per Hour: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30" id="rwpd" value="0" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Total per Day: </td>
							         <td width="55%"><input type="text" class="inpt" style="color:green" size="20" maxlength="30" readonly="readonly" id="rwt"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">From (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							       <tr>
							          <td width="50%" class="pfont">Recurring Period: </td>
							          <td width="50%">
							             <select name="r_period" class="inpt" style="width:136px">
											<option value="daily">Daily</option>
											<option value="weekly">Weekly</option>
											<option value="2weeks">Fortnightly</option>
											<option value="monthly">Monthly</option>
										 </select>
							          </td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></thead>
							         <tbody><td><textarea rows="8" cols="28" class="inpt"></textarea></td></tbody>
							         <tfoot><td align="right"><input type="submit" value="Update" class="blue button small bround" ></input></td></tfoot>
						         </table> 
						     </td>  
					    </table>
						</form>	
					 </div>		
					 <p class="line3"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->					 
					 <p class="flip"  style="text-align:center;"> One Time Generated Income</p>	 
					 <button class="green rounded" id="frth"><img id="4a" src="images/arrows_down.png" /></button>
					 <div class="panel4">
						  <form method="post" action="" id="panel4_form">	
							<table width="100%">
					        <td width="63%">
					          <table>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Hours per Day (hh:mm): </td>
							         <td width="55%"><input type="text" class="inpt" size="6" maxlength="2" id="ohpd" value="0" onchange="oDayWageTotal()"/>
							                 <b>:</b><input type="text" class="inpt" size="6" maxlength="2" id="ompd" value="0" onchange="oDayWageTotal()"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Wage per Hour: </td>
							         <td width="55%"><input type="text" class="inpt" size="20" maxlength="30" id="owpd" value="0" onchange="oDayWageTotal()"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Total per Day: </td>
							         <td width="55%"><input type="text" class="inpt" style="color:green" size="20" maxlength="30" readonly="readonly" id="owt"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Income Date (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></thead>
							         <tbody><td><textarea rows="8" cols="28" class="inpt"></textarea></td></tbody>
							         <tfoot><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tfoot>
						         </table> 
						     </td>  
					    </table>
					   </form>	
					 </div>		
					 <p class="line4"></p>					 
												
		         </div>
		         
		         
		         
		         
		         <div id="calendar">
		              <!-- Form POST for calendar.php -->
		              <form action="<? echo $PHP_SELF; ?>" method="get">
							<?php
							  // if year is empty, set year to current year:
							  if($year == '') $year = date('Y');
							  // if month is empty, set month to current month:
							  if($month == '') $month = date('n');
							
							  // if offset is empty, set offset to 1 (start with Sunday):
							  if($offset == '') $offset = 1;
							?>
					 </form>
							
					<!--  Calendar declaration & creation  -->		
					 <?
					  // include calendar class:
					  include('calendar.php');
					
					  // create calendar:
					  $cal = new CALENDAR($year, $month);
					  //$cal->offset = $offset;
					  $cal->link = $PHP_SELF;
					  echo $cal->create();							  
					 ?>		             
		         </div>
		         <div id="daysum">
		            <?php  // if a day is clicked, view that date:
							  if(isset($date))
							     echo $date;
							  ?>
		         </div>
		         <div id="monthsum">
		             <?php // current month
		                  $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
						  if(isset($month) && isset($year)) echo  $months[$month-1] . ' ' . $year ;
						  ?>
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
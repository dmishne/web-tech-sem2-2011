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
	
	
	
	<script type="text/javascript"> 
         $(document).ready(function(){
           slidetgl();
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
		             <p class="flip"  style="text-align:center;"> One Time Income</p>
					 <button class="green rounded" id="frst"><img id="1a" src="images/arrows_down.png" /></button>					 
		             <div class="panel1">
							<table>
							   <tr>
							     <td width="40%" align="center"> ADD:<input name="oti" type="text" id="oti"  maxlength="20" />$</div></td>
							     <td  width="60%" align="center">day    month      year</td>
							   </tr>
							   <tr>
							     <td width="40%" align="center"> blah </td>
							        <td width="60%" align="center">  
							            <form action="">
										<select name="day">
										<option value="1">13</option>
										<option value="2">14</option>
										<option value="3" selected="selected">15</option>
										<option value="4">16</option>
										</select>
										<select name="month">
										<option value="1">7</option>
										<option value="2">8</option>
										<option value="3" selected="selected">9</option>
										<option value="4">10</option>
										</select>
										<select name="year">
										<option value="1">2009</option>
										<option value="2">2010</option>
										<option value="3" selected="selected">2011</option>
										<option value="4">2012</option>
										</select>
										</form>
								   </td>
							   </tr>
							</table>
					 </div>	
					 <p class="line1"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->					 						 
					 <p class="flip"  style="text-align:center;"> Recurring Income</p>
					 <button class="green rounded" id="scnd"><img id="2a" src="images/arrows_down.png" /></button>	
					 <div class="panel2">
							Because time is valuable, we deliver quick and easy learning.
					 </div>
					 <p class="line2"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->							 
					 <p class="flip"  style="text-align:center;"> Recurring Generated Income</p>
				     <button class="green rounded" id="thrd"><img  id="3a" src="images/arrows_down.png" /></button>		
					 <div class="panel3">
							Because time is valuable, we deliver quick and easy learning.
					 </div>		
					 <p class="line3"></p>
					 <!---------------------------------------------------------------> 
		             <!--------------------------------------------------------------->					 
					 <p class="flip"  style="text-align:center;"> One Time Generated Income</p>	 
					 <button class="green rounded" id="frth"><img id="4a" src="images/arrows_down.png" /></button>
					 <div class="panel4">
							Because time is valuable, we deliver quick and easy learning.
					 </div>		
					 <p class="line4"></p>					 
												
		         </div>
		         
		         
		         
		         
		         <div id="calendar">
		              <!-- Form POST for calendar.php -->
		              <form action="<? echo $PHP_SELF; ?>" method="post">
							<?
							  // if year is empty, set year to current year:
							  if($year == '') $year = date('Y');
							  // if month is empty, set month to current month:
							  if($month == '') $month = date('n');
							
							  // if offset is empty, set offset to 1 (start with Sunday):
							  if($offset == '') $offset = 1;
							?>
							   <!-- input year value: --> 
							<input type="text" id="cal" name="year"  size="4" maxlength="4" value="<? echo $year; ?>">
			
							<select  name="month" onchange="this.form.submit();" style="position:relative; left:25px;">
							<?
							  // build selection (months):
							  $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
							  for($i = 1; $i <= 12; $i++) {
							    echo '<option value="' . $i . '"';
							    if($i == $month) echo ' selected';
							    echo '>' . $months[$i-1] . "</option>\n";
							  }
							?>
							</select>
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
						  if(isset($month)) echo  $months[$month-1] ;
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
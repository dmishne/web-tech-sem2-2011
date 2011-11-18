<?php session_start();
/*  if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}*/
  // PREDEFINED DATA
  // get GPC data:
  if(isset($_REQUEST['date'])) $date = $_REQUEST['date'];
  if(isset($_REQUEST['year'])) $year = $_REQUEST['year'];
  if(isset($_REQUEST['month'])) $month = $_REQUEST['month'];
  if(isset($_REQUEST['offset'])) $offset = $_REQUEST['offset'];
  
  // set PHP_SELF:
  if(isset($_SERVER['PHP_SELF'])) $PHP_SELF = $_SERVER['PHP_SELF'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> iManage </title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
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
	
	<?php  if(isset($date))
				list($curDay, $curMonth, $curYear)= explode('.', $date,3);
				else
				list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3);
	?>
	
	<?php 
			$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			 
			$connection->select_db('webtech');
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$res = $connection->query("CALL GetDailyOneTimeIncomes('$username','$date2')") or die(mysqli_error());
	?>
	
    <?php 
			$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			 
			$connection->select_db('webtech');
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$res2 = $connection->query("CALL getDailyRecurringIncomes('$username','$date2')") or die(mysqli_error());
	?>	
	
	<?php 
			$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			
			$connection->select_db('webtech');
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$daySum = $connection->query("CALL getDailyTransactions('$username','$date2')") or die(mysqli_error());
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
		<div class="menu" style="min-height:450px">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		           Add Incomes
			</div>
			<div id="contentaddincome">	
			
			
			         
		         <div class="incomechoser" >

		           <!--															--> 
		           <!--															-->   

		           
	            	<?php 
			             if((isset($_SESSION['transfer'])))
			             {
			             	$usrinpt = $_SESSION['transfer'];
			             	echo "<div class=\"error\"> Input error! Please check values </div>";
			             }
		             ?>	
		            
		             <p class="flip"  style="text-align:center;"> Update working hours</p>
				     <button class="green rounded" id="frst"><img  id="1a" src="<?php  if(isset($usrinpt['err1']) && $usrinpt['err1'] == 1) echo "images/arrows_up.png"; else echo "images/arrows_down.png";?>" /></button>		
					 <div class="panel1" style="<?php if(isset($usrinpt['err1']) && $usrinpt['err1'] == 1) echo "display:block;"; ?>">
						<form method="post" action="addincomeTransaction.php" id="panel1_form">	
						   <table width="100%">
							 <tr>
					          <td width="97%">
					            <input type="hidden" name="panel" value="1" />
					            <table>
					               <tr>
					                  <td width="45%" class="pfont">Work date:</td>
					                  <td width="55%" class="pfont"><?php echo $curDay.'/'.$curMonth.'/'.$curYear ?></td>
					               </tr>
						           <tr>
						             <td width="50%" class="pfont">Work:</td>
						             <td width="50%">
						                 <select name="workname" class="inpt" style="width:131px">
						                   <option>bla bla</option>
						                   <option>bla bla bla</option>
						                   <option>lalala</option>
						                 </select>
						              </td> 
						           </tr>
							       <tr>
							         <td width="45%" class="pfont">Start Hour(hh:mm): </td>
							         <td width="55%"><input type="text" name="starth" class="inpt" size="6" maxlength="2" id="rsh" onchange="rDayWageTotal()"/>
							                 <b>:</b><input type="text" name="startm" class="inpt" size="6" maxlength="2" id="rsm" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['time1']) && $usrinpt['time1'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Incorect time </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">End Hour(hh:mm): </td>
							         <td width="55%"><input type="text" name="endh" class="inpt" size="6" maxlength="2" id="reh" onchange="rDayWageTotal()"/>
							                 <b>:</b><input type="text" name="endm" class="inpt" size="6" maxlength="2" id="rem" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['time2']) && $usrinpt['time2'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Incorect time </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Wage per Hour: </td>
							         <td width="55%"><input type="text" name="wage" class="inpt" size="20" maxlength="30" id="rwpd"  onkeyup="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['amount']) && $usrinpt['amount'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Value must be numeric </div> </td> </tr>";}
		            			         else if(isset($usrinpt['sign']) && $usrinpt['sign'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be positive </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Total per Day: </td>
							         <td width="55%"><input type="text" class="inpt" style="color:green" size="20" maxlength="30" readonly="readonly" id="rwt"/></td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%" style="position:relative; vertical-align:bottom">
						         <table>
							         <tr><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tr>
						         </table> 
						     </td> 
						   </tr> 
					    </table>
						</form>	
					 </div>		
					 <p class="line1" style="<?php  if(isset($usrinpt['err1']) && $usrinpt['err1'] == 1) echo "visibility:hidden;"; ?>"></p>            

					 <!--															--> 
		           	 <!--															-->					 						 

					 <p class="flip"  style="text-align:center;"> Recurring Income</p>
					 <button class="green rounded" id="scnd"><img id="2a" src="<?php  if(isset($usrinpt['err2']) && $usrinpt['err2'] == 1) echo "images/arrows_up.png"; else echo "images/arrows_down.png";?>" /></button>	
					 <div class="panel2" style="<?php if(isset($usrinpt['err2']) && $usrinpt['err2'] == 1) echo "display:block;"; ?>">
						<form method="post" action="addincomeTransaction.php" id="panel2_form">	
                          <table width="100%">
                            <tr>
					          <td width="63%">
					          <input type="hidden" name="panel" value="2" />
					            <table>
					               <tr>
						             <td width="50%" class="pfont">Update added income:</td>
						             <td width="50%">
						                 <select name="rtIncome" id="rtinc" class="inpt" style="width:131px">
						                   <option value="New" onclick="updtWorkinfo('otislct','','','')">New</option>
						                   <?php   
						                         while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
						                         	$name = $row2["recname"];
						                         	$amount = $row2["amount"]; 
						                        	$desc = $row2["description"];
						                        	$recType = $row2["recType"];
						                        	$jobId =$row2["recId"];
						                         	echo "<option value=\"$jobId\" onclick=\"updtWorkinfo('rtinc','$name','$amount','$desc','$recType')\">";
						                         	echo $name;
						                         	echo "</option>";
						                         }
						                   ?>
						                 </select>
						              </td> 
						           </tr>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" id="name2" name="inname" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Amount: </td>
							         <td width="55%"><input type="text" name="amount" id="amount2" class="inpt" style="color:green" size="20" maxlength="30"/></td>
							       </tr>
							       <?php if(isset($usrinpt['amount']) && $usrinpt['amount'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be numeric </div> </td> </tr>";}
		            			         else if(isset($usrinpt['sign']) && $usrinpt['sign'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be positive </div> </td> </tr>";}?>
							       <tr>
							         <td width="50%" class="pfont">From (dd/mm/yyyy): </td>
							         <td width="50%"><input type="text" name="day" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" name="month" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" name="year" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							       <?php if(isset($usrinpt['date']) && $usrinpt['date'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Invalid date input </div> </td> </tr>";}?>
							       <tr>
							          <td width="50%" class="pfont">Recurring Period: </td>
							          <td width="50%">
							             <select name="r_period" id="rslct" class="inpt" style="width:131px">
											<option value=10>Daily</option>
											<option value=1>Weekly</option>
											<option value=2>Fortnightly</option>
											<option value=4>Monthly</option>
											<option value=8>Bi-monthly</option>
										 </select>
							          </td>
							       </tr>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><tr><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></tr></thead>
							         <tbody><tr><td><textarea name="desc" id="desc2" rows="8" cols="28" class="inpt"></textarea></td></tr></tbody>
							         <tfoot><tr><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tr></tfoot>
						         </table> 
						     </td> 
						   </tr>   
					    </table>
                       </form>
					 </div>
					  <p class="line2" style="<?php  if(isset($usrinpt['err2']) && $usrinpt['err2'] == 1) echo "visibility:hidden;"; ?>"></p>
					 

					 <!--															--> 
		           	 <!--															-->							 

					 <p class="flip"  style="text-align:center;"> One Time Income</p>
					 <button class="green rounded" id="thrd"><img id="3a" src="<?php  if(isset($usrinpt['err3']) && $usrinpt['err3'] == 1) echo "images/arrows_up.png"; else echo "images/arrows_down.png";?>"/></button>					 
		             <div class="panel3"  style="<?php  if(isset($usrinpt['err3']) && $usrinpt['err3'] == 1) echo "display:block;"; ?>">
		             <form method="post" action="addincomeTransaction.php" id="panel3_form">
					    <table width="100%">
					      <tr>
					        <td width="63%">
					        <input type="hidden" name="panel" value="3" />
					          <table>
					               <tr>
						             <td width="50%" class="pfont">Update added income:</td>
						             <td width="50%">
						                 <select name="rIncome" id="otislct" class="inpt" style="width:131px">
						                 <option value="New" onclick="updtWorkinfo('otislct','','','')">New</option>
						                   <?php   
						                         while ($row = $res->fetch_array(MYSQLI_ASSOC)){
						                         	$name = $row["transname"];
						                         	$amount = $row["amount"]; 
						                        	$desc = $row["description"];
						                        	$jobId =$row["transId"];
						                         	echo "<option value=\"$jobId\" onclick=\"updtWorkinfo('otislct','$name','$amount','$desc')\">";
						                         	echo $name;
						                         	echo "</option>";
						                         }
						                   ?>
						                 </select>
						              </td> 
						           </tr>
							       <tr>
							         <td width="45%" class="pfont">Name: </td>
							         <td width="55%"><input type="text" id="name3" name="inname" class="inpt" size="20" maxlength="30"/></td>
							       </tr>
							       <tr>
							         <td width="45%" class="pfont">Amount: </td>
							         <td width="55%"><input type="text"  name="amount" id="amount3" class="inpt" style="color:green" size="20" maxlength="30"/></td>
							       </tr>
							       <?php if(isset($usrinpt['amount']) && $usrinpt['amount'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be numeric </div> </td> </tr>";}
		            			         else if(isset($usrinpt['sign']) && $usrinpt['sign'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be positive </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Income Date (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" name="day" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" name="month" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" name="year" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							       </tr>
							       <?php if(isset($usrinpt['date']) && $usrinpt['date'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Invalid date input </div> </td> </tr>";}?>
							     </table>  
						     </td>
						     <td width="35%">
						         <table>
							         <thead><tr><td nowrap="nowrap" class="pfont" style="font-size:16px">Income description:</td></tr></thead>
							         <tbody><tr><td><textarea name="desc" id="desc3" rows="8" cols="28" class="inpt"></textarea></td></tr></tbody>
							         <tfoot><tr><td align="right"><input type="submit" value="Update" class="blue button small bround"></input></td></tr></tfoot>
						         </table> 
						     </td>  
						   </tr>  
					    </table>
					    </form>
					 </div>	
					 <p class="line3" style="<?php  if(isset($usrinpt['err3']) && $usrinpt['err3'] == 1) echo "visibility:hidden;"; ?>"></p>

					 <!--															--> 
		             <!--															-->				 

									 
					  <?php unset($_SESSION['transfer']);?>							
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
					  echo $cal->create($date);							  
					 ?>		             
		         </div>
		         <div id="daysum">
		            <?php  // if a day is clicked, view that date:
		                      $total = 0;
							  if(!isset($date)){
							  	 $date = sprintf('%02d.%02d.%4d', $curDay, $curMonth, $curYear);
							     }	
							  if($daySum->num_rows > 0){     
							      echo "<div class=\"daysumhead\">Your balance for: $date</div>";	
							  echo "<div style=\"min-height:60px\"><table>";         
								  while ($row2 = $daySum->fetch_array(MYSQLI_ASSOC)){
								      $transname = $row2['transname'];
								      $amnt = $row2['amount'];
								      $trnstype = $row2['transtype'];
								      $descript = $row2['description'];
								      echo "<tr>";
									  if ($amnt < 0){
									   	   $div1 = "<td class=\"redinc roundedincleft\" style=\"cursor:help\" title=\"$descript\">";
									   	   $div2 = "<td class=\"redinc roundedinccntr\" style=\"cursor:help\" title=\"$descript\">";
									   	   $div3 = "<td class=\"redinc roundedincright\" style=\"cursor:help\" title=\"$descript\">";
									      }
									   else {
									   	   $div1 = "<td  class=\"greeninc roundedincleft\" style=\"cursor:help\" title=\"$descript\">";
									   	   $div2 = "<td  class=\"greeninc roundedinccntr\" style=\"cursor:help\" title=\"$descript\">";
									   	   $div3 = "<td  class=\"greeninc roundedincright\" style=\"cursor:help\" title=\"$descript\">";
									      } 
									   echo "{$div1}$trnstype</td>";
								       echo "{$div2}$transname</td>";
								       echo "{$div3}$amnt$ </td>";  
								       echo "</tr>";					  
								      $total += $amnt;
								    }
								    echo "</table></div>";
								    echo "<div class=\"daysumhead\" style=\"bottom:-22px\">TOTAL: $total$</div>";
							   }
							  else 
							      echo "<div class=\"daysumhead\">You have no transactions for $date</div>"
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
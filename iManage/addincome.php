<?php
	include "beforeLoadCheck.php";
	include "sessionVerifier.php";
	
	include_once "ini.php";
	
	// set date
	if(isset($_REQUEST['date'])) $date = verifyInput($_REQUEST['date']);
	  
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
	<script type="text/javascript" src="JQueryUI/jquery-ui-1.8.16.custom.min.js"> </script>
	<link rel="stylesheet" href="JQueryUI/jquery-ui-1.8.16.custom.css" type="text/css"/>
	<style type="text/css">
	.ui-widget {
		font-size: 0.75em;
	}
	</style>
	
	<?php  if(isset($date))
				list($curDay, $curMonth, $curYear)= explode('.', $date,3);
				else
				list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3);
				$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	?>
	
	<?php 
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			 
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$res = $connection->query("CALL getDailyOneTimeIncomes('$username','$date2')") or die(mysqli_error());	
	?>
	
	
	<?PHP
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$jobs = $connection->query("CALL getJobs('$username')") or die(mysqli_error());			
	?>
	
	
	<?PHP
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}				
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$dateh = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$hours = $connection->query("CALL getDailyWorkHours('$username','$dateh')") or die(mysqli_error());
			if($hours->num_rows > 0)
			{
				$harray = array();
				while ($r = $hours->fetch_array(MYSQLI_ASSOC)){
					$harray[] = $r;
				}
				$_SESSION['jobhours'] = $harray;								
			}
	?>
	
	<script>
	   htable = <?php echo json_encode($harray); ?>;
    </script>
	
	
    <?php 
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			 
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$res2 = $connection->query("CALL getDailyRecurringIncomes('$username','$date2')") or die(mysqli_error());
	?>	
	
	<?php 
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, $curDay);
			$daySum = $connection->query("CALL getDailyTransactions('$username','$date2')") or die(mysqli_error());
	?>
	<?php 
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
				
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];
			$date2 = sprintf('%4d-%02d-%02d', $curYear, $curMonth, 01);
			$monthSum = $connection->query("CALL getTopMonthlyTransactions('$username','$date2')") or die(mysqli_error());
	?>
	
	<script type="text/javascript"> 
         $(document).ready(function(){
        	$('.specialscroll').jScrollPane(
        	{
        		autoReinitialise: true,
        		showArrows:true
        	});
           slidetgl();
           $( "#datepicker" ).datepicker({defaultDate: <?php echo "\"$curMonth/$curDay/$curYear\""?> ,
                   onSelect: function(dateText, inst) {
						var date = dateText.split("/");
						document.getElementById("cal_date").value = date[1] + '.' + date[0] + '.' + date[2]; 
						document.forms["calendar_get_form"].submit();
                   }});
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
			             	echo "<div id=\"allerr\" class=\"error\"> Input error! Please check values </div>";
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
					                  <td width="55%" class="pfont"><?php echo $curDay.'/'.$curMonth.'/'.$curYear ?>
					                  <input type="hidden" name="curday" value="<?php echo $curDay; ?>"/>
							          <input type="hidden" name="curmonth"  value="<?php echo $curMonth; ?>"/>
							          <input type="hidden" name="curyear"  value="<?php echo $curYear; ?>"/></td>
					               </tr>
						           <tr>
						             <td width="50%" class="pfont">Work:</td>
						             <td width="50%">
						               
						               
							           <select name="workid" id="uwi" class="inpt" style="width:131px" onchange="updtWorkinfo('uwi')">							                     
						                  <option value="clear"></option>
                                          <?php     
                                          	   $jobsarray = array();
                                               if($jobs->num_rows > 0)
                                               {                                               
						                         while ($job = $jobs->fetch_array(MYSQLI_ASSOC)){
						                            $jobsarray[] = $job;						                         	
						                         	$name = $job["name"];						                         	
						                        	$jobId =$job["recTrans"];						                        	
						                         	echo "<option value=\"$jobId\">$name</option>";						                         	
						                         }
						                         $_SESSION['jobs'] = $jobsarray;
                                               }
						                   ?>
						                 </select>
						                 <script>
                                           jobtable = <?php echo json_encode($jobsarray); ?>;
                                         </script>
						              </td> 
						           </tr>
						           <?php if(isset($usrinpt['notallowed']) && $usrinpt['notallowed'] == "error"){
		            			            echo "<tr id=\"workerr\"> <td colspan=\"2\"> <div class=\"error\"> You must choose your work first! </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Work Name: </td>
							         <td width="55%"><input type="text" id="wname" name="workname" class="inpt" size="20" maxlength="30" readonly="readonly"/></td>
							       </tr>							       
							       <tr>
							         <td width="45%" class="pfont">Wage per Hour: </td>
							         <td width="55%"><input type="text" id="jobwage" name="wage" class="inpt" size="20" maxlength="30" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['amount']) && $usrinpt['amount'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Value must be numeric </div> </td> </tr>";}
		            			         else if(isset($usrinpt['sign']) && $usrinpt['sign'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Value must be positive </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Payment Date (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" name="day1" id="wday" size="1" maxlength="2" class="inpt"/>
							          <b>/</b><input type="text" name="month1"  id="wmonth" size="1" maxlength="2" class="inpt"/>
							          <b>/</b><input type="text" name="year1" id="wyear" size="2" maxlength="4" class="inpt"/></td>
							       </tr>
							       <?php if(isset($usrinpt['date']) && $usrinpt['date'] == "error"){
		            			            echo "<tr> <td colspan=\"2\> <div class=\"error\"> Invalid date input </div> </td> </tr>";}?>
							       <tr>
							         <td width="45%" class="pfont">Start Hour(hh:mm): </td>
							         <td width="55%"><input type="text" name="starth" class="inpt" size="6" maxlength="2" id="rsh" onchange="rDayWageTotal()"/>
							                 <b>:</b><input type="text" name="startm" class="inpt" size="6" maxlength="2" id="rsm" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['time1']) && $usrinpt['time1'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Incorrect time </div> </td> </tr>";}?>		            			   
							       <tr>
							         <td width="45%" class="pfont">End Hour(hh:mm): </td>
							         <td width="55%"><input type="text" name="endh" class="inpt" size="6" maxlength="2" id="reh" onchange="rDayWageTotal()"/>
							                 <b>:</b><input type="text" name="endm" class="inpt" size="6" maxlength="2" id="rem" onchange="rDayWageTotal()"/></td>
							       </tr>
							       <?php if(isset($usrinpt['time2']) && $usrinpt['time2'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Incorrect time </div> </td> </tr>";}?>
							       <?php if(isset($usrinpt['hours']) && $usrinpt['hours'] == "error"){
		            			            echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Update hours unavailable! Please delete and insert as new occurence... </div> </td> </tr>";}?>
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
						                 <select name="rtIncome" id="rtinc" class="inpt" style="width:131px" onchange="updtWorkinfo('rtinc')">
						                   <option value="New">New</option>
						                   <?php
						                   	   $recarray = array();
							                   if($res2->num_rows > 0)
							                   {
						                         while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
						                         	$recarray[] = $row2;
						                         	$name = $row2["recname"];
						                        	$recId =$row2["recId"];						                       
						                         	echo "<option value=\"$recId\">$name</option>";					                         	
						                         }
							                   }
						                   ?>
						                 </select>
						                 <script>
                                           rectable = <?php echo json_encode($recarray); ?>;
                                         </script>
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
							       <tr id="firstDate" style="display:table-row">
							         <td width="50%" class="pfont">Date (dd/mm/yyyy): </td>
							         <td width="50%"><input type="text" name="day2" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" name="month2" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" name="year2" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
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
							       
							          <tr><td width="50%" class="pfont" id="updtperiodl" style="display:none"><u>Update Effect For: </u></td></tr>
							          <tr id="secondDate" style="display:none">
								          <td width="50%" class="pfont">Date (dd/mm/yyyy): </td>
								          <td width="50%"><input type="text" name="dayU" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
								          <b>/</b><input type="text" name="monthU" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
								          <b>/</b><input type="text" name="yearU" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
							          </tr>
							          <tr><td colspan="2" class="pfont" id="updtperiod" style="display:none">
							          <input type="radio" id="td" value="1" name="changeP"/><label for="td" style="margin-right:20px">This date</label>
                                      <input type="radio" id="fn" value="2" name="changeP"/><label for="fn" style="margin-right:20px">From now</label>
                                      <input type="radio" id="fa" value="3" name="changeP"/><label for="fa" >For all </label>
                                      </td></tr>
							     
							       
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
						                 <select name="rIncome" id="otislct" class="inpt" style="width:131px" onchange="updtWorkinfo('otislct')">
						                 <option value="New">New</option>
						                   <?php  
						                   		$onetimearray = array();
							                    if($res->num_rows > 0)
							                    {
						                          while ($row = $res->fetch_array(MYSQLI_ASSOC)){
						                         	$onetimearray[] = $row;						                         
						                         	$name = $row["transname"];
						                        	$trnsId =$row["transId"];
						                         	echo "<option value=\"$trnsId\">$name</option>";						                         	
						                         }
							                    }
						                   ?>
						                 </select>
						                 <script>
                                           onetimetable = <?php echo json_encode($onetimearray); ?>;
                                         </script>
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
							         <td width="45%" class="pfont">Date (dd/mm/yyyy): </td>
							         <td width="55%"><input type="text" name="day3" size="1" maxlength="2" class="inpt" value="<?php echo $curDay; ?>"/>
							          <b>/</b><input type="text" name="month3" size="1" maxlength="2" class="inpt" value="<?php echo $curMonth; ?>"/>
							          <b>/</b><input type="text" name="year3" size="2" maxlength="4" class="inpt" value="<?php echo $curYear; ?>"/></td>
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
		             <form id="calendar_get_form" action="<?php echo $PHP_SELF; ?>" method="get" style="display:none;">
							<input type="text" id="cal_date" name="date" />
							<input type="submit" id="cal_clk" />
					 </form>
							
					<!--  Calendar declaration & creation  -->		
					<div id="datepicker"></div> 
		         </div>
		        <div id="daysum">
		            <?php  // if a day is clicked, view that date:
		                      $total = 0;
							  if(!isset($date)){
							  	 $date = sprintf('%02d.%02d.%4d', $curDay, $curMonth, $curYear);
							     }	
							  if($daySum->num_rows > 0 || (isset($harray) && isset($jobsarray))){     
							      echo "<div class=\"daysumhead\">Your balance for: $date</div>";	
							      echo "<div class='specialscroll' style=\"min-height:83px; max-height:83px; overflow:auto;\"><table>";         
									  while ($row2 = $daySum->fetch_array(MYSQLI_ASSOC)){
									      $transname = $row2['transname'];
									      $amnt = $row2['amount'];
									      $trnstype = $row2['transtype'];
									      $descript = $row2['description'];
									      if($amnt != null)
									      {
										      echo "<tr>";
											  if ($amnt < 0){
											   	   $div1 = "<td class=\"redinc roundedincleft\" style=\"cursor:help\" title=\"$descript\">";
											   	   $div2 = "<td class=\"redinc roundedinccntr\" style=\"cursor:help\" title=\"$descript\">";
											   	   $div3 = "<td class=\"redinc roundedincright\" style=\"cursor:help\" title=\"$descript\">";
											      }
											   else if ($amnt > 0) {
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
									    }  // while
									    // need to calculate this day salary
									    $i = 0;
									    $j = 0;
									    if(isset($harray) && isset($jobsarray))
									    {
											    while($i < count($harray))
											    {
											    	$jName = $harray[$i]['transname'];
											    	list($jsDate, $Jsh) = explode(' ', $harray[$i]['startHour'],2);
											    	list($jeDate, $Jeh) = explode(' ', $harray[$i]['endHour'],2);
											    	list($sHour, $sMin, $sSec) = explode(':', $Jsh,3);
											    	list($eHour, $eMin, $eSec) = explode(':', $Jeh,3);
											    	if($eHour == 0)
											    	{   $eHour = 24;   }											    
											    	$tH = $eHour - $sHour;
											    	$tM = $eMin - $sMin;
											    	while($j < count($jobsarray))
											    	      {
											    	      	if($jobsarray[$j]['name'] == $jName)
											    	      	     {
											    	      	     	$jWage =  $jobsarray[$j]['wage'];
											    	      	        $incDate = $jobsarray[$j]['incomeDate'];}
											    	        $j++;									    	      	        
											    	      }
											    	$salary = ($tH * $jWage) + (($tM * 100 * $jWage)/6000);
											    	$amnt = round($salary, 2);
											    	list($yy, $mm, $dd) = explode('-', $incDate,3);
											    	$incDate = sprintf('%02d.%02d.%4d', $dd, $mm, $yy);
											    	if($incDate != date("d.m.Y") && $incDate != $date)	
											    	{								    	
												    	echo "<tr>";
												    	echo "<td  class=\"greyinc roundedincleft\">(Expected $incDate)</td>";
												    	echo "<td  class=\"greyinc roundedinccntr\">$jName</td>";
												    	echo "<td  class=\"greyinc roundedincright\">$amnt$ </td>";
												    	echo "</tr>";										    	
											    	    $total += $amnt;
											    	}
											    	$i ++;
											    	$j = 0;
											    }  // while
									    }
								    echo "</table></div>";
								    echo "<div class=\"daysumhead\" >TOTAL: $total$</div>";
							   }
							  else 
							      echo "<div class=\"daysumhead\">You have no transactions for $date</div>"
					  ?>
		          </div>
		          <div id="monthsum">
		             <?php // current month
				             if($monthSum != null && $monthSum->num_rows > 0){
				             	  $m = $months[$curMonth-1];
				             	  echo "<div class=\"daysumhead\" style=\"font-size:12px; width:85%;\">Top transactions for: $m</div>";
				                  echo "<div class='specialscroll' style=\"min-height:180px; overflow-y: scroll;\"><table>";         
											  while ($rowm = $monthSum->fetch_array(MYSQLI_ASSOC)){
											  	if($rowm != null && $rowm['transid'] != null)
											  	{
											      $transname = $rowm['transname'];
											      $amnt = $rowm['amount'];
											      $trnstype = $rowm['transtype'];
											      $descript = $rowm['description'];
											      if($amnt != null){
											         echo "<tr>";											      
														  if ($amnt < 0){
														  	   $div1 = "<td><img src=\"images/arrowDownRed.png\" class=\"MSImg\"/></td>";
														   	   $div2 = "<td class=\"roundedincMleft\" style=\"cursor:help float:left;\" title=\"$descript\">";												   	  
														   	   $div3 = "<td class=\"roundedincMright\" style=\"cursor:help\" title=\"$descript\">";
														      }
														   else if ($amnt > 0){
														   	   $div1 = "<td><img src=\"images/arrowUpGreen.png\" class=\"MSImg\"/></td>";
														   	   $div2 = "<td  class=\"roundedincMleft\" style=\"cursor:help float:left;\" title=\"$descript\">";												   	  
														   	   $div3 = "<td  class=\"roundedincMright\" style=\"cursor:help\" title=\"$descript\">";
														      } 
														   echo "{$div1}";
													       echo "{$div2}$transname</td>";
													       echo "{$div3}$amnt$ </td>";  
													       echo "</tr>";														       													      
											           }
											  	 }
											}
										    echo "</table></div>";
				             }
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
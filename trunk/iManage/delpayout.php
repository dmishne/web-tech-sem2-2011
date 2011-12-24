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
    <?php 
		if((isset($_SESSION['deletedate'])))
		{
			$delDate = $_SESSION['deletedate'];
			$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			
			$connection->select_db($serverInfo["db"]);
			$username= $_SESSION['username'];  // from current user session submited on login
			
			$result = $connection->query("CALL getTransToDelete('$delDate','$username')") or die(mysqli_error());
			if (!$result) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
		}
	?>
	
	
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
		           Delete Payouts
			</div>
			<div id="content-middle">
	                  
		            <?php  if(isset($date))
							        list($curDay, $curMonth, $curYear)= explode('.', $date,3);
							else
							        list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3); 
				     ?>
				 <form method="post" action="getDelIncome.php" id="delMonthChoosser">
				 <div style="margin:15px auto 15px auto">
				       <div style="margin:auto 10px auto 40px; width:11%; float:left">
					       <select name="delMonth" class="delChooser" style="width:80px">
				                <?php  
				                    $selMonth = null;
					                if((isset($_SESSION['deletemonth'])))
					                {
					                	$selMonth = $_SESSION['deletemonth'];
					                }
					                $selectM= $selMonth != null?$selMonth:$curMonth;
			                      for($j = 1 ; $j < 13 ; $j++){
			                         if($j == $selectM)
			                             echo " <option  selected=\"1\">$j</option>";
                                     else
			                             echo " <option>$j</option>";}
                                     $_SESSION['deletemonth'] = null;
			                   ?>
				            </select> 
			            </div>
			            <div style="margin:auto 30px auto auto; width:11%; float:left">
			                <select name="delYear" class="delChooser" style="width:80px">
			                   <?php  
				                   $selYear = null;
				                   if((isset($_SESSION['deleteyear'])))
				                   {
				                   	$selYear = $_SESSION['deleteyear'];
				                   }
				                   $selectY= $selYear != null?$selYear:$curYear;
			                      for($i = ($curYear-10),$j = 1 ; $j <= 21 ; $i++,$j++){
			                         if($i == $selectY)
			                             echo " <option  selected=\"1\">$i</option>";
                                     else
			                             echo " <option>$i</option>";}
                                     $_SESSION['deleteyear'] = null;
			                   ?>
			                </select>
			            </div>
			            <div>
			                <input type="hidden" name="deleteform" value="deletePayout" />
			                <input type="submit" value="Go" class="blue button small bround"></input>
			            </div>  
			            <br style="clear:left;"/>   
			   </div>
			    </form>
			   <form method="post" action="deleteVerifier.php" id="deletepayouts">   		
			   <div style="width:65%; float:left; min-height:260px; margin:auto 30px auto auto;">
				   <ul id="mainul">
			           <?php 
			              $prevLi = 0;
			              $cnt = 0;
			              $i = 1;                           //img[i],<ul id="ulexp[i]>
			              $j = 1;                           //checkbox[j]
			              $tamnt =0;                        // for income findout				              
			              if($result->num_rows > 0 && mysqli_num_fields($result) == 7){                           
			                  while ($row = $result->fetch_array(MYSQLI_ASSOC))
			                  {
					                  $recid = $row['recid'];
					                  $jobhourid = $row['jobhourid'];
					                  $transid = $row['transid'];
					                  $name = $row['transname']; 
					                  $amount = $row["amount"];
					                  $transdate = $row['transdate'];
					                  $iscommited = $row['iscommited'];

					                 	// ---------  reccurings -----------//
							           	if($recid != null && $jobhourid == null && $transid == null && $transdate == null)   // is reccuring label?
							           	{
							           		if($prevLi != 0)       // end internal list 
							           		{
							           		    echo "</ul></li>";
							           		    $prevLi = 0;
							           		    if($tamnt > 0 ){
							           		    	$tmp = $i-1;
							           		    	$cnt--;
							           		    	echo "
								           		    	   <script type=\"text/javascript\">
								           		    	      var payout = document.getElementById(\"row$tmp\");
           											          var lst = document.getElementById(\"mainul\");
           											          lst.removeChild(payout);
								           		    	   </script>
							           		    	     ";
							           		         }
							           		         $tamnt = 0;
							           		}
							           		if($transdate == null && $jobhourid == null){
							           			$transdate = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							           		}
								           	echo "
								           	      <li class=\"noBullet pfont\" id=\"row$i\" style=\"clear:both; display:block\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserexpand.png\" onclick=\"collapseLst('ulexp$i');chngimg('#i$i')\"/>&nbsp;&nbsp;&nbsp;&nbsp;
								           	        $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;
								           	        <input type=\"checkbox\" class=\"inpt\" name=\"formDelPay[]\" id=\"del$j\" style=\"float:right\" value=\"1-$recid,3,null\"/>  
								           	       <ul style=\"display:none\" id=\"ulexp$i\"> 
								           	  ";
								           	$transdate = null;
								           	$prevLi = 1;
								           	$i++;
								           	$j++;
								           	$cnt++;
							           	 }
							           	if($recid != null && $jobhourid == null && $transid != null && $transdate != null)  // is reccuring child?
							           	{
							           	    echo "
							           	        <li class=\"noBullet pfont\" style=\"clear:both; display:block\"><img src=\"images/chooserempty.png\"/>&nbsp;&nbsp;
								           	      $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;
								           	      <input type=\"checkbox\" class=\"inpt\" name=\"formDelPay[]\" id=\"del$j\" style=\"float:right\" value=\"2-$transid,1,$transdate\"/></li>   
							           	      ";
							           	    $j++;							           	   
							           	    $tamnt+=$amount;
							           	}
							           	

							           	// ---------  one times ---------//
							            if($recid == null && $jobhourid == null && $transid != null && $transdate != null)   // is one time?
							            {
							            	if($prevLi != 0)        // end internal list
							            	{
							            		echo "</ul></li>";
							            		$prevLi = 0;
							            		if($tamnt > 0 ){
							            			$tmp = $i-1;
							            			$cnt--;
            			                            echo "
            	           								  <script type=\"text/javascript\">
            		           								 var payout = document.getElementById(\"row$tmp\");
            		           								 var lst = document.getElementById(\"mainul\");
            		           								 lst.removeChild(payout);
            	           								  </script>
            	           								 ";
            	           								 $tamnt = 0;
							            		 }
							            	}
							            	if($amount < 0 || $amount == null)
							            	{
								            	echo "
									           	      <li class=\"noBullet pfont\" style=\"clear:both; display:block\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserempty.png\"/>&nbsp;&nbsp;&nbsp;&nbsp;
									           	      $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;&nbsp;
									           	      <input type=\"checkbox\" class=\"inpt\" name=\"formDelPay[]\" id=\"del$j\" style=\"position:relative; float:right\" value=\"2-$transid,1,$transdate\"/> 
								            	     "; 
								            	$i++;
								            	$j++;	
								            	$cnt++;
							            	}
							            } 
			                       }   // while ($row = $result->fetch_array(MYSQLI_ASSOC))  
			                       if($prevLi != 0)       // end internal list
			                       {
				                      echo "</ul></li>";
				                      $prevLi = 0;
				                      if($tamnt > 0 ){
				                       		$tmp = $i-1;
				                       		$cnt--;
				                       		echo "
	                       						  <script type=\"text/javascript\">
	                       						      var payout = document.getElementById(\"row$tmp\");
           											  var lst = document.getElementById(\"mainul\");
           											  lst.removeChild(payout);
	                       						  </script>
	                       						 ";
				                       	 }
			                            $tamnt = 0;
			                       	}
			                       
			                       
			                   }		//   if($result->num_rows > 0)	   
			                   if($cnt <= 0 && isset($_SESSION['deletedate']))
			                   {
			                   	echo "<p class=\"pfont\" style=\"font-size:14px\">No payout results for this month</p>";
			                   } 		                   
				              $_SESSION['deletedate']= null;
				              unset($_SESSION['deletedate']);
				              unset($_SESSION['deletemonth']); 
				              unset($_SESSION['deleteyear']);
				              echo "<input type=\"hidden\" name=\"delete\" value=\"payout+$j\" />";
			               ?>
			        </ul>
			        
		      </div>
		      <div style="width:25%; float:left; min-height:260px; margin:auto auto auto 30px;">
		         <?php 
			           if($result->num_rows > 0 && $cnt > 0){
			               echo "
						          <p style=\"color:red; border:solid 1px red; position:relative; padding-left:70px;\"><b>Warning!</b></p>
						          <p  style=\"font-size:12px\">Deletion of the entire income label, will also delete all occurrences of this label </p>
				                ";}			          
			      ?>
		      </div>
		      <br style="clear:left;"/>
		      <div style="margin:15px auto 30px 30px;">
		          <?php 
			            if($result->num_rows > 0 && $cnt > 0){
			               echo "<input type=\"submit\" value=\"Delete\" class=\"blue button small bround\" style=\"position:relative; align:bottom;\"></input>";
			            }
			        ?>
			        <?php 
				        if ($result instanceof mysqli_result && $result->num_rows > 0) {
				        	$result->free();
				        }
			        ?>
		      </div>
		      </form> 
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>
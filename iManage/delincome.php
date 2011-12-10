<?php session_start();
// Verifies that user has logged in. Redirect to login page in case not logged in.
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
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
	
	<?php 
		if((isset($_SESSION['deletedate'])))
		{
			$delDate = $_SESSION['deletedate'];
			$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
			if (mysqli_connect_errno()) {
				die('Could not connect: ' . mysqli_connect_error());
			}
			
			$connection->select_db('webtech');
			$username= $_SESSION['username'];  // from current user session submited on login
			
			$result = $connection->query("CALL getTransToDelete('$delDate','$username')") or die(mysqli_error());
			if (!$result) {
				echo 'Could not run query: ' . mysql_error();
				exit;}
		
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
		           Delete Incomes
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
			                      for($j = 1 ; $j < 13 ; $j++){
			                         if($j == $curMonth)
			                             echo " <option  selected=\"1\">$j</option>";
                                     else
			                             echo " <option>$j</option>";}
			                   ?>
				            </select> 
			            </div>
			            <div style="margin:auto 30px auto auto; width:11%; float:left">
			                <select name="delYear" class="delChooser" style="width:80px">
			                   <?php  
			                      for($i = ($curYear-30),$j = 1 ; $j <= 61 ; $i++,$j++){
			                         if($i == $curYear)
			                             echo " <option  selected=\"1\">$i</option>";
                                     else
			                             echo " <option>$i</option>";}
			                   ?>
			                </select>
			            </div>
			            <div>
			                <input type="submit" value="Go" class="blue button small bround"></input>
			            </div>  
			            <br style="clear:left;"/>   
			   </div>
			    </form>
			   <form method="post" action="" id="deleteincomes">   		
			   <div style="width:65%; float:left; min-height:260px; margin:auto 30px auto auto;">
				   <ul>
			           <?php 
			              $prevLi = 0;
			              $prevLi = 0;
			              $i = 1;                           //img[i],<ul id="ulexp[i]>
			              $j = 1;                           //checkbox[j]
			              $tamnt =0;                        // for payout findout			      
			              if($result->num_rows > 0){                           
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
							           		    if($tamnt < 0 ){
							           		    	$tmp = $i-1;
							           		    	echo "
								           		    	   <script type=\"text/javascript\">
								           		    	       document.getElementById(\"row$tmp\").style.display = \"none\";
								           		    	   </script>
							           		    	     ";
							           		    	  $tamnt = 0;
							           		         }
							           		}
								           	echo "
								           	      <li class=\"noBullet\" id=\"row$i\" style=\"display:block\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserexpand.png\" onclick=\"collapseLst('ulexp$i');chngimg('#i$i')\"/>&nbsp;&nbsp;&nbsp;&nbsp;
								           	        $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;
								           	        <input type=\"checkbox\" id=\"del$j\" style=\"float:right\"/>  
								           	       <ul style=\"display:none\" id=\"ulexp$i\"> 
								           	  ";
								           	$prevLi = 1;
								           	$i++;
								           	$j++;
							           	 }
							           	if($recid != null && $jobhourid == null && $transid != null && $transdate != null)  // is reccuring child?
							           	{
							           	    echo "
							           	        <li class=\"noBullet\"><img src=\"images/chooserempty.png\"/>&nbsp;&nbsp;
								           	      $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;
								           	      <input type=\"checkbox\" id=\"del$j\" style=\"float:right\"/></li>   
							           	      ";
							           	    $j++;
							           	    $tamnt+=$amount;
							           	}
							           	
							           	// ---------   jobs --------- //
							           	if($recid != null && $jobhourid == null && $transid == null && $transdate != null)   // is job label?
							           	{
							           		if($prevLi != 0)        // end internal list
							           		{
							           			echo "</ul></li>";
							           			$prevLi = 0;
							           	        }
							           		echo "
           									       <li class=\"noBullet\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserexpand.png\" onclick=\"collapseLst('ulexp$i');chngimg('#i$i')\"/>&nbsp;&nbsp;&nbsp;&nbsp;
           									          $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;&nbsp;
           									          <input type=\"checkbox\" id=\"del$j\" style=\"float:right\"/>  
           									        <ul style=\"display:none\" id=\"ulexp$i\"> 
           									      ";
           									      $prevLi = 1;
           									      $i++;
           									      $j++;
							           	}
							           	if($recid != null && $jobhourid != null && $transid == null && $transdate == null)  // is job child?
							           	{
								           	echo "
								           	      <li class=\"noBullet\"><img src=\"images/chooserempty.png\"/>&nbsp;&nbsp;
	           									    $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;
	           									    <input type=\"checkbox\" id=\"del$j\" style=\"float:right\"/></li>   
	           								     ";
	           								     $j++;							             	
           								 }
							           	
							           	
							           	
							           	// ---------  one times ---------//
							            if($recid == null && $jobhourid == null && $transid != null && $transdate != null)   // is one time?
							            {
							            	if($amount >= 0 || $amount == null)
							            	{
								            	echo "
									           	      <li class=\"noBullet\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserempty.png\"/>&nbsp;&nbsp;&nbsp;&nbsp;
									           	      $transdate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;&nbsp;
									           	      <input type=\"checkbox\" id=\"del$j\" style=\"float:right\"/> 
								            	     "; 
								            	$i++;
								            	$j++;
							            	}
							            } 
			                  }   // while ($row = $result->fetch_array(MYSQLI_ASSOC))  
			              }		//   if($result->num_rows > 0)	    
				          $_SESSION['deletedate']= null;
				          unset($_SESSION['deletedate']);
				          mysql_free_result($result);
			           ?>
			        </ul>
			        
		      </div>
		      <div style="width:25%; float:left; min-height:260px; margin:auto auto auto 30px;">
		         <?php 
			            if($result->num_rows > 0){
			               echo "
						          <p style=\"color:red; border:solid 1px red; position:relative; padding-left:70px;\"><b>Warning!</b></p>
						          <p  style=\"font-size:12px\">Deletion of the entire income label, will also delete all occurrences of this label </p>
				                ";}
			      ?>
		      </div>
		      <br style="clear:left;"/>
		      <div style="margin:15px auto 30px 30px;">
		          <?php 
			            if($result->num_rows > 0){
			               echo "<input type=\"submit\" value=\"Delete\" class=\"blue button small bround\" style=\"position:relative; align:bottom;\"></input>";
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
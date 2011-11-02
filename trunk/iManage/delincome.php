<?php session_start();
// Verifies that user has logged in. Redirect to login page in case not logged in.
/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}*/
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
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php"; ?>
	</div>
	
	<div id="middle">
		<div id="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		           Delete Incomes
			</div>
			<div id="content-middle">
	                <?php 
			             if((isset($_SESSION['delincome'])))
			             {
			             	$delData = $_SESSION['delincome'];
			             }
		             ?>	  		  
		            <?php  if(isset($date))
							        list($curDay, $curMonth, $curYear)= explode('.', $date,3);
							else
							        list($curDay, $curMonth, $curYear) = explode('-', date('d-m-Y'),3); 
				     ?>
				 <form method="post" action="getDelIncome.php" id="delMonthChoosser">
				 <div style="margin:15px auto 15px auto">
				       <div class="delChsr">
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
			            <div >
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
			   </div>
			    </form>
			   <div>
				   <ul>
			           <?php 
			              $prevLi = 0;
			              $i = 1;                           //img[i],<ul id="ulexp[i]>
			              $j = 1;                           //checkbox[j]
				      /*  $res = $dalData['res'];  
				        while ($row = mysql_fetch_assoc($res)) {
				           	$trnsdate = $row["transDate"];
				           	$trnsName = $row["transCustomName"];
				           	$lbl = $row["labelId"]; 
				           	$prnt = $row["fatherId"];
				           	$trnsid = $row["transId"];
				           	$amount = $row["amount"];*/
			              $trnsdate = "2011-10-30";
			              $trnsName = "intrl";
			              $lbl = 1;
			              $prnt = null;
			              $trnsid = 1234;
			              $amount = 200;
			              $lbl1 = null;
			              $prnt1 = 1;
				           	if($lbl == 1 && $prnt == null){
				           		if($prevLi != 0){
				           		    echo "</ul></li>";
				           		    $prevLi = 0;}
					           	echo "
					           	      <li class=\"noBullet\"><img id=\"i$i\" style=\"cursor: pointer;\"  src=\"images/chooserexpand.png\" onclick=\"collapseLst('ulexp$i');chngimg('#i$i')\"/>&nbsp;&nbsp;&nbsp;&nbsp;
					           	      $trnsdate&nbsp;&nbsp;&nbsp;$trnsName&nbsp;&nbsp;&nbsp;$amount&nbsp;&nbsp;&nbsp;&nbsp;
					           	      <input type=\"checkbox\" id=\"del$j\"/>  
					           	       <ul style=\"display:none\" id=\"ulexp$i\"> 
					           	  ";
					           	$prevLi = 1;
					           	$i++;
					           	$j++;
				           	     }
				           	if($lbl1 == null && !$prnt1 == null ){
				           	    echo "
				           	        <li class=\"noBullet\"><img src=\"images/chooserempty.png\"/>&nbsp;&nbsp;
					           	      $trnsdate&nbsp;$trnsName&nbsp;$amount&nbsp;&nbsp;
					           	      <input type=\"checkbox\" id=\"del$j\"/></li>   
				           	      ";
				           	    $j++;
				           	}
				    //       }
				           
				      //     mysql_free_result($result);
			           ?>
			        </ul>
		      </div>
		      <?php unset($_SESSION['addincome']);?> 
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>
<?php include "beforeLoadCheck.php"; ?>
<script type="text/javascript">
		$(document).ready(function(){setMenu();});
</script>
<div id="topCenter"> Menu </div>
<ul class="mainMenu">
	<li class="noBullet"> <a href="index.php"> Home Page </a> </li>
	<li class="toggleable"> Incomes
		<ul id="incomesMenu">			
			<li> <a href="addincome.php"> Add/Update Income </a> </li>
			<li> <a href="delincome.php"> Delete Income </a> </li>
			<li> <a href="createWork.php"> Job Information </a> </li>
		</ul>
	</li>
	<li class="toggleable"> Payouts
		<ul id="payoutsMenu">
			<li> <a href="addpayout.php"> Add/Update Payout </a> </li>
			<li> <a href="delpayout.php"> Delete Payout </a> </li>
		</ul>
	</li>
	<?php
	if(!isset($_SESSION['login']) || $_SESSION['login'] == '0' || ($_SESSION['login'] == '1' && ($_SESSION['permissionid']== '3' || $_SESSION['permissionid']=='2' )))
	{
		echo "<li class='toggleable'> Investments";
		echo	 "<ul id='investmentsMenu'>";
		echo 		"<li> <a href='stocksView.php'> View Virtual Portfolio </a> </li>";
		echo 		"<li> <a href='stockManage.php'> Manage Virtual Portfolio </a> </li>";
		echo 	"</ul>";
		echo "</li>";
	}
	?>
	<li class="toggleable"> Reports 
		<ul id="reportsMenu">
			<li> <a href="report.php"> General Yealy Report </a> </li>
			<li> <a href="reportf.php"> Balance Forecast Report </a> </li>
		</ul>
	</li>
	<?php 
	     if(isset($_SESSION['login']) && $_SESSION['login'] != '0' && isset($_SESSION['permissionid']) && '3' == $_SESSION['permissionid'])
	     {
	     	echo "<li class=\"noBullet\"><a href=\"manageUsers.php\"> User Management</a></li>";
	     }
	?>
	
</ul>
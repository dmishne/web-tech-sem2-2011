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
			<li> <a href="createWork.php"> Create Work Information </a> </li>
		</ul>
	</li>
	<li class="toggleable"> Payouts
		<ul id="payoutsMenu">
			<li> <a href="addpayout.php"> Add/Update Payout </a> </li>
			<li> <a href="delpayout.php"> Delete Payout </a> </li>
		</ul>
	</li>
	<li class="toggleable"> Investments
		<ul id="investmentsMenu">
			<li> View virtual portfolio </li>
			<li> Manage virtual portfolio </li>
		</ul>
	</li>
	<li class="toggleable"> Reports 
		<ul id="reportsMenu">
			<li>  <a href="reportIncome.php"> Generate incomes report </a> </li>
			<li> Generate payouts report </li>
			<li> Balance forecast report </li>
		</ul>
	</li>
	<li class="toggleable"> User Management
		<ul id="userManagementMenu">
			<li> Promote user </li>
			<li> Lock/Unlock user </li>
		</ul>
	</li>
</ul>
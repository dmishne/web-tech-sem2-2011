<script type="text/javascript">
		$(document).ready(function(){setMenu();});
</script>
<div id="topCenter"> Menu </div>
<ul class="mainMenu">
	<li id="noBullet"> <a href="index.php"> Home Page </a> </li>
	<li class="toggleable"> Incomes
		<ul id="incomesMenu">
			<li> Update working hours </li>
			<li> <a href="addincome.php"> Add income </a> </li>
			<li> Delete income </li>
		</ul>
	</li>
	<li class="toggleable"> Payouts
		<ul id="payoutsMenu">
			<li> Add payout </li>
			<li> Delete payout </li>
		</ul>
	</li>
	<li class="toggleable"> Investments
		<ul id="investmentsMenu">
			<li> View stock market </li>
			<li> Manage portfolio </li>
		</ul>
	</li>
	<li class="toggleable"> Reports 
		<ul id="reportsMenu">
			<li> Generate incomes report </li>
			<li> Generate payouts report </li>
			<li> Balance forecast report </li>
			<li> Investments report </li>
		</ul>
	</li>
	<li class="toggleable"> User Management
		<ul id="userManagementMenu">
			<li> Promote user </li>
			<li> Lock/Unlock user </li>
		</ul>
	</li>
</ul>
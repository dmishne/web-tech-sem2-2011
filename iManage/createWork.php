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
	

	<script type="text/javascript" src="JQueryUI/jquery-ui-1.8.16.custom.min.js"> </script>
	<link rel="stylesheet" href="JQueryUI/jquery-ui-1.8.16.custom.css" type="text/css"/>
	<style type="text/css">
	
		.ui-widget {
			font-size: 0.8em;
		}	
	</style>
	<?php 
		$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
		if (mysqli_connect_errno()) {
			die('Could not connect: ' . mysqli_connect_error());
		}
		$connection->select_db($serverInfo["db"]);
		$username= $_SESSION['username'];
		$jobs = $connection->query("CALL getJobs('$username')") or die(mysqli_error());
		$jobsarray = array();
		if ($jobs->num_rows > 0)
		{
			while ($job = $jobs->fetch_array(MYSQLI_ASSOC)){
				$jobsarray[] = $job;
			}
			$_SESSION["jobsarray"] = $jobsarray;
			echo "<script type=\"text/javascript\">\n";
			echo "var jobs = " . json_encode($jobsarray);
			echo "\n</script>";
		}
		
		if(isset($_SESSION['createWorkError']))
		{
			$error = $_SESSION['createWorkError'];
		}
	?>
	
	
	<script type="text/javascript">
	function validateDelete()
	{
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#dialog-delete" ).dialog({
			resizable: false,
			height:'auto',
			modal: true,
			buttons: {
				"Delete": function() {
					document.getElementById("job_to_del").value = document.getElementById("create_work_id_selection").value;
					$( this ).dialog( "close" );
					document.forms["job_to_del_form"].submit();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

	}

	function showWorkInfo() {
		var sel = document.getElementById("create_work_id_selection");
		if (sel.selectedIndex != 0) {
			document.getElementById("creatework_jobsname").value = jobs[sel.selectedIndex-1]["name"];
			document.getElementById("creatework_wagehour").value = jobs[sel.selectedIndex-1]["wage"];
			document.getElementById("creatework_pDay").value = jobs[sel.selectedIndex-1]["incomeDate"].split("-")[2];
			document.getElementById("creatework_desc").value = jobs[sel.selectedIndex-1]["description"];
			document.getElementById("creatework_submit").value = "Edit Work Information";
			document.getElementById("creatework_del").innerHTML="<div style='clear:both;' class='redh button small' onclick='validateDelete()'> Delete Work Information </div>";
		}
		else {
			document.getElementById("creatework_jobsname").value = "";
			document.getElementById("creatework_wagehour").value = "";
			document.getElementById("creatework_pDay").value = "";
			document.getElementById("creatework_desc").value = "";
			document.getElementById("creatework_submit").value = "Add New Work Information";
			document.getElementById("creatework_del").innerHTML= "";
		}
	}
	</script>
	
	
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
		           Job Information
			</div>
			<div id="content-middle">
				   <form  method="post" action="createWorkVerifier.php" id="createWork_form">
			           <div id="createWork" class="greyCube">
				           <table id="create_work_table" style="margin-left:auto; margin-right:auto; text-align:left; display:inner-block;">
				           		<tr style="text-align:center;"> 
				           			<th colspan="2"> Job Information </th> 
				           		</tr>
				           		<?php 
		            				if(isset($error['Reg']) && $error['Reg'] = 1){
		            					echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Registration error! </div> </td> </tr>";
		            				}
		            			?>
				           		<tr style="text-align:center;">
				           			<td colspan="2">
				           				<select id="create_work_id_selection" name="create_work_id_selection" onchange="showWorkInfo()" onkeyup="showWorkInfo()">
				           					<option value=""> New Job Information </option>
				           					<?php 
				           					if(count($jobs) > 0)
				           					{
					           					foreach ($jobsarray as &$job)
					           					{
					           						$name = $job["name"];
					           						$jobId = $job["recTrans"];
					           						echo "<option value=\"$jobId\">$name</option>";
					           					}
				           					}
				           					?>
				           				</select>
				           			</td>
				           		</tr>
				           		<tr>
				           			<td> Name: </td>
				           			<td> <input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="creatework_jobsname" name="creatework_jobsname" /> </td>
				           		</tr>
				           		<?php 
		            				if(isset($error['creatework_jobsname']) && $error['creatework_jobsname'] = 1){
		            					echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Error! At least 3 letters required without special letters. </div> </td> </tr>";
		            				}
		            			?>
				           		<tr>
				           			<td> Wage Per Hour: </td>
				           			<td> <input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="creatework_wagehour" name="creatework_wagehour" /> </td>
				           		</tr>
				           		<?php 
				            		if(isset($error['creatework_wagehour']) && $error['creatework_wagehour'] = 1){
				            			echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Error! Should be numeric and non negative! </div> </td> </tr>";
				            		}
		            			?>
				           		<tr>
				           			<td> Payment Day: </td>
				           			<td style="text-align: justify;">
			                   			<input type="text" size="30" maxlength="2" class="inpt" id="creatework_pDay"   name="creatework_pDay" />
	 	            			    </td>
				           		</tr>
				           		<?php 
		            				if(isset($error['creatework_pDay']) && $error['creatework_pDay'] = 1){
		            					echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Error! Should be a number between 1-31. </div> </td> </tr>";
		            				}
		            			?>
				           		<tr>
				           			<td style="vertical-align: text-top "> Notes/Description: </td>
				           			<td><textarea id="creatework_desc" name="creatework_desc" rows="8" cols="32" class="inpt"> </textarea></td>
				           		</tr>
				           		<?php 
				            		if(isset($error['creatework_desc']) && $error['creatework_desc'] = 1){
				            			echo "<tr> <td colspan=\"2\"> <div class=\"error\"> Error! Don't use special characters. </div> </td> </tr>";
				            		}
		            			?>
				           </table>
			           </div>
			           <div style="clear:both; width:100%; margin: 40px 0px 0px 0px; text-align:center;">
			           	   <input name="Submit" id="creatework_submit" type="submit" value="Add New Work Information" class="blue button medium" style="min-width:100px;" />
			           </div>
		           </form>
			</div>
			<div id="creatework_del" style="clear:both; text-align:right; width:100%;"></div>
			<div id="dialog-delete" title="Action Required" style="display: none; font-size:14px; min-height:0;">
				<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You're about to delete the job information and all relevant entries. Are you sure?
			</div>
			<form method="post" action="createWorkVerifier.php" id="job_to_del_form" style="display:none;">
				<input type="text" id="job_to_del" name="job_to_del" />
				<input type="submit" id="job_to_del_clk" />
			</form>
		</div>
		<?php 
			unset($_SESSION['createWorkError']);
        ?>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>
<?php session_start();
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
	
	<script type="text/javascript">
		$(document).ready(function(){MUSearch();});
		$(document).ready(function(){MUPost();});
		$(document).ready(function(){L_U_D();});
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
		           Users Management
			</div>
			<div id="content-middle">	
			   <form method="post" action="" id="manageUser_search">		 
			   <div>
			    <table class="ManageUserTablesStyle" style="width:100%;">
			         <tr>
			            <th colspan="3" > Edit User Data </th>
			         </tr>
			         <tr>			                
				            <td align="right">Search User:</td>
				            <td style="width:185px;"><input type="text" id="search_username" name="searchUser" class="inpt" placeholder="Search..." style="position:relative; top:0px;" size="30" maxlength="16"></input></td>
				            <td align="left"><input type="submit" id="search" value="Search" class="blue button small bround"></input></td>
					 </tr>
				   </table>
			     </div>
			     </form>
			     <form method="post" action="" id="manageUser_form">
			     <div id="data_div" style="display:none">
			        <table style="width:100%;">
			         <tr>			            
			            <td style="width:45%; padding:0px;">
                           <table class="ManageUserTablesStyle" style="width:100%; height:205px;">
						         <tr>			            
						            <td style="width:30%;">Edit Status:</td>
						            <td colspan="2" style="width:50%;">
						                <select name="Status" id="UStatusSelector" class="delChooser" style="width:180px">
							           		 <option value="Regular"> Regular</option>
							           		 <option value="Premium"> Premium</option>
							           		 <option value="Admin"> Admin</option>
							            </select>			                
						            </td>
						         </tr>
						         <tr>
						            <td style="width:30%;">Username:</td>
						            <td colspan="2"><input id="Uusername" name="Username" type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16"></input></td>			   
						         </tr>
						         <tr>
						            <td style="width:30%;">First Name:</td>
						            <td colspan="2"><input id="UFirstName" name="FName" type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16"></input></td>
						         </tr>
						         <tr>
						            <td style="width:30%;">Last Name:</td>
						            <td colspan="2"><input id="ULastName" name="LName" type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16"></input></td>
						         </tr>
						         <tr>
						            <td style="width:30%;">Date of birth:</td>
						            <td colspan="2"><input id="UBirthDate" name="BD" type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16"></input></td>
						         </tr>
						         <tr>
						            <td style="width:30%;">Email Address:</td>
						            <td colspan="2"><input id="UMail" name="EmailAdd" type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16"></input></td>
						         </tr>    					      
						     </table> 
						 </td> 
						 <td style="width:45%; padding:0px;">
						    <table class="ManageUserTablesStyle" style="width:100%; height:205px;">
						       <tr align="center">
						         <td>
						           <fieldset>
				           		     <legend > Comments</legend>
				           		        <textarea id="manageUser_log" rows="9" cols="60" class="inpt"></textarea> 
				           		   </fieldset>
				           		 </td>
				           	   </tr>	
						    </table>
						 </td>   
			         </tr>	         
			       </table>
			    </div>
			    <div id="buttons_div" style="display:none">
			         <table class="ManageUserTablesStyleB" style="width:100%;">
		                   <tr align="center">				           		    
				           		    <td colspan="3"><input id="unlock_user" type="button" value="Unlock User" class="blue button small bround"></input>
				           		    <input id="lock_user" type="button" value="Lock User" class="blue button small bround"></input>				           		    
				           		    <input id="delete_user" type="button" value="Delete User" class="blue button small bround"></input>
				           		    <input type="submit" value="Save" class="blue button small bround" style="margin-left:40px"></input></td>
				           	</tr>	
		              </table>
			         
			    </div>
			    </form>
			    <div style="min-height:20px;"><p id="spn" style="display:none; font-color:green;"></p></div> 
			    <div id="mail_div" style="display:none">
			        <table class="ManageUserTablesStyle" style="width:100%;">
			             <tr style="text-align:center;"> 
				           	  <th colspan="2" style="padding:1px;"> Email User </th> 
				         </tr>
				         <tr align="center">
				              <td style="padding-left:25px">Subject:</td>
				              <td><input id="Mail_subject" type="text" class="inpt" style="position:relative; top:0px;" size="125" maxlength="150"></input></td>
				         </tr>			           					           						           					           						           		
				         <tr>				           		   
				           	  <td colspan="2" align="center"><textarea rows="8" cols="145" class="inpt"></textarea> </td>
				         </tr>
				         <tr align="left">
				           	  <td id="eot" colspan="2" style="padding-left:25px"><input type="submit" style="display:table-cell;" value="Send" class="blue button small bround"></input></td>
				         </tr>	

			        </table>
			    </div>			    
			</div>   <!-- content- middle -->
		</div>  <!-- content -->
	</div>  <!-- Middle -->
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>

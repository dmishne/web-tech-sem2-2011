	
function MUSearch()
{
	  $("#manageUser_search").submit(function()	
			{	
		        $.post("manageUsersForm.php",{ search_username:$('#search_username').val(), flag:1},
		        		function(data)
		        		{		        	         
		                     if(data != "User Not Found!")
		                    	 {		                    	   
		                    	     var res = $.parseJSON(data);
		                    	     $.each(res, function(key, value){
		                    	    	 switch (key)
		                    	    	 {
		                    	    	 case 'firstName':		                    	    		
		                    	    		 $("#UFirst_Name").val(value);
		                    	    		 break;
		                    	    	 case 'lastName':
		                    	    		 $("#ULast_Name").val(value);
		                    	    		 break;
		                    	    	 case 'dateOfBirth':
		                    	    		 $("#UBirthDate").val(value);
		                    	    		 break;
		                    	    	 case 'email':
		                    	    		 $("#UMail").val(value);
		                    	    		 break;
		                    	    	 case 'name':
		                    	    		 $("#UStatus_selector").val(value);
		                    	    	 case 'statusChangeComment':
		                    	    		 $("#manageUser_log").val(value);
		                    	    	 }
		                    	     });
		                    	      $("#Uusername").val($('#search_username').val());
   
		                    	      $("#data_div").fadeIn(1500);
		                    	      $("#buttons_div").fadeIn(1500);
		                    	      $("#mail_div").fadeIn(2500);
		                    	 }
		                     else
		                    	 {
		                    	     alert("User not found!");
		                    	 }
		        		});    //   post
		        return false;
			});   // submit
}


function MUPost()
{
	$("#manageUser_form").submit(function()	
			{
				$.post("manageUsersForm.php",{ Username:$('#Uusername').val(),
											   Fname:$('#UFirst_Name').val(),
											   Lname:$('#ULast_Name').val(),
											   BD:$('#UBirthDate').val(),
											   Status:$('#UStatus_selector').val(),
											   EmailAdd:$('#UMail').val(),
					                           flag:2},
		        		                       function(data)
		        		                       {
					                        	 if(data == "Loginname is incorrect") { 
		        		                                 alert(data);}
			                                   });   // post
				return false;
              });   //  submit
}


function L_U_D()
{
    $("#unlock_user").click(function()	
						{			   	                  
					        $.post("manageUsersForm.php",{ Username:$('#Uusername').val(),log:$("#manageUser_log").val(),flag:3},
					        		function(data)
     		                       {
					        	       if(data == 0)
					        	    	   {
					        	    	       var d = new Date(year, month, day, hours, minutes);
					        	    	       var old_comment = $("#manageUser_log").val();
					        	    	       var new_comment = old_comment + "\nUpdateLock" + d;
					        	    	       $("#manageUser_log").val(new_comment);
					        	    	   }
					        	       else{alert("Fail to unlock user...")}
					             });  // post
					       // return false;
                       });     // submit
   
    $("#lock_user").click(function()	
			{   	
		        $.post("manageUsersForm.php",{ Username:$('#Uusername').val(),log:$("#manageUser_log").val(),flag:3},
		        		function(data)
	                       {
		        	       if(data == 0)
		        	    	   {
		        	    	       var d = new Date(year, month, day, hours, minutes);
		        	    	       var old_comment = $("#manageUser_log").val();
		        	    	       var new_comment = old_comment + "\nUpdateLock" + d;
		        	    	       $("#manageUser_log").val(new_comment);
		        	    	   }
		        	       else{alert("Fail to lock user...")}
		                });    // post
		      //  return false;
           });    // submit
    $("#lock_user").click(function()	
			{   	        
		        $.post("manageUsersForm.php",{ Username:$('#Uusername').val(),log:$("#manageUser_log").val(),flag:4},
		        		function(data)
	                       {
		        	       if(data == 0)
		        	    	   {
		        	    	       var d = new Date(year, month, day, hours, minutes);
		        	    	       var old_comment = $("#manageUser_log").val();
		        	    	       var new_comment = old_comment + "\nUser Deleted" + d;
		        	    	       $("#manageUser_log").val(new_comment);
		        	    	   }		        	       
		                });     // post
		     //   return false;
           });    // submit
}     //  L_U_D()
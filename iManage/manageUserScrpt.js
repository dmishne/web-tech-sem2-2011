	
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
		                    	    		 $("#UFirstName").val(value);
		                    	    		 break;
		                    	    	 case 'lastName':
		                    	    		 $("#ULastName").val(value);
		                    	    		 break;
		                    	    	 case 'dateOfBirth':
		                    	    		 $("#UBirthDate").val(value);
		                    	    		 break;
		                    	    	 case 'email':
		                    	    		 $("#UMail").val(value);
		                    	    		 break;
		                    	    	 case 'name':
		                    	    		 $("#UStatusSelector").val(value);
		                    	    	 case 'statusChangeComment':
		                    	    		 $("#manageUser_log").val(value);
		                    	    	 case 'statusId':
		                    	    		 if(value == 1)
		                    	    			 {
		                    	    			 $("#unlock_user").css('color','green');
		                    	    			 $("#unlock_user").val("User Unlocked");
		                    	    			 $("#lock_user").val("Lock User");
		                    	    			 $("#lock_user").css('color','#d9eef7');
		                    	    			 $("#uStatus").hide();
		                    	    			 $("#message").val("");
		                    	    			 $("#delete_user").attr('disabled', false);
		                    	    			 }
		                    	    		 else if(value == 2)
		                    	    			 {
		                    	    			 $("#lock_user").css('color','red');
		                    	    			 $("#lock_user").val("User Locked");
		                    	    			 $("#unlock_user").val("Unlock User");
		                    	    			 $("#unlock_user").css('color','#d9eef7');
		                    	    			 $("#uStatus").show();
		                    	    			 $("#message1").show();
		                    	    			 $("#message2").hide();
		                    	    			 $("#delete_user").attr('disabled', false);
		                    	    			 }
		                    	    		 else if(value == 3)
		                    	    			 {
		                    	    			 $("#uStatus").show();
		                    	    			 $("#message2").show();
		                    	    			 $("#message1").hide();
		                    	    			 $("#delete_user").attr('disabled', true);
		                    	    			 }
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
		      // alert($('#UFirstName').val());
				$.post("manageUsersForm.php",{ Username:$('#Uusername').val(),
											   FName:$('#UFirstName').val(),
											   LName:$('#ULastName').val(),
											   BD:$('#UBirthDate').val(),
											   Status:$('#UStatusSelector').val(),
											   EmailAdd:$('#UMail').val(),
					                           flag:2},
		        		                       function(data)
		        		                       {
					                        	 if(data != "Edit fail") { 
					                        		 $(function() {					        	    			
								        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
								        	    			$( "#UEditSucc" ).dialog({
								        	    				modal: true,
								        	    				buttons: {
								        	    					Ok: function() {
								        	    						$( this ).dialog( "close" );
								        	    					}
								        	    				}
								        	    			});
								        	    		});
                                                   }
					                        	 else if(data == "Edit fail")
					                        		 {
					                        		 $(function() {					        	    			
								        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
								        	    			$( "#UEditFail" ).dialog({
								        	    				modal: true,
								        	    				buttons: {
								        	    					Ok: function() {
								        	    						$( this ).dialog( "close" );
								        	    					}
								        	    				}
								        	    			});
								        	    		});					                        		 
					                        		 }
			                                   });   // post
				return false;
				$('#search_username').val($('#Uusername').val());  // set search field to new username
				$("#manageUser_search").submit();
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
					        $('#search_username').val($('#Uusername').val());  // set search field to new username
					        $("#manageUser_search").trigger('submit');
                       });     // click
   
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
		        $('#search_username').val($('#Uusername').val());  // set search field to new username
		        $("#manageUser_search").trigger('submit');
           });    // click
    $("#delete_user").click(function()	
			{   	 
			    	$( "#dialog:ui-dialog" ).dialog( "destroy" );			    	
					$( "#delete-confirm" ).dialog({
						resizable: false,
						height:180,
						modal: true,
						buttons: {
							"Yes": function() {
									$.post("manageUsersForm.php",{ Username:$('#Uusername').val(),flag:4},
							        		function(data)
						                       {
							        	       if(data == "deleted")
							        	    	   {
							        	    	   $(function() {					        	    			
							        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
							        	    			$( "#Udeleted" ).dialog({
							        	    				modal: true,
							        	    				buttons: {
							        	    					Ok: function() {
							        	    						$( this ).dialog( "close" );
							        	    					}
							        	    				}
							        	    			});
							        	    		});
							        	    	   }
							        	       else if(data == "fail"){
							        	    	   $(function() {					        	    			
							        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
							        	    			$( "#Udeletefail" ).dialog({
							        	    				modal: true,
							        	    				buttons: {
							        	    					Ok: function() {
							        	    						$( this ).dialog( "close" );
							        	    					}
							        	    				}
							        	    			});
							        	    		});
							        	       }
							        	      $("#data_div").fadeOut(2000);
					                 	      $("#buttons_div").fadeOut(1500);
					                 	      $("#mail_div").fadeOut(1000);
					                 	      $("#uStatus").hide();
							                });     // post
								
								$( this ).dialog( "close" );
							},
							Cancel: function() {
								$( this ).dialog( "close" );
							}
						}
					});
				           	        	
    	        $('#search_username').val($('#Uusername').val());  // set search field to new username
    	        $("#manageUser_search").trigger('submit');
           });    // click
}     //  L_U_D()

function eMail()
{
	$("#sendMail").click(function()	
			{			
		        $.post("manageUsersForm.php",{ MailAddress:$("#UMail").val(),MailSubject:$("#Mail_subject").val(),MailBody:$("#mailBody").val(),flag:5},
		        		function(data)
	                       {
		        	       if(data == "sended")
		        	    	   {
		        	    	   $(function() {					        	    			
		        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
		        	    			$( "#mailSended" ).dialog({
		        	    				modal: true,
		        	    				buttons: {
		        	    					Ok: function() {
		        	    						$( this ).dialog( "close" );
		        	    					}
		        	    				}
		        	    			});
		        	    		});
		        	    	   }
		        	       else if(data == "fail")
		        	    	   {
		        	    	   $(function() {					        	    			
		        	    			$( "#dialog:ui-dialog" ).dialog( "destroy" );							        	    		
		        	    			$( "#mailNotSended" ).dialog({
		        	    				modal: true,
		        	    				buttons: {
		        	    					Ok: function() {
		        	    						$( this ).dialog( "close" );
		        	    					}
		        	    				}
		        	    			});
		        	    		});
		        	    	   }
		        	       });  // post
			});     // click
}
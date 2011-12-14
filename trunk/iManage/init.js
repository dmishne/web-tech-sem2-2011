function setLogin()
{
	$("#login_form").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#msgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("loginVerifier.php",{ username:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#msgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='index.php';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Your login information incorrect...').addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
}


function initCalendar(toLocation)
{
	$("#CalLeft").click(function()
	{
		$.mon_year.month = $.mon_year.month - 1;
		if($.mon_year.month == 0) { $.mon_year.month = 12; $.mon_year.year--;}
		document.location = toLocation + '?year=' + $.mon_year.year + '&month=' + $.mon_year.month;
	});
	
	$("#CalRight").click(function()
	{
		$.mon_year.month = $.mon_year.month + 1;
		if($.mon_year.month == 13) {$.mon_year.month = 1; $.mon_year.year++;}
		document.location = toLocation + '?year=' + $.mon_year.year + '&month=' + $.mon_year.month;
	});
}
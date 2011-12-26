function slidetgl()
{
	 $("#frst").click(function(){
		$(".panel1").slideToggle("slow");
		$(".line1").is(":visible")?$(".line1").hide():$(".line1").show();
		var src = ($("#1a").attr("src") === "images/arrows_down.png")
        ? "images/arrows_up.png" 
        : "images/arrows_down.png";
		$("#1a").attr("src", src);
	     });
	$("#scnd").click(function(){
        $(".panel2").slideToggle("slow");
        $(".line2").is(":visible")?$(".line2").hide():$(".line2").show();
        var src = ($("#2a").attr("src") === "images/arrows_down.png")
        ? "images/arrows_up.png" 
        : "images/arrows_down.png";
            $("#2a").attr("src", src);
         });
	$("#thrd").click(function(){
        $(".panel3").slideToggle("slow");
        $(".line3").is(":visible")?$(".line3").hide():$(".line3").show();
        var src = ($("#3a").attr("src") === "images/arrows_down.png")
        ? "images/arrows_up.png" 
        : "images/arrows_down.png";
            $("#3a").attr("src", src);
         });
}



function rDayWageTotal(){
		var sh = document.getElementById("rsh").value;
		var eh = document.getElementById("reh").value;
		var sm = document.getElementById("rsm").value;
		var em = document.getElementById("rem").value;
		var rw=document.getElementById("jobwage").value;
	if(sh && eh && sm && em && rw)
	{
		var dh = eh - sh;
		var dm = em - sm;
		if(dh < 0)
			dh=24+dh;
		else if(dh == 0 && dm < 0)
			dh=24;
		if(isNaN(rw)){
			alert("Invalid wage value!");	
			document.getElementById("rwpd").value= 0;
		}
		dm=(dm*100)/6000;
		           document.getElementById("rwt").value= ((dh*rw)+(dm*rw)).toFixed(2);
	}
}


function updtWorkinfo(id){     
	if(id == "otislct"){
		var sel = document.getElementById(id);
		var op = sel.options[sel.selectedIndex].value;
		var selectObj = document.getElementById(id);  // <select> object
	    var idx = selectObj.selectedIndex-1;   // selected index - New(index)
		if(op == "New" && (document.getElementById("name3").value) != null){
			document.getElementById("name3").value = '';
		    document.getElementById("amount3").value = '';
		    document.getElementById("desc3").value = '';
		}
		else {
		    document.getElementById("name3").value = onetimetable[idx]['transname'];
		    document.getElementById("amount3").value = onetimetable[idx]['amount'];
		    document.getElementById("desc3").value = onetimetable[idx]['description'];
		}
	}
	else if(id == "rtinc")
	{		
		var sel = document.getElementById(id);
		var op = sel.options[sel.selectedIndex].value;
		var selectObj = document.getElementById(id);   // <select> object
	    var idx = selectObj.selectedIndex-1;   // selected index - New(index)
		if(op == "New" && (document.getElementById("name2").value) != null){
			document.getElementById("name2").value = '';
		    document.getElementById("amount2").value = '';
		    document.getElementById("desc2").value = '';
		    document.getElementById("rslct").selectedIndex = 0;
		    document.getElementById("updtperiodl").style.display="none";
		    document.getElementById("updtperiod").style.display="none";
		    document.getElementById("firstDate").style.display="table-row";
		    document.getElementById("secondDate").style.display="none";
		    
		}
		else {
		    document.getElementById("name2").value = rectable[idx]['recname'];
		    document.getElementById("amount2").value = rectable[idx]['amount'];
		    document.getElementById("desc2").value = rectable[idx]['description'];
		    document.getElementById("updtperiodl").style.display="table-cell";
		    document.getElementById("updtperiod").style.display="table-cell";
		    document.getElementById("firstDate").style.display="none";
		    document.getElementById("secondDate").style.display="table-row";
		    rtype = rectable[idx]['recType'];
		    switch (rtype)
		    {
			    case '10':
			    	document.getElementById("rslct").selectedIndex = 0;
			    	break;
			    case '1':
			    	document.getElementById("rslct").selectedIndex = 1;
			    	break;
			    case '2':
			    	document.getElementById("rslct").selectedIndex = 2;
			    	break;
			    case '4':
			    	document.getElementById("rslct").selectedIndex = 3;
			    	break;
			    case '8':
			    	document.getElementById("rslct").selectedIndex = 4;
			    	break;
		     }
		}
	}
	else if(id == "uwi")
	{
		var selectObj = document.getElementById(id);  // <select> object
	    var idx = selectObj.selectedIndex;   // selected index
	    if(idx != 0){
	        idx--;      // idx 0 of select is empty
		    document.getElementById("wname").value = jobtable[idx]['name'];
		    document.getElementById("jobwage").value = jobtable[idx]['wage'];
		    document.getElementById("wday").value = jobtable[idx]['incomeDate'].substring(8,10);
        	document.getElementById("wmonth").value = jobtable[idx]['incomeDate'].substring(5,7);
        	document.getElementById("wyear").value = jobtable[idx]['incomeDate'].substring(0,4);
        	$("#workerr").hide();
        	$("#allerr").hide();
	    }
	    else if (idx == 0){
	    	document.getElementById("wname").value = '';
		    document.getElementById("jobwage").value = '';
		    document.getElementById("wday").value = '';
        	document.getElementById("wmonth").value = '';
        	document.getElementById("wyear").value = '';
	    }
	    var j = 0;	
	    while(j < htable.length && jobtable[idx]['name'] != htable[j]['transname'])
	    {		    	
	    	j++;
	    	
	    }
	    if(j == htable.length )
	    {		
	    	document.getElementById("rsh").value = '';	
			document.getElementById("rsm").value = '';	
		    document.getElementById("reh").value = '';	
		    document.getElementById("rem").value = '';
		    document.getElementById("rwt").value = '';
        }
        else
    	{	 
        	//alert(htable[j]['startHour']);
		    document.getElementById("rsh").value = htable[j]['startHour'].substring(11,13);	
			document.getElementById("rsm").value = htable[j]['startHour'].substring(14,16);	
		    document.getElementById("reh").value = htable[j]['endHour'].substring(11,13);	
		    document.getElementById("rem").value = htable[j]['endHour'].substring(14,16);
		    $('#jobwage').trigger('change');
    	}
	}
	
	else if(id == "rtpay")
	{		
		var sel = document.getElementById(id);
		var op = sel.options[sel.selectedIndex].value;
		var selectObj = document.getElementById(id);   // <select> object
	    var idx = selectObj.selectedIndex-1;   // selected index - New(index)
		if(op == "New" && (document.getElementById("pname2").value) != null){
			document.getElementById("pname2").value = '';
		    document.getElementById("pamount2").value = '';
		    document.getElementById("pdesc2").value = '';
		    document.getElementById("prslct").selectedIndex = 0;
		    document.getElementById("pupdtperiodl").style.display="none";
		    document.getElementById("pupdtperiod").style.display="none";
		    document.getElementById("pfirstDate").style.display="table-row";
		    document.getElementById("psecondDate").style.display="none";
		    document.getElementById("pemail").checked = false;
		}
		else {
		    document.getElementById("pname2").value = prectable[idx]['recname'];
		    document.getElementById("pamount2").value = prectable[idx]['amount'];
		    document.getElementById("pdesc2").value = prectable[idx]['description'];
		    document.getElementById("pupdtperiodl").style.display="table-cell";
		    document.getElementById("pupdtperiod").style.display="table-cell";
		    document.getElementById("pfirstDate").style.display="none";
		    document.getElementById("psecondDate").style.display="table-row";
		    rtype = prectable[idx]['recType'];
		    switch (rtype)
		    {
			    case '10':
			    	document.getElementById("prslct").selectedIndex = 0;
			    	break;
			    case '1':
			    	document.getElementById("prslct").selectedIndex = 1;
			    	break;
			    case '2':
			    	document.getElementById("prslct").selectedIndex = 2;
			    	break;
			    case '4':
			    	document.getElementById("prslct").selectedIndex = 3;
			    	break;
			    case '8':
			    	document.getElementById("prslct").selectedIndex = 4;
			    	break;
		     }
		    if (prectable[idx]["noteDate"] != null)
		    {
		    	document.getElementById("pemail").checked = true;
		    }
		    else{
		    	document.getElementById("pemail").checked = false;
		    }
		   }
	}
}





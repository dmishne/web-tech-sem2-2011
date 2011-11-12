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
	var rh=(document.getElementById("reh").value - document.getElementById("rsh").value);
	var rm=(document.getElementById("rem").value - document.getElementById("rsm").value);
	var rw=document.getElementById("rwpd").value;
	if(rh < 0)
		rh=24+rh;
	else if(rh == 0 && rm < 0)
		rh=24;
	if(isNaN(rw)){
		alert("Invalid wage value!");	
		document.getElementById("rwpd").value= 0;
	}
	rm=(rm*100)/6000;
	           document.getElementById("rwt").value= ((rh*rw)+(rm*rw)).toFixed(2);
}


function updtWorkinfo(id,name,amount,desc,rtype){     
	
	if(id == "otislct"){
	    document.getElementById("name3").value = name;
	    document.getElementById("amount3").value = amount;
	    document.getElementById("desc3").value = desc;
	}
	else if(id == "rtinc")
	{
	    document.getElementById("name2").value = name;
	    document.getElementById("amount2").value = amount;
	    document.getElementById("desc2").value = desc;
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

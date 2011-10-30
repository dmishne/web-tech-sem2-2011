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

function oDayWageTotal(){
	var h=(document.getElementById("oeh").value - document.getElementById("osh").value);
	var m=(document.getElementById("oem").value - document.getElementById("osm").value);
	var w=document.getElementById("owpd").value;
	if(h < 0)
		h=24+h;
	else if(h == 0 && m < 0)
		h=24;
	if(isNaN(w)){
		alert("Invalid wage value!");
		document.getElementById("owpd").value= 0;
	}
	m=(m*100)/6000;
	           document.getElementById("owt").value= ((h*w)+(m*w)).toFixed(2);
}



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
	$("#frth").click(function(){
        $(".panel4").slideToggle("slow");
        $(".line4").is(":visible")?$(".line4").hide():$(".line4").show();
        var src = ($("#4a").attr("src") === "images/arrows_down.png")
        ? "images/arrows_up.png" 
        : "images/arrows_down.png";
            $("#4a").attr("src", src);
         });
}

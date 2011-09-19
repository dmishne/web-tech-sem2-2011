function setMenu()
{
	$('li.toggleable').click(function()
	{
		var t_ul = $(this).find("ul");
		t_ul.slideToggle('medium');
		if($(this).hasClass("menuActive")) {
			$(this).removeClass("menuActive");
			$(this).addClass("menuInactive");
			$.cookie(t_ul.attr('id'),'collapsed');
		}
		else {
			$(this).removeClass("menuInactive");
			$(this).addClass("menuActive");
			$.cookie(t_ul.attr('id'),'expanded');
		}
	});
	
	$('li.toggleable').addClass("menuInactive");
	$('li.toggleable').find("ul li").click(function(e) {e.stopPropagation();});
	$('li.toggleable').find("ul").each(function() {
		if( ($.cookie($(this).attr('id'))) == null)
		{
			$.cookie($(this).attr('id'),'collapsed');
		}
		else{
			if($.cookie($(this).attr('id')) == 'expanded' ){
				$(this).show();
				$(this).parent().removeClass("menuInactive");
				$(this).parent().addClass("menuActive");
			}
		}
	});
}
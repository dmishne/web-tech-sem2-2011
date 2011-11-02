function collapseLst(lst)
{   
   document.getElementById(lst).style.display = 
	      (document.getElementById(lst).style.display=='none')?
	      'block':'none';
}

function chngimg(img){
	var src = ($(img).attr("src") === "images/chooserexpand.png")
	   ? "images/choosercollapse.png" 
	   : "images/chooserexpand.png";
	       $(img).attr("src", src);
}

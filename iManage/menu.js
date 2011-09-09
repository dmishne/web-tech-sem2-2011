/*
 * function toggleMenu
 * function should recieve an object of <li> with <ul> under its structure.
 */
function toggleMenu(obj)
{
	var ulobj = obj.getElementsByTagName("ul")[0];
	ulobj.style.display = (ulobj.style.display == 'block')?'none': 'block';
	obj.style.listStyleImage = (ulobj.style.display == 'block')?"url('images/downArrow.png')":"url('images/rightArrow.png')";
}
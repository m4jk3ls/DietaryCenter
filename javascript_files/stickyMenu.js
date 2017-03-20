$(document).ready(function ()
{
	var NavY = $('.menu').offset().top;
	var stickyNav = function ()
	{
		var ScrollY = $(window).scrollTop();
		if(ScrollY > NavY)
			$('.menu').addClass('sticky');
		else
			$('.menu').removeClass('sticky');
	};
	try
	{
		stickyNav();
	}
	catch(e)
	{
		alert(e.message);
	}

	$(window).scroll(function ()
	{
		try
		{
			stickyNav();
		}
		catch(e)
		{
			alert(e.message);
		}
	});
});
$(document).ready(function ()
{
	var headline = $("#headline");
	var headerHalfHeight = headline.innerHeight() / 2;

	if($("#" + "logInForm").length > 0)
	{
		// Pobranie rozmiaru formularza logowania (lf) i ustawienie odpowiedniego marginesu w arkuszu CSS
		var lf = $("#logInForm");
		var lfHalfWidth = lf.innerWidth() / 2;
		var lfHalfHeight = lf.innerHeight() / 2;
		var lfMarginValue = (-lfHalfHeight) + "px" + " 0 0 " + (-lfHalfWidth) + "px";
		lf.css("margin", lfMarginValue);

		// Pobranie rozmiaru naglowka i ustawienie go w polowie drogi, miedzy gorna krawedzia okna a formularzem logowania
		var lfTopValue = "calc((50% - " + lfHalfHeight + "px) / 2 - " + headerHalfHeight + "px)";
		headline.css("top", lfTopValue);
	}
	else if($("#" + "signInForm").length > 0)
	{
		// Pobranie rozmiaru formularza rejestracji (sf) i ustawienie odpowiedniego marginesu w arkuszu CSS
		var sf = $("#signInForm");
		var sfHalfWidth = sf.innerWidth() / 2;
		var sfHalfHeight = (sf.innerHeight()) / 2;
		var sfMarginValue = (-sfHalfHeight) + "px" + " 0 0 " + (-sfHalfWidth) + "px";
		sf.css("margin", sfMarginValue);

		// Pobranie rozmiaru naglowka i ustawienie go w polowie drogi, miedzy gorna krawedzia okna a formularzem rejestracji
		var sfTopValue = "calc((50% - " + sfHalfHeight + "px) / 2 - " + headerHalfHeight + "px)";
		headline.css("top", sfTopValue);
	}
	// Jezeli nie ma na stronie zadnego z formularzy, to ustaw naglowek na srodku strony (welcome.php)
	else
	{
		var headlineHalfWidth = headline.innerWidth() / 2;
		headline.css({"margin-top": "-" + headerHalfHeight + "px", "margin-left": "-" + headlineHalfWidth + "px"});
	}
});
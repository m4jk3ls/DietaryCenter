$(document).ready(function ()
{
	var headline = $("#headline");
	var headlineHalfHeight = headline.innerHeight() / 2;

	if($("#" + "logInForm").length > 0)
	{
		// Pobranie rozmiaru formularza logowania (lf) i ustawienie odpowiedniego marginesu w arkuszu CSS
		var lf = $("#logInForm");
		var lfHalfHeight = lf.innerHeight() / 2;

		// Pobranie rozmiaru naglowka i ustawienie go w polowie drogi, miedzy gorna krawedzia okna a formularzem logowania
		var lfTopValue = "calc((50% - " + lfHalfHeight + "px) / 2 - " + headlineHalfHeight + "px)";
		headline.css("top", lfTopValue);
	}
	else if($("#" + "signInForm").length > 0)
	{
		// Pobranie rozmiaru formularza rejestracji (sf) i ustawienie odpowiedniego marginesu w arkuszu CSS
		var sf = $("#signInForm");
		var sfHalfHeight = (sf.innerHeight()) / 2;

		// Pobranie rozmiaru naglowka i ustawienie go w polowie drogi, miedzy gorna krawedzia okna a formularzem rejestracji
		var sfTopValue = "calc((50% - " + sfHalfHeight + "px) / 2 - " + headlineHalfHeight + "px)";
		headline.css("top", sfTopValue);
	}
});
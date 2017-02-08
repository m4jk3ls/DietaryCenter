$(document).ready(function()
{
	var header = $("#header");
	var header_half_height = header.outerHeight()/2;

	if ($("#" + "log_form").length > 0)
	{
		// Get #log_form (lf) size and set "margin" property in CSS
		var lf = $("#log_form");
		var lf_half_width = lf.outerWidth()/2;
		var lf_half_height = lf.outerHeight()/2;
		var lf_value = (-lf_half_height) + "px" + " 0 0 " + (-lf_half_width) + "px";
		lf.css("margin", lf_value);

		// Get #header size and set half position between browser window and #log_form
		var lf_header_value = "calc((50% - " + lf_half_height + "px)/2 - " + header_half_height + "px)";
		header.css("top", lf_header_value);
	}
	else if($("#" + "sign_form").length > 0)
	{
		// Get #sign_form (sf) size and set "margin" property in CSS
		var sf = $("#sign_form");
		var sf_half_width = sf.outerWidth()/2;
		var sf_half_height = (sf.outerHeight()+78)/2;	//+78 in view of problem with img's (in this case: re-captcha)
		var sf_value = (-sf_half_height) + "px" + " 0 0 " + (-sf_half_width) + "px";
		sf.css("margin", sf_value);

		// Get #header size and set half position between browser window and #sign_form
		var sf_header_value = "calc((50% - " + sf_half_height + "px)/2 - " + header_half_height + "px)";
		header.css("top", sf_header_value);
	}
	else
	{
		var header_half_width = header.outerWidth()/2;
		header.css({"margin-top": "-" + header_half_height + "px", "margin-left": "-" + header_half_width + "px"});
	}
});
$(document).ready(function()
{
	// Get #log_form size and set "margin" property in CSS
	var log_form = $("#log_form");
	var log_form_half_width = log_form.outerWidth()/2;
	var log_form_half_height = log_form.outerHeight()/2;
	var log_form_property = "margin";
	var log_form_value = (-log_form_half_height) + "px" + " 0 0 " + (-log_form_half_width) + "px";
	log_form.css(log_form_property, log_form_value);

	// Get #header size and set half position between browser window and #log_form
	var header = $("#header");
	var header_half_height = header.outerHeight()/2;
	var header_property = "top";
	var header_value = "calc((50% - " + log_form_half_height + "px)/2 - " + header_half_height + "px)";
	header.css(header_property, header_value);
});
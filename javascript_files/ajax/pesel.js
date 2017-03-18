jQuery(document).ready(function ()
{
	$("#peselID").on("blur", function ()
	{
		var peselValue = $('input[name = pesel]').val();
		var errorAfterSubmitLength = $("#pesel_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "phpForAjax/pesel.php",
				type: "POST",
				data: "pesel=" + peselValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#peselError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#pesel_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#peselError").text("").css("margin-top", "0");
				}
			});
	});
});
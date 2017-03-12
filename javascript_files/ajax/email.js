jQuery(document).ready(function ()
{
	$("#emailID").on("blur", function ()
	{
		var emailValue = $('input[name = email]').val();
		var errorAfterSubmitLength = $("#email_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "phpForAjax/signIn_email.php",
				type: "POST",
				data: "email=" + emailValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#emailError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#email_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#emailError").text("").css("margin-top", "0");
				}
			});
	});
});
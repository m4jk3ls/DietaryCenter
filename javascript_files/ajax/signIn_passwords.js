jQuery(document).ready(function ()
{
	$("#passwd2ID").on("blur", function ()
	{
		var passwd1Value = $('input[name = passwd1]').val();
		var passwd2Value = $('input[name = passwd2]').val();
		var errorAfterSubmitLength = $("#passwd_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "ajaxValidation/signIn_passwords.php",
				type: "POST",
				data: "passwd1=" + passwd1Value + "&" + "passwd2=" + passwd2Value,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#passwdError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#passwd_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#passwdError").text("").css("margin-top", "0");
				}
			});
	});
});
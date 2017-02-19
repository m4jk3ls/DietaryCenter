jQuery(document).ready(function ()
{
	$("#passwdID").on("blur", function ()
	{
		var passwdValue = $('input[name = passwd]').val();
		var errorAfterSubmitLength = $("#errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "ajaxValidation/logIn_password.php",
				type: "POST",
				data: "passwd=" + passwdValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#passwdError").text(msg).css("margin-top", "10px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#passwdError").text("").css("margin-top", "0");
				}
			});
	});
});
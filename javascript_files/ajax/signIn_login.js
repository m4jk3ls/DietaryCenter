jQuery(document).ready(function ()
{
	$("#loginID").on("blur", function ()
	{
		var loginValue = $('input[name = login]').val();
		var errorAfterSubmitLength = $("#login_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "phpForAjax/signIn_login.php",
				type: "POST",
				data: "login=" + loginValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#loginError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#login_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#loginError").text("").css("margin-top", "0");
				}
			});
	});
});
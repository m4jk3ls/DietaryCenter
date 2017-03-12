jQuery(document).ready(function ()
{
	$("#loginID").on("blur", function ()
	{
		var loginValue = $('input[name = login]').val();
		var errorAfterSubmitLength = $("#errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "phpForAjax/logIn_login.php",
				type: "POST",
				data: "login=" + loginValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#loginError").text(msg).css("margin-top", "10px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#loginError").text("").css("margin-top", "0");
				}
			});
	});
});
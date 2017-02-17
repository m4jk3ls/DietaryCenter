jQuery(document).ready(function ()
{
	$("#login_id").on("blur", function ()
	{
		var login_value = $('input[name = login]').val();

		$.ajax(
			{
				url: "ajaxValidation/signIn_login.php",
				type: "POST",
				data: "login=" + login_value,
				success: function (msg)
				{
					if (msg != "")
						$("#komunikat3").text(msg).css("margin-top", "5px");
					else
						$("#komunikat3").text(msg).css("margin-top", "0");
				}
			});
	});
});
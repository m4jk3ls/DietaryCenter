jQuery(document).ready(function()
{
	$("#email_id").on("blur", function()
	{
		var login_value = $('input[name = email]').val();

		$.ajax(
			{
				url: "ajaxValidation/rejestracja_email.php",
				type: "POST",
				data: "email="+login_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat4").text(msg).css("margin-top", "5px");
					else
						$("#komunikat4").text(msg).css("margin-top", "0");
				}
			});
	});
});
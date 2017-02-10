jQuery(document).ready(function()
{
	$("#pass").on("blur", function()
	{
		var passwd_value = $('input[name = haslo]').val();

		$.ajax(
			{
				url: "ajaxValidation/index_password.php",
				type: "POST",
				data: "haslo="+passwd_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat2").text(msg).css("margin-top", "10px");
					else
						$("#komunikat2").text(msg).css("margin-top", "0");
				}
			});
	});
});
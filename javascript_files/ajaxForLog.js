jQuery(document).ready(function()
{
	$("#log").on("blur", function()
	{
		var login_value = $('input[name = login]').val();

		$.ajax(
			{
				url: "ajaxValidation/index_login.php",
				type: "POST",
				data: "login="+login_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat1").text(msg).css("margin-top", "10px");
					else
						$("#komunikat1").text(msg).css("margin-top", "0");
				}
			});
	});
});
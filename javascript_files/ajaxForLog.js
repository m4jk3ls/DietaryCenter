jQuery(document).ready(function()
{
	$("#log").on("blur", function()
	{
		var login_value = $('input[name = login]').val();

		$.ajax(
			{
				url: "index_login_ajax.php",
				type: "POST",
				data: "login="+login_value,
				success: function(msg)
				{
					if(msg != "")
						$(".komunikat").text(msg).css("margin-top", "10px");
					else
						$(".komunikat").text(msg).css("margin-top", "0");
				}
			});
	});
});
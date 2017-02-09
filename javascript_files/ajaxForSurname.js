jQuery(document).ready(function()
{
	$("#nazwisko_id").on("blur", function()
	{
		var login_value = $('input[name = nazwisko]').val();

		$.ajax(
			{
				url: "ajaxValidation/rejestracja_nazwisko.php",
				type: "POST",
				data: "nazwisko="+login_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat2").text(msg).css("margin-top", "5px");
					else
						$("#komunikat2").text(msg).css("margin-top", "0");
				}
			});
	});
});
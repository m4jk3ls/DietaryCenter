jQuery(document).ready(function()
{
	$("#imie_id").on("blur", function()
	{
		var login_value = $('input[name = imie]').val();

		$.ajax(
			{
				url: "ajaxValidation/rejestracja_imie.php",
				type: "POST",
				data: "imie="+login_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat1").text(msg).css("margin-top", "5px");
					else
						$("#komunikat1").text(msg).css("margin-top", "0");
				}
			});
	});
});
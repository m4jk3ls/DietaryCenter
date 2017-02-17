jQuery(document).ready(function ()
{
	$("#imie_id").on("blur", function ()
	{
		var name_value = $('input[name = imie]').val();

		$.ajax(
			{
				url: "ajaxValidation/signIn_firstName.php",
				type: "POST",
				data: "imie=" + name_value,
				success: function (msg)
				{
					if (msg != "")
						$("#komunikat1").text(msg).css("margin-top", "5px");
					else
						$("#komunikat1").text(msg).css("margin-top", "0");
				}
			});
	});
});
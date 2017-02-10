jQuery(document).ready(function()
{
	$("#passwd2").on("blur", function()
	{
		var passwd1_value = $('input[name = haslo1]').val();
		var passwd2_value = $('input[name = haslo2]').val();

		$.ajax(
			{
				url: "ajaxValidation/rejestracja_hasla.php",
				type: "POST",
				data: "passwd1="+passwd1_value+"&"+"passwd2="+passwd2_value,
				success: function(msg)
				{
					if(msg != "")
						$("#komunikat5").text(msg).css("margin-top", "5px");
					else
						$("#komunikat5").text(msg).css("margin-top", "0");
				}
			});
	});
});
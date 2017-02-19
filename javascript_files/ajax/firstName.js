jQuery(document).ready(function ()
{
	$("#firstNameID").on("blur", function ()
	{
		var nameValue = $('input[name = firstName]').val();
		var errorAfterSubmitLength = $("#firstName_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "ajaxValidation/signIn_firstName.php",
				type: "POST",
				data: "firstName=" + nameValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#firstNameError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#firstName_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#firstNameError").text("").css("margin-top", "0");
				}
			});
	});
});
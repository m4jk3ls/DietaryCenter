jQuery(document).ready(function ()
{
	$("#lastNameID").on("blur", function ()
	{
		var lastNameValue = $('input[name = lastName]').val();
		var errorAfterSubmitLength = $("#lastName_errorAfterSubmit").text().length;

		$.ajax(
			{
				url: "ajaxValidation/signIn_lastName.php",
				type: "POST",
				data: "lastName=" + lastNameValue,
				success: function (msg)
				{
					if(errorAfterSubmitLength == "" && msg != "")
						$("#lastNameError").text(msg).css("margin-top", "5px");
					else if(errorAfterSubmitLength != "" && msg == "")
						$("#lastName_errorAfterSubmit").text("").css("margin-top", "0");
					else if(msg == "")
						$("#lastNameError").text("").css("margin-top", "0");
				}
			});
	});
});
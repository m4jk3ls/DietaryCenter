jQuery(document).ready(function ()
{
	$(".removingButton").on('click', function ()
	{
		$.ajax(
			{
				url: "phpForAjax/removeUser.php",
				type: "POST",
				data: "login=" + $(this).val(),
				success: function (msg)
				{
					if(msg == "refresh")
						window.location.reload();
				}
			});
	});
});
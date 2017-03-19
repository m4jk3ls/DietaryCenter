jQuery(document).ready(function ()
{
	$("#haveALook").on('click', function ()
	{
		var userID = $("#haveALook").val();
		var year = $("select[name=year]").val();
		var month = $("select[name=month]").val();
		var day = $("select[name=day]").val();

		$.ajax(
			{
				url: "phpForAjax/showDieticianVisits.php",
				type: "POST",
				data: "userID=" + userID + "&" + "year=" + year + "&" + "month=" + month + "&" + "day=" + day,
				success: function (msg)
				{
					if(msg == "Podaj poprawną datę!")
						$("#error").text(msg).css("margin-top", "5px");
					else
						$("#content").html(msg);
				}
			});
	});
});
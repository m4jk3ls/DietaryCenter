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
					$("#content").html(msg);
				}
			});
	});
});
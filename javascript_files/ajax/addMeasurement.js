jQuery(document).ready(function ()
{
	$("#saveMeasurement").on('click', function ()
	{
		var patientID = $("#saveMeasurement").val();
		var bodyMass = $("select[name=bodyMass]").val();
		var fat = $("select[name=fat]").val();
		var water = $("select[name=water]").val();
		var height = $("select[name=height]").val();

		$.ajax(
			{
				url: "phpForAjax/addMeasurement.php",
				type: "POST",
				data: "patientID=" + patientID + "&" + "bodyMass=" + bodyMass + "&" + "fat=" + fat + "&" + "water=" + water + "&" + "height=" + height,
				success: function (msg)
				{
					if(msg == "Wprowadź wszystkie pomiary!")
						$("#error").text(msg).css("margin-top", "10px");
					else if(msg == "Zapisane!")
						location.href = "html_files/measurementsSaved.html";
					else
						$("#content").html(msg);
				}
			});
	});
});
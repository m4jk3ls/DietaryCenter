jQuery(document).ready(function ()
{
	var selectWithHours = $("select[name=hoursToChoice]");

	(function($)
	{
		$.fn.deactivate = function()
		{
			selectWithHours.append($('<option>',
				{
					value: "Wybierz termin",
					text: "Wybierz termin"
				}));
			selectWithHours.prop("disabled", true);
		};
	})(jQuery);

	selectWithHours.empty();
	selectWithHours.deactivate();

	$("select[name=daysToChoose]").on('change', function ()
	{
		var selectedDate = $(this).val();
		$.ajax(
			{
				url: "phpForAjax/freeHours.php",
				type: "POST",
				data: "date=" + selectedDate,
				dataType: 'json',
				success: function (array)
				{
					selectWithHours.empty();
					if(array == "---brak---")
						selectWithHours.deactivate();
					else
					{
						selectWithHours.prop("disabled", false);
						for (var i = 0; i < array.length; i++)
						{
							selectWithHours.append($('<option>',
								{
									value: array[i],
									text: array[i]
								}));
						}
					}
				}
			});
	});
});
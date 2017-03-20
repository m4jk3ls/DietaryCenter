jQuery(document).ready(function ()
{
	var selectWithHours = $("select[name=hoursToChoice]");

	(function ($)
	{
		$.fn.chooseDay = function ()
		{
			selectWithHours.append($('<option>',
				{
					value: "Wybierz termin",
					text: "Wybierz termin"
				}));
			selectWithHours.prop("disabled", true);
		};

		$.fn.ThereIsNoHours = function (textToShow)
		{
			selectWithHours.append($('<option>',
				{
					value: textToShow,
					text: textToShow
				}));
			selectWithHours.prop("disabled", true);
		};
	})(jQuery);

	selectWithHours.empty();
	try
	{
		selectWithHours.chooseDay();
	}
	catch(e)
	{
		alert(e.message);
	}

	$("select[name=daysToChoose]").on('change', function ()
	{
		var selectedDate = $(this).val();
		$.ajax(
			{
				url: "phpForAjax/freeHours.php",
				type: "POST",
				data: "date=" + selectedDate,
				dataType: 'json',
				success: function (msg)
				{
					selectWithHours.empty();

					if(msg == "Termin")
					{
						try
						{
							selectWithHours.chooseDay();
						}
						catch(e)
						{
							alert(e.message);
						}
					}
					else if(typeof msg != "string")
					{
						selectWithHours.prop("disabled", false);
						for (var i = 0; i < msg.length; i++)
						{
							selectWithHours.append($('<option>',
								{
									value: msg[i],
									text: msg[i]
								}));
						}
					}
					else
					{
						try
						{
							selectWithHours.ThereIsNoHours();
						}
						catch(e)
						{
							alert(e.message);
						}
					}
				}
			});
	});
});
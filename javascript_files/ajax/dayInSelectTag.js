jQuery(document).ready(function ()
{
	var selectWithYears = $("select[name=year]");
	var selectWithMonths = $("select[name=month]");
	var selectWithDays = $("select[name=day]");

	(function ($)
	{
		$.fn.disableDays = function ()
		{
			selectWithDays.append($('<option>',
				{
					value: "---dzień---",
					text: "---dzień---"
				}));
			selectWithDays.prop("disabled", true);
		};
	})(jQuery);

	var showDays = function ()
	{
		var selectedMonth = selectWithMonths.val();
		var selectedYear = selectWithYears.val();
		$.ajax(
			{
				url: "phpForAjax/dayInSelectTag.php",
				type: "POST",
				data: "year=" + selectedYear + "&" + "month=" + selectedMonth,
				dataType: 'json',
				success: function (msg)
				{
					selectWithDays.empty();

					if(msg == "Nie wybrano daty")
					{
						try
						{
							selectWithDays.disableDays();
						}
						catch(e)
						{
							alert(e.message);
						}
					}
					else if(typeof msg != "string")
					{
						selectWithDays.prop("disabled", false);
						for (var i = 0; i < msg.length; i++)
						{
							if(msg[i] < 10)
								msg[i] = "0" + msg[i];
							selectWithDays.append($('<option>',
								{
									value: msg[i],
									text: msg[i]
								}));
						}
					}
				}
			}
		);
	};

	selectWithDays.empty();
	try
	{
		selectWithDays.disableDays();
	}
	catch(e)
	{
		alert(e.message);
	}

	selectWithMonths.on('change', showDays);
	selectWithYears.on('change', showDays);
});
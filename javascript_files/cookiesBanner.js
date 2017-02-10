window.addEventListener("load", function()
{
	window.cookieconsent.initialise(
		{
			"palette":
				{
					"popup":
						{
							"background": "#efefef",
							"text": "#404040"
						},
					"button":
						{
							"background": "#8ec760",
							"text": "#ffffff"
						}
				},
			"theme": "classic",
			"content":
				{
					"message": "Ta strona używa plików \"cookies\" (tzw. ciasteczka). Kontynuując korzystanie z witryny, akceptujesz ten stan rzeczy.",
					"dismiss": "OK!",
					"link": "Dowiedz się więcej"
				}
		})
});
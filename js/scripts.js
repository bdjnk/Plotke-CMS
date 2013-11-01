
var html;

function save(elm)
{
	var edited = elm.parentNode;
	edited.innerHTML = elm.value;
	
	$(edited).removeClass("editing");

	if (!ctrlDown)// && edited.innerHTML.trim() != html)
	{
		// save to database
		$.ajax({
			url: "lib/save.php",
			data: {
				value: elm.value,
				table: edited.getAttribute("data-table"),
				id: edited.getAttribute("data-uid"),
				field: edited.getAttribute("data-field")
			},
			type: "POST",
			done: function()
			{
				console.log("success");
			},
			fail: function()
			{
				console.log("error");
			},
			always: function()
			{
				console.log("finished");
			}
		});
	}
}

var field;

function clicked()
{
	if (!ctrlDown)
	{
		var url = this.getAttribute("data-url");
		if (url != null)
		{
			window.location = url;
		}
		if ($(this).hasClass("menu"))
		{
			$(this).next().toggleClass("hide");
		}
		return;
	}
	if ($(this).hasClass("editing")) { return; }

	html = this.innerHTML.trim();
	if ($(this).hasClass("text"))
	{
		this.innerHTML = "<input type='text' value='"+html+"'>";
	} else
	if ($(this).hasClass("html"))
	{
		this.innerHTML = "<textarea rows='10'>"+html+"</textarea>";
	}
	$(this).addClass("editing");
	this.firstChild.focus();

	$(this).children(":first").blur(function()
	{
		if (document.activeElement != this)
		{
			save(this);
		}
	});
}

var editable = $(".edit")
for (var i = 0; i < editable.length; i++)
{
	editable[i].onclick = clicked;
}

var shiftDown = false;
var ctrlDown = false;
var altDown = false;

$(window).keydown(function(evt)
		{
			switch (evt.which)
			{
				case 16: shiftDown = true; break;
				case 17: ctrlDown = true; break;
				case 18: altDown = true; break;
			}
		}
).keyup(function(evt)
		{
			switch (evt.which)
			{
				case 16: shiftDown = false; break;
				case 17: ctrlDown = false; break;
				case 18: altDown = false; break;
			}
		}
);


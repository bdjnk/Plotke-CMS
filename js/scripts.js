
var content;

function save(elm)
{
	var edited = elm.parentNode;
	if ($(edited).hasClass("text"))
	{
		edited.innerHTML = elm.value;
	} else
	if ($(edited).hasClass("html"))
	{
		$(edited).data("markdown", elm.value);
		edited.innerHTML = markdown.toHTML(elm.value);
	}
	
	$(edited).removeClass("editing");

	if (!ctrlDown)// && edited.innerHTML.trim() != content)
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

function edit()
{
	var field = $(this);

	if (!ctrlDown)
	{
		var url = field.attr("data-url");
		if (url != null)
		{
			window.location = url;
		}
		if (field.hasClass("menu") && !field.hasClass("editing"))
		{
			field.next().toggleClass("hide");
			field.toggleClass("closed");
		}
		return;
	}
	if (field.hasClass("editing")) { return; }

	if (field.hasClass("text"))
	{
		content = field.html().trim();
		field.html("<input type='text' value='"+content+"'>");
	} else
	if (field.hasClass("html"))
	{
		content = field.data("markdown") == null
			? field.html().trim() : field.data("markdown");
		field.html("<textarea rows='1'>"+content+"</textarea>");
		
		var height = field.children(":first").prop("scrollHeight");
		if (height > 600) { height = 600; }
		field.children(":first").height(height);
	}
	field.addClass("editing");
	this.firstChild.focus();

	field.children(":first").blur(function()
	{
		if (document.activeElement != this)
		{
			save(this);
		}
	});
}

$(".edit").click(edit);

var bad = $(".edit.html");
for (var i = 0; i < bad.length; i++)
{
	$(bad[i]).data("markdown", $(bad[i]).html().trim());
	$(bad[i]).html(markdown.toHTML($(bad[i]).html().trim()));
}

function add()
{
	if ($(this).hasClass("page"))
	{
		console.log("new page");
	} else
	if ($(this).hasClass("category"))
	{
		console.log("new category");
	} else
	if ($(this).hasClass("post"))
	{
		console.log("new post");
	}
}

$(".new").click(add);

function shift(down)
{
	shiftDown = down;
}
function ctrl(down)
{
	ctrlDown = down;
}
function alt(down)
{
	altDown = down;
	down ? $(".new").removeClass("hide") : $(".new").addClass("hide");
}

var shiftDown = false;
var ctrlDown = false;
var altDown = false;

$(window).keydown(function(evt)
		{
			switch (evt.which)
			{
				case 16: shift(true); break;
				case 17: ctrl(true); break;
				case 18: alt(true); break;
			}
		}
).keyup(function(evt)
		{
			switch (evt.which)
			{
				case 16: shift(false); break;
				case 17: ctrl(false); break;
				case 18: alt(false); break;
			}
		}
);

$(window).blur(function()
{
	shift(false);
	ctrl(false);
	alt(false);
	$("#message").removeClass("hide");
});
$(window).focus(function()
{
	$("#message").addClass("hide");
});

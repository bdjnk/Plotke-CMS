
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

function edit()
{
	if (!ctrlDown)
	{
		var url = this.getAttribute("data-url");
		if (url != null)
		{
			window.location = url;
		}
		if ($(this).hasClass("menu") && !$(this).hasClass("editing"))
		{
			$(this).next().toggleClass("hide");
			$(this).toggleClass("closed");
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

var editable = $(".edit");
for (var i = 0; i < editable.length; i++)
{
	editable[i].onclick = edit;
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

var addable = $(".new");
for (var i = 0; i < addable.length; i++)
{
	addable[i].onclick = add;
}

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
	down ? addable.removeClass("hide") : addable.addClass("hide");
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

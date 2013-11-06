
var content;

function save(elm)
{
	var edited = $(elm).parent();
	content = elm.value;
	if (content == "") { content = "&nbsp;"; }

	if (edited.hasClass("text"))
	{
		edited.html(content);
	} else
	if (edited.hasClass("html"))
	{
		edited.data("markdown", content);
		edited.html(marked(content));
	}
	
	edited.removeClass("editing");

	if (!ctrlDown)// && edited.html().trim() != content)
	{
		// save to database
		$.ajax({
			url: "lib/save.php",
			data: {
				value: elm.value,
				table: edited.attr("data-table"),
				id: edited.attr("data-uid"),
				field: edited.attr("data-field")
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
	if (field.hasClass("editing")) { return; }

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

function add()
{
	var field = $(this);

	if (field.hasClass("page"))
	{
		console.log("new page");
	} else
	if (field.hasClass("category"))
	{
		console.log("new category");
	} else
	if (field.hasClass("post"))
	{
		console.log("new post");
	}
}

var drag = null;

$(document).ready(function()
{
	$(".edit").click(edit);

	var bad = $(".edit.html");
	for (var i = 0; i < bad.length; i++)
	{
		content = $(bad[i]).html().trim();
		if (content == "") { content = "_"; }

		$(bad[i]).data("markdown", content);
		$(bad[i]).html(marked(content));
	}

	$(".drag").mousedown(function()
	{
		if (ctrlDown) { return; }
		
		drag = $(this);
		if (drag.hasClass("editing")) { return; }
		drag.addClass("dragging");

		$("head").append(
			"<style type='text/css'>\n* {\n"+
			"	-webkit-touch-callout: none;\n"+
			"	-webkit-user-select: none;\n"+
			"	-khtml-user-select: none;\n"+
			"	-moz-user-select: none;\n"+
			"	-ms-user-select: none;\n"+
			"	user-select: none;\n"+
			"}\n</style>");

		$("#message").html("Dragging");
		$("#message").removeClass("hide");

		if (drag.attr("data-func") == "mk")
		{
			$(".new").show();
			$("div#menu li").css("padding", "0 4px");
		}
	});
	
	$(".drop").mouseup(function()
	{
		drop = $(this);
		if (drop.attr("data-func") == "rm")
		{
			if (drag.parent().hasClass("post"))
			{
				drag.parent().remove();
			}
		}
	}).mouseover(function()
	{
		if (drag == null) { return; }
		if (!drag.hasClass("edit")) { return; }

		drop = $(this);
		if (drop.attr("data-func") == "rm")
		{
			drop.css("background-color", "#bb0202").css("color", "#fff");
		} else
		if (drop.attr("data-func") == "mv" && drag.parent().hasClass("post"))
		{
			drop.css("background-color", "#00bb0d").css("color", "#fff");
		}
	}).mouseout(function()
	{
		drop = $(this);
		drop.css("background-color", "").css("color", "");
	});

	($(".new").children()).mouseover(function()
	{
		$(this).parent().css("background-color", "#0013bb");
	}).mouseout(function()
	{
		$(this).parent().css("background-color", "");
	});

	$(document).mouseup(function()
	{
		if (drag == null) { return; }

		if (drag.attr("data-func") == "mk")
		{
			$(".new").hide();
			$("div#menu li").css("padding", "");
		}

		drag.removeClass("dragging");
		$("#message").addClass("hide");
		$("head").children("style").last().remove();
		drag = null;
		
		if (drop == null) { return; }

		drop.css("background-color", "").css("color", "");
		drop = null;
	});
});

function shift(down)
{
	shiftDown = down;
}
function ctrl(down)
{
	ctrlDown = down;
	if (down)
	{
		$("#message").html("Edit Mode");
		$("#message").removeClass("hide");
	}
	else
	{
		$("#message").html("");
		$("#message").addClass("hide");
	}
}
function alt(down)
{
	altDown = down;
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
	$("#message").html("Window Unfocused");
	$("#message").removeClass("hide");
});
$(window).focus(function()
{
	$("#message").addClass("hide");
});

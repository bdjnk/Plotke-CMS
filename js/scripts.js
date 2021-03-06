
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
		$("pre code").each(function(index, code)
		{
			hljs.highlightBlock(code)
		});
	}
	
	edited.removeClass("editing");

	if (!ctrlDown)// && edited.html().trim() != content)
	{
		// save to database
		$.ajax({
			url: "lib/save.php",
			data: {
				action: "update",
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

var create = null;

function add()
{
	var type = create.attr("data-new");
	console.log("new "+type);

	var info = {};
	switch(type)
	{
		case "category":	// need sort order
			info.index = 1 + create.prevAll(".new").length;
			break;
		case "page":			// need category uid
			info.index = 1 + create.prevAll(".new").length;
			info.cid = create.parents("dl").children("dt.menu").attr("data-uid");
			break;
		case "post":			// need page & author uids
			info.pid = create.attr("data-pid");
			break;
	}
	$.ajax({
		url: "lib/save.php",
		data: {
			action: "create",
			table: type,
			info: info
		},
		type: "POST",
		success: function()
		{
			console.log("success");
		},
		error: function()
		{
			console.log("error");
		},
		complete: function()
		{
			console.log("finished");
		}
	});
}

var drag = null;
var drop = null;

/*""""""""""""""""""""""""""""""""""""""""""""""""""""""""*\
 * Once the document is fully loaded, set interactions
 */
$(document).ready(function()
{
	$(".edit").click(edit).hover(
			function() {
				if (ctrlDown) { $(this).addClass("hover"); }
			},
			function() { $(this).removeClass("hover"); })

	var bad = $(".edit.html");
	for (var i = 0; i < bad.length; i++)
	{
		content = $(bad[i]).html().trim();
		if (content == "") { content = "_"; }

		$(bad[i]).data("markdown", content);
		$(bad[i]).html(marked(content));
	}
	$("pre code").each(function(index, code)
	{
		hljs.highlightBlock(code)
	});

	$(".drag").mousedown(function()
	{
		if (ctrlDown) { return; }

		$("head").append(
			"<style type='text/css'>\n* {\n"+
			"	-webkit-touch-callout: none;\n"+
			"	-webkit-user-select: none;\n"+
			"	-khtml-user-select: none;\n"+
			"	-moz-user-select: none;\n"+
			"	-ms-user-select: none;\n"+
			"	user-select: none;\n"+
			"}\n</style>");
		
		drag = $(this);

		drag.mouseout(function()
		{
			if (drag == null) { return; }
			if (drag.hasClass("editing")) { return; }
			drag.addClass("dragging");

			$("#message").html("Dragging");
			$("#message").removeClass("hide");

			if (drag.hasClass("create"))
			{
				$(".new").addClass("show");
				$("div[data-new='post'] :first-child").height(
					$("div[data-new='post']").parent().height());
				$("div#menu ul").addClass("squish");
				$("div#menu li").addClass("squish");
			}
			if (drag.data("table") == "page")
			{
				$("div[data-new='page']").addClass("show");
				$("div#menu li").addClass("squish");
			}
			if (drag.data("table") == "category")
			{
				$("div[data-new='category']").addClass("show");
			}
		});
	});
	
	$(".drop").mouseup(function()
	{
		drop = $(this);
		if (drop.hasClass("delete"))
		{
			var type = drag.attr("data-table");
			var uid = drag.attr("data-uid");
			switch(type)
			{
				case "post":
					drag.parent().remove();
					break;
				case "page":
					drag.remove();
					break;
				case "category":
					drag.remove();
					break;
			}
			$.ajax({
				url: "lib/save.php",
				data: {
					action: "delete",
					table: type,
					uid: uid
				},
				type: "POST",
				success: function()
				{
					console.log("success");
				},
				error: function()
				{
					console.log("error");
				},
				complete: function()
				{
					console.log("finished");
				}
			});
		}
	}).mouseover(function()
	{
		if (drag == null) { return; }
		if (!drag.hasClass("edit")) { return; }

		drop = $(this);
		if (drop.hasClass("delete"))
		{
			drop.addClass("live");
		} else
		if (drop.hasClass("sendto") && drag.parent().hasClass("post"))
		{
			drop.addClass("live");
		}
	}).mouseout(function()
	{
		drop = $(this);
		drop.removeClass("live");
	});

	($(".new").children()).mouseover(function()
	{
		create = $(this).parent();
		create.addClass("live");

	}).mouseout(function()
	{
		$(this).parent().removeClass("live");
		create = null;
	});

	$(document).mouseup(function()
	{
		if (drag == null) { return; }

		//if (drag.hasClass("create"))
		{
			$(".new").removeClass("show");
			$("div#menu li").removeClass("squish");
			$("div#menu ul").removeClass("squish");

			if (create != null)
			{
				add();
				create = null;
			}
		}

		drag.removeClass("dragging");
		$("#message").addClass("hide");
		$("head").children("style").last().remove();
		drag = null;
		
		if (drop == null) { return; }

		drop.removeClass("live");
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

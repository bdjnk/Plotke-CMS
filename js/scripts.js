function menu(menuId, arrowId)
{
  var menu = document.getElementById(menuId);
  var arrow = document.getElementById(arrowId);

  switch (menu.className)
	{
    case ('show'):
      menu.className = 'hide';
			arrow.src = 'images/arrow1.gif';
      break;
    case ('hide'):
      menu.className = 'show';
			arrow.src = 'images/arrow2.gif';
      break;
  }
}

$(document).ajaxError(function(event, request, settings)
{
	$("#msg" ).append("<li>Error requesting page "+settings.url+"</li>");
});

var html;
var text;
var undo;

function save(elm)
{
	var edited = elm.parentNode;
	if (elm.tagName == "INPUT")
	{
		if (undo == 0)
		{
			edited.innerHTML = elm.value;
		} else
		if (undo == 1)
		{
			edited.innerHTML = html;
			var alter = edited.getElementsByClassName("alter")[0];
			alter.innerHTML = elm.value;
		}
		else { alert("too many alters, inform your system admin."); }
	} else
	if (elm.tagName == "TEXTAREA")
	{
		edited.innerHTML = elm.value;
	}
	if (!ctrlDown)
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
				console.log( "success" );
			},
			fail: function()
			{
				console.log( "error" );
			},
			always: function()
			{
				console.log( "finished" );
			}
		});
	}
}

function edit()
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
	undo = this.getElementsByClassName("alter").length;
	html = this.innerHTML.trim();
	text = this.textContent.trim();
	if (hasClass(this, "text"))
	{
		this.innerHTML = "<input type='text' value='"+text+"'>";
	} else
	if (hasClass(this, "html"))
	{
		this.innerHTML = "<textarea rows='10'>"+html+"</textarea>";
	}
	this.firstChild.focus();
	$(this).children(":first").blur(function() {
		save(this);
	});
}

var editable = $(".edit")//document.getElementsByClassName('edit');
for (var i = 0; i < editable.length; i++)
{
	editable[i].onclick = edit;
}

function wink()
{
	document.getElementById('winkeye').innerHTML="&nbsp;-";
	var unwink=setTimeout("document.getElementById('winkeye').innerHTML='o'",290);
}

function hasClass(element, className)
{
    return (" "+element.className+" ").indexOf(" "+className+" ") > -1;
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


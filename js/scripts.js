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

var html;
var text;
var undo;

function preview()
{
	if (this.tagName == "INPUT")
	{
		if (undo == 0)
		{
			this.parentNode.innerHTML = this.value;
		} else
		if (undo == 1)
		{
			changed = this.parentNode;
			changed.innerHTML = html;
			var alter = changed.getElementsByClassName("alter")[0];
			alter.innerHTML = this.value;
		}
		else { alert("too many alters, inform your system admin."); }
	} else
	if (this.tagName == "TEXTAREA")
	{
		this.parentNode.innerHTML = this.value;
	}
}

function edit()
{
	undo = this.getElementsByClassName("alter").length;
	html = this.innerHTML.trim();
	text = this.textContent.trim();
	if (hasClass(this, "text"))
	{
		this.innerHTML = "<input style='width: 100%' type='text' value='"+text+"'>";
	} else
	if (hasClass(this, "html"))
	{
		this.innerHTML = "<textarea rows='10' style='width:100%'>"+html+"</textarea>";
	}
	this.firstChild.focus();
	this.firstChild.onblur = preview;
}

var editable = document.getElementsByClassName('edit');
for (var i = 0; i < editable.length; i++)
{
	editable[i].ondblclick = edit;
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

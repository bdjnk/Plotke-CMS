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

function done()
{
	var fresh;
	if (this.tagName == "INPUT")
	{
		fresh = this.value;
		//this.textContent = text;
	} else
	if (this.tagName == "TEXTAREA")
	{
		fresh = this.textContent.trim();
	}
		this.parentNode.innerHTML = fresh;
}

function click(e)
{
	//if (!e.ctrlKey) { return; }
	html = this.innerHTML.trim();
	text = this.textContent.trim();
	//alert(html+"\n"+text);
	if (hasClass(this, "text"))
	{
		this.innerHTML = "<input style='width:100%' type='text' value='"+text+"'>";
	} else
	if (hasClass(this, "html"))
	{
		this.innerHTML = "<textarea rows='10' style='width:100%'>"+html+"</textarea>";
	}
	this.firstChild.focus();
	this.firstChild.onblur = done;
}

var editable = document.getElementsByClassName('edit');
for (var i = 0; i < editable.length; i++)
{
	editable[i].ondblclick = click;
	//editable[i].onblur = done;
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

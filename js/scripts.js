function menuFunc(menuId, arrowId) {
  var menu = document.getElementById(menuId);
  var arrow = document.getElementById(arrowId);

  switch (menu.className) {
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

var editable = document.getElementsByClassName('edit');
for (var i = 0; i < editable.length; i++)
{
	editable[i].ondblclick = edit;
	editable[i].onblur = save;
}

function wink()
{
	document.getElementById('winkeye').innerHTML="&nbsp;-";
	var unwink=setTimeout("document.getElementById('winkeye').innerHTML='o'",290);
}

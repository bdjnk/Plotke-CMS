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

function wink()
{
	document.getElementById('winkeye').innerHTML="&nbsp;-";
	var unwink=setTimeout("document.getElementById('winkeye').innerHTML='o'",290);
}

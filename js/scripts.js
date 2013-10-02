function menuFunc (idOne,idTwo) {
  var idCurrent = document.getElementById(idOne);
  var srcCurrent = document.getElementById(idTwo);

  switch (idCurrent.className) {
    case ('show'):
      idCurrent.className = 'hide';
      break;
    case ('hide'):
      idCurrent.className = 'show';
      break;
  }

  srcSwap('1','2');
  function srcSwap(right,down) {
    var arrow = ((srcCurrent.src.match(right) != null)? down : right);
    setTimeout("document.getElementById('"+idTwo+"').src = 'images/arrow"+arrow+".gif'",1);
  }
}

function noPage() {
  alert('This page does not exist yet.');
}

function wink()
{
document.getElementById('winkeye').innerHTML="&nbsp;-";
var unwink=setTimeout("document.getElementById('winkeye').innerHTML='o'",290);
}

<?php error_reporting(E_ALL); ini_set("display_errors", 1);
date_default_timezone_set('America/Los_Angeles'); setlocale(LC_ALL, 'us_US');
include("/usr/share/webapps/Plotke-CMS/lib/mysql.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>

<title>Homepage - bdjnk</title>
<meta name="description" content="Index">
<meta name="keywords" content="Linux">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="css/style.css" rel="stylesheet" type="text/css">

<!--for page specific styles-->
<style type="text/css">
</style>

<script type="text/javascript" src="js/scripts.js"></script>

<!--for page specific script-->
<script type="text/javascript"><!--
if (document.images) {
   img = new Image();
   img.src = "images/arrow2.gif";
}
function menuHide(idOne,idTwo,idThree) {
  idAll = [idOne,idTwo,idThree];
  for (var i = 0; i < idAll.length; i++) {
    document.getElementById(idAll[i]).className = 'hide';
  }
}
--></script>

</head>

<body onload="menuHide('LinuxMenu','CodeMenu','AdviceMenu')">
<div id="wrapper">
  
  <div class="spacer"></div>

  <div class="titlebox">
		<span id="title">Site News</span><br>
		<span id="subtitle">Occasional info about the status of this site.</span>
  </div>
  
  <div class="spacer"></div>

	<div class="navbox">
		<?php $result = get_pages(); $pt = "zxzx"; while ($row = $result->fetch_assoc()) { $t = $row['title']; if ($t == "") { ?>
		<div class="menu"><a href="javascript:;"><?php echo $row['short_title']; ?></a></div>
		<div class="menuspacer"></div>
		<?php } else { $s = $row['short_title']; if ($pt != $t) { if ($pt != "") { ?>
    </dl>
		<div class="menuspacer"></div>
		<?php } ?>
    <div class="menu">
			<a onclick="menuFunc('LinuxMenu','LinuxArrow')" href="javascript:;">
			<img class="arrow" id="LinuxArrow" src="images/arrow1.gif" alt="menu arrow"><?php echo $t ?></a>
		</div>
    <dl id="LinuxMenu" class="hide">
			<dt class="submenu"><a href="javascript:;"><?php echo $s; ?></a></dt>
		<?php } else { ?>
			<dt class="submenu"><a href="javascript:;"><?php echo $s; ?></a></dt>
		<?php } } $pt = $t; } ?>
  </div>
  
	<div class="contentbox">
		<?php $result = get_posts(0); while ($row = $result->fetch_assoc()) { ?>
    <div class="contenttitle" title='<?php echo strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>'>
			<?php echo $row['title']; ?>
    </div>
    <div class="contenttxt">
			<?php echo $row['abstract']; ?>
      <!--<div class="date"><?php //echo strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?></div>-->
		</div>
		<?php } ?>
  </div>
  
  <div class="spacer" style="clear: both;"></div>
  
  <div class="footerbox">
    <div id="stupid">&nbsp;</div>
    <div id="note">
    This page validates as HTML 4.01 Strict: <a href="http://validator.w3.org/check/referer">check</a>.
    </div>
    <div id="wink">
      <a href="http://www.bdjnk.50webs.com/iereject.html"><span style="font-family:serif;" onclick="wink()"><span id="winkeye">o</span>_O</span></a>
    </div>
  </div>

</div>

</body>
</html>

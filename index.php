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
--></script>

</head>

<body>
<div id="wrapper">
  
  <div class="spacer"></div>

	<div class="titlebox">
	<?php $result = get_info(0);
	if ($row = $result->fetch_assoc()) { ?>
		<span class="i-text" id="title"><?php echo $row['long_title'] ?></span><br>
		<span class="i-text" id="subtitle"><?php echo $row['description'] ?></span>
	<?php } ?>
  </div>
  
  <div class="spacer"></div>

	<div class="navbox">
	<?php
	$result = get_pages();
	$pcat = "";
	while ($row = $result->fetch_assoc()) {
		$cat = $row['title'];
		if ($cat == "") { ?>
		<div class="menu i-text"><a href="javascript:;"><?php echo $row['short_title']; ?></a></div>
		<div class="menuspacer"></div>
		<?php
		} else {
			$page = $row['short_title'];
			if ($pcat != $cat) {
				if ($pcat != "") { ?>
    </dl>
		<div class="menuspacer"></div>
		<?php } ?>
    <div class="menu">
			<a onclick="menuFunc('<?php echo $row['cat']; ?>Menu','<?php echo $row['cat']; ?>Arrow')" href="javascript:;">
			<img class="arrow" id="<?php echo $row['cat']; ?>Arrow" src="images/arrow1.gif" alt="menu arrow"><?php echo $cat ?></a>
		</div>
    <dl id="<?php echo $row['cat']; ?>Menu" class="hide">
			<dt class="submenu"><a href="javascript:;"><?php echo $page."jim"; ?></a></dt>
		<?php } else { ?>
			<dt class="submenu"><a href="javascript:;"><?php echo $page."bob"; ?></a></dt>
	<?php } } $pcat = $cat; } ?>
  </div>
  
	<div class="contentbox">
		<?php $result = get_posts(0);
		while ($row = $result->fetch_assoc()) {
		$info = strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>
		<div class="contenttitle i-text" id="<?php echo $row['id'] ?>" title="<?php echo $info; ?>">
			<?php echo $row['title']; ?>
    </div>
    <div class="contenttext i-html">
			<?php echo $row['abstract']; ?>
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

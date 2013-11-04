<?php
	error_reporting(E_ALL); ini_set("display_errors", 1);

	date_default_timezone_set('America/Los_Angeles'); setlocale(LC_ALL, 'us_US');

	include_once("/usr/share/webapps/Plotke-CMS/lib/mysql.php");

	$post = $_GET['post'];
	$page = isset($_GET['page']) ? $_GET['page'] : 0;

	define("FIRST", -1);
?>

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

</head>

<body>
<div id="message" class="hide">Window Unfocused</div>

<div id="wrapper">
  
  <div class="spacer"></div>

	<div id="titlebox">
<?php
	$result = get_post($post);
	if ($row = $result->fetch_assoc()) { ?>
		<div class="edit text" id="posttitle" data-table="post" data-uid="<?php echo $post ?>" data-field="title">
	<?php echo $row['title'] ?></div>
		<div class="edit text" id="abstract" data-table="post" data-uid="<?php echo $post ?>" data-field="abstract">
	<?php echo $row['abstract'] ?></div>
<?php
	} ?>
  </div>
  
  <div class="spacer"></div>

	<div id="menu">
<?php
	$result = get_pages();
	$pcat = FIRST;
	while ($row = $result->fetch_assoc()) {
		$cat = $row['cat'];
		if ($pcat != $cat) {
			if ($pcat != FIRST) { ?>
					<li class="new page hide">new_page</li>
				</ul>
			</dd>
		</dl>
		<?php
			} ?>
		<dl>
			<dt class="menu edit text"><?php echo $row['title']; ?></dt>
			<dd>
				<ul>
	<?php
		} if (isset($row['id'])) { ?>
					<li data-url="?page=<?php echo $row['id']; ?>" class="edit text">
						<?php echo $row['short_title']; ?></li>
	<?php
		} $pcat = $cat; } ?>
					<li class="new page hide">new_page</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt class="new category hide">new_category</dt>
		</dl>
  </div>
  
	<div id="contentbox">
<?php
	$result = get_post($post);
	while ($row = $result->fetch_assoc()) {
		//$info = strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>
		<div class="contenttitle"></div>
		<div class="contenttext edit html" data-table="post" data-uid="<?php echo $row['id'] ?>" data-field="content">
	<?php echo $row['content']; ?>
		</div>
<?php
	} ?>
  </div>
  
  <div class="spacer" style="clear: both;"></div>
  
  <div id="footerbox">
    <div id="stupid">&nbsp;</div>
    <div id="note">
			This page validates as HTML 4.01 Strict: <a href="http://validator.w3.org/check/referer">check</a>.
    </div>
  </div>

</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

<!--for page specific script-->
<script type="text/javascript"><!--
var page;
$(document).ready(function()
{
	page = <?php echo $page ?>;
});
--></script>

</body>
</html>

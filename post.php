<?php
	$post = $_GET['post'];
?>

<head>

<title>Homepage - bdjnk</title>
<meta name="description" content="Index">
<meta name="keywords" content="Linux">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="css/style.css" rel="stylesheet" type="text/css">

<!--for page specific styles-->
<style type="text/css">
</style>

<!--for page specific script-->
<script type="text/javascript"><!--
var page;
$(document).ready(function()
{
	post = <?php echo $post ?>;
});
--></script>

</head>

<body>
<div id="message" class="hide"></div>

<div id="wrapper">
  
  <div class="spacer"></div>

	<div id="header">
<?php
	$result = get_post($post);
	if ($row = $result->fetch_assoc()) { ?>
		<div class="edit text" id="posttitle" data-table="post" data-uid="<?php echo $post ?>" data-field="title">
	<?php echo $row['title'] ?></div>
		<div class="edit html" id="abstract" data-table="post" data-uid="<?php echo $post ?>" data-field="abstract">
	<?php echo $row['abstract'] ?></div>
<?php
	} ?>
  </div>
  
<?php include(getcwd()."/menu.php"); ?>

	<div id="content">
<?php
	$result = get_post($post);
	while ($row = $result->fetch_assoc()) {
		//$info = strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>
		<div class="title">
	<?php echo strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>
		</div>
		<div class="body edit html" data-table="post" data-uid="<?php echo $row['id'] ?>" data-field="content">
	<?php echo $row['content']; ?>
		</div>
<?php
	} ?>
  </div>
  
  <div class="spacer" style="clear: both;"></div>
  
  <div id="footer">
    <div id="stupid">&nbsp;</div>
    <div id="note">
			This page validates as HTML 4.01 Strict: <a href="http://validator.w3.org/check/referer">check</a>.
    </div>
  </div>

</div>
</body>

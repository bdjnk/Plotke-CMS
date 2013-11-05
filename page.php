<?php
	$page = isset($_GET['page']) ? $_GET['page'] : 0;
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
	page = <?php echo $page ?>;
});
--></script>

</head>

<body>
<div id="message" class="hide">Window Unfocused</div>

<div id="wrapper">
  
  <div class="spacer"></div>

	<div id="titlebox">
<?php
	$result = get_info($page);
	if ($row = $result->fetch_assoc()) { ?>
		<div class="edit text" id="title" data-table="page" data-uid="<?php echo $page ?>" data-field="long_title">
	<?php echo $row['long_title'] ?></div>
		<div class="edit text" id="subtitle" data-table="page" data-uid="<?php echo $page ?>" data-field="description">
	<?php echo $row['description'] ?></div>
<?php
	} ?>
  </div>
   
<?php include(getcwd()."/menu.php"); ?>

	<div id="content">
		<div class="new post hide title">new_post</div>
<?php
	$result = get_posts($page);
	while ($row = $result->fetch_assoc()) {
		$info = strftime("%Y, %B %d at %R", $row['time_published'])." by ".$row['name']; ?>
		<div class="post">
			<div class="title alter">
				&nbsp;
				<ul>
					<li>Delete</li>
					<li>Publish</li>
					<li>Author</li>
				</ul>
			</div>
			<div class="title edit text" data-url="?post=<?php echo $row['id'] ?>" title="<?php echo $info; ?>" data-table="post" data-uid="<?php echo $row['id'] ?>" data-field="title">
	<?php
		echo $row['title']; ?>
		  </div>
			<div class="body edit html" data-table="post" data-uid="<?php echo $row['id'] ?>" data-field="abstract">
	<?php
		echo $row['abstract']; ?>
			</div>
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
</body>

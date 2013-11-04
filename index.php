<?php
if (isset($_GET['post']))
{
	include("/usr/share/webapps/Plotke-CMS/post.php");
}
else
{
	include("/usr/share/webapps/Plotke-CMS/page.php");
}
?>

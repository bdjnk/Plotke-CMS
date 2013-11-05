<?php
	error_reporting(E_ALL); ini_set("display_errors", 1);

	date_default_timezone_set('America/Los_Angeles'); setlocale(LC_ALL, 'us_US');

	include_once(getcwd()."/lib/mysql.php");

	define("FIRST", -1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">

<head>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/marked.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

<?php
	if (isset($_GET['post']))
	{
		include(getcwd()."/post.php");
	}
	else
	{
		include(getcwd()."/page.php");
	}
?>

</html>

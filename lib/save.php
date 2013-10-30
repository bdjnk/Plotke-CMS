<?php
include_once("/usr/share/webapps/Plotke-CMS/lib/mysql.php");

//$log = fopen("log.txt", 'w');
//fwrite($log, "entered save.php\n");

//fwrite($log, "value: ".$_POST['value']."\n");

if (isset($_POST['value']))
{
	//fwrite($log, "value is set\n");
	//save to database
	$mysqltime = date ("Y-m-d H:i:s", $phptime);

	$db = opendb();
	$query = "
		UPDATE ".$_POST['table']."
		SET ".$_POST['field']." = '".$_POST['value']."'
		WHERE id = ".$_POST['id']."
	";
	$result = $db->real_query($query);

	//fwrite($log, "success: $result\n");
}

//fclose($log);
?>

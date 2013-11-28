<?php
include_once("/usr/share/webapps/Plotke-CMS/lib/mysql.php");

//$log = fopen("log.txt", 'w');
//fwrite($log, "entered save.php\n");

$mysqltime = date("Y-m-d H:i:s", $phptime);

switch ($_POST['action'])
{
case "update":
	//fwrite($log, "value: ".$_POST['value']."\n");
	if (isset($_POST['value']))
	{
		//fwrite($log, "value is set\n");
		//save to database

		$db = opendb();
		$query = "
			UPDATE ".$_POST['table']."
			SET ".$_POST['field']." = '".$_POST['value']."'
			WHERE id = ".$_POST['id']."
		";
		$result = $db->real_query($query);

		//fwrite($log, "success: $result\n");
	}
	break;
case "create":
	$db = opendb();
	$query = "INSERT INTO ".$_POST['table'];
	switch ($_POST['table'])
	{
	case "post":
		$query.= " () VALUES ()";
		break;
	case "page":
		$query.= " () VALUES ()";
		break;
	case "category":
		$query.= " () VALUES ()";
		break;
	}
	break;
case "adjust":
	break;
case "delete":
	break;
}

//fclose($log);
?>

<?php
include_once("/usr/share/webapps/Plotke-CMS/lib/mysql.php");

//$log = fopen("log.txt", 'w');
//fwrite($log, "entered save.php\n");

$mysqltime = date("Y-m-d H:i:s", $phptime);

switch ($_POST['action'])
{
case "update":
	if (isset($_POST['value']))
	{
		//fwrite($log, "table = ".$_POST['table']."\n");
		//fwrite($log, "field = ".$_POST['field']."\n");
		//fwrite($log, "   id = ".$_POST['id']."\n");

		//save to database
		$db = opendb();
		$query = "
			UPDATE ".$_POST['table']."
			SET ".$_POST['field']." = '".$db->real_escape_string($_POST['value'])."'
			WHERE id = ".$_POST['id']."
		";
		$result = $db->real_query($query);
		/*
		fwrite($log, " rows = ".$db->affected_rows."\n");
		
		if ($db->error) {
			try {    
        throw new Exception("MySQL error $db->error", $db->errno);    
			}
			catch(Exception $e ) {
        fwrite($log, "Error No: ".$e->getCode()." - ".$e->getMessage()."\n");
			}
		}
		*/
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

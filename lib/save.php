<?php
include_once("./mysql.php");

$log = fopen("log.txt", 'w');
fwrite($log, "entered save.php\n");

$mysqltime = date("Y-m-d H:i:s", $phptime);

fwrite($log, "\n\$_POST = ".print_r($_POST, true)."\n");

$db = opendb();

switch ($_POST['action'])
{
case "update":
	if (isset($_POST['value']))
	{
		$query = "
			UPDATE ".$_POST['table']."
			SET ".$_POST['field']." = '".$db->real_escape_string($_POST['value'])."'
			WHERE id = ".$_POST['id']."
		";
	}
	break;

case "create":
	$info = $_POST['info'];
	$db = opendb();
	$query = "INSERT INTO ".$_POST['table'];
	switch ($_POST['table'])
	{
	case "post":
		$query.= " (title, abstract, content, time_published, page_id)
			VALUES ('', '', '', NOW(), ".$info['pid'].")";
		break;
	case "page":
		$query.= " (sort, short_title, long_title, description, category_id)
			VALUES (".$info['index'].", '', '', '', ".$info['cid'].")";
		break;
	case "category":
		$query.= " (sort, title) VALUES (".$info['index'].", '')";
		break;
	}
	break;

case "adjust":
	break;

case "delete":
	$query = "DELETE FROM ".$_POST['table']." WHERE id = ".$_POST['uid'];
	break;
}

fwrite($log, $query."\n");

$result = $db->real_query($query);

if ($db->error) {
	try {    
		throw new Exception("MySQL error $db->error", $db->errno);    
	}
	catch(Exception $e ) {
		fwrite($log, "Error No: ".$e->getCode()." - ".$e->getMessage()."\n");
	}
}

fclose($log);
?>

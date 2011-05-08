<?php

error_reporting(4096);

require '../lib/sqlite3.php';

$db = new Lib_Sqlite3(new PDO('sqlite:' . getcwd() . '/wedding.db'));
$line = 1;

$guests = $db->query(
	"SELECT u.user_id, g.forename, upper(substr(u.passcode, -1)) AS char FROM guest g INNER JOIN user u ON (g.user_id = u.user_id)"
)->fetchAll();

$display = array();

foreach ($guests as $guest) {
	$display[$guest['user_id']]['names'][] = $guest['forename'];
	$display[$guest['user_id']]['letter'] = $guest['char'];
	$line++;
}

foreach ($display as $invite) {
	$names = $invite['names'];

	if (count($invite['names']) > 2) {
		$last = array_pop($names);
		$names = join(', ', $names);
	} else
		$names = join(' & ', $names);

	$char = $invite['letter'];

	if (count($invite['names']) > 2)
		echo "$names & $last : $char\n";
	else
		echo $names . " : $char\n";
}

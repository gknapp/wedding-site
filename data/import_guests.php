<?php

error_reporting(4096);

require '../lib/sqlite3.php';

$db = new Lib_Sqlite3(new PDO('sqlite:' . getcwd() . '/wedding.db'));
$fp = fopen('guests.csv', 'r');

if (!$fp)
	die("Could not open file guests.csv\n");

$i = $j = 1;
$chars = array_map(
	function ($ord) { return chr($ord); },
	range(65, 90)
);
$nums = range(0,9);
$pile = array_merge($chars, $nums);
$line = 1;

$header = fgetcsv($fp, 1000);

while (($data = fgetcsv($fp, 1000)) !== false) {
	foreach ($data as $k => $v)
		$data[$k] = trim($v);

	if ($data[0] == 'guest') {
		list(,, $forename, $surname) = $data;
		$result = $db->query(
			"INSERT INTO guest (forename, surname, user_id, rsvp, menu_id, reception_id, wine_id) " .
			"VALUES (?, ?, ?, 0, 0, 0, 0)",
			array($forename, $surname, $userId)
		);

		// echo "INSERT INTO guest (forename, surname, user_id, ) VALUES ('$forename', '$surname', $userId)\n";

		if (!$result)
			die("Failed to insert guest '$forename $surname' (line $line)\n");
	} else {
		$int = !empty($data[9]) ? 1 : 0;
		$postcode = empty($data[8]) ? '' : $data[8];

		if ($postcode) {
			$salt = $pile[rand(0, (count($pile) - 1))];
			$passcode = strtolower(str_replace(' ', '', $postcode . $salt));
		} else {
			die("No passcode for user on line $line: " . print_r($data, 1));
		}

		$result = $db->query(
			"INSERT INTO user (passcode, lastlogin, international) VALUES (?, ?, ?)",
			array($passcode, '0000-00-00 00:00:00', $int)
		);

		//echo "INSERT INTO user (passcode, lastlogin, international) VALUES ('$passcode', '0000-00-00 00:00:00', $int)\n";

		if (!$result)
			die("Failed to insert user on line $line\n");

		$userId = $db->lastInsertId();
	}
	$line++;
}

fclose($fp);
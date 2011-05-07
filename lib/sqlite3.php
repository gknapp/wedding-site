<?php

class Lib_Sqlite3 {

	private $dbh;
	private $fetchMode;

	public function __construct($dbh) {
		$this->dbh = $dbh;
		$this->fetchMode = PDO::FETCH_ASSOC;
	}

	public function setFetchMode($mode) {
		if ($mode !== PDO::FETCH_NUM)
			$mode = PDO::FETCH_ASSOC;
		$this->fetchMode = $mode;
	}

	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}

	public function query($sql, $args = null) {
		$stmt = $this->dbh->prepare($sql);

		if ($args)
			$args = is_array($args) ? array_values($args) : array($args);

		if (!$stmt) {
			die(
				'Could not prepare query: "' . $sql
				. '", args: ' . print_r($args, 1)
			);
		}

		if (strtolower(substr($sql, 0, 7)) == 'select ')
			$stmt->setFetchMode($this->fetchMode);

		$stmt->execute($args);
		return $stmt;
	}

}

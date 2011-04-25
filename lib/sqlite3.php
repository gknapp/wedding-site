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
		if (empty($args) || strtolower(substr($sql, 0, 7)) !== 'select ') {
			$stmt = $this->dbh->query($sql);
		} else {
			$args = is_array($args) ? array_values($args) : array($args);
			$stmt = $this->dbh->prepare($sql);

			if (!$stmt) {
				die(
					'Could not prepare query: "'
					. $sql
					. '", args: ' . print_r($args, 1)
				);
			}

			$stmt->execute($args);
			$stmt->setFetchMode($this->fetchMode);
		}

		return $stmt;
	}

}

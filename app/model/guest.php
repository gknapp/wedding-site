<?php

class Model_Guest extends Lib_Model {

	public $guestId;
	public $forename;
	public $surname;
	public $userId;
	public $rsvp;
	public $rsvpTime;
	public $menuId;
	public $receptionId;
	public $wineId;

	public function load($guestId) {
		$data = $this->getDB()->query(
			"SELECT * FROM guest WHERE guest_id = ?", $guestId
		)->fetch(PDO::FETCH_NUM);

		if (empty($data))
			return false;

		list(
			$this->guestId, $this->forename, $this->surname, $this->userId,
			$this->rsvp, $this->rsvpTime, $this->menuId, $this->receptionId,
			$this->wineId
		) = $data;
		return true;
	}

	public function rsvp($rsvp) {
		$this->getDB()->query(
			"UPDATE guest SET rsvp = ?, rsvp_time = datetime('now') " .
			"WHERE guest_id = ?",
			array($rsvp, $this->guestId)
		);
	}

}

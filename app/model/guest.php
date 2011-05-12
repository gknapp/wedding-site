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
	public $dietary;

	public function load($guestId) {
		$data = $this->getDB()->query(
			"SELECT * FROM guest WHERE guest_id = ?", $guestId
		)->fetch(PDO::FETCH_NUM);

		if (empty($data))
			return false;

		list(
			$this->guestId, $this->forename, $this->surname, $this->userId,
			$this->rsvp, $this->rsvpTime, $this->menuId, $this->receptionId,
			$this->wineId, $this->dietary
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

	public function setReception($receptionId) {
		$this->getDB()->query(
			"UPDATE guest SET reception_id = ? WHERE guest_id = ?",
			array($receptionId, $this->guestId)
		);
	}

	public function setMenu($menuId) {
		$this->getDB()->query(
			"UPDATE guest SET menu_id = ? WHERE guest_id = ?",
			array($menuId, $this->guestId)
		);
	}

	public function setWine($wineId) {
		$this->getDB()->query(
			"UPDATE guest SET wine_id = ? WHERE guest_id = ?",
			array($wineId, $this->guestId)
		);
	}

	public function setDietary($requirements) {
		$this->getDB()->query(
			"UPDATE guest SET dietary = ? WHERE guest_id = ?",
			array($requirements, $this->guestId)
		);
	}

}

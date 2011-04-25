<?php

class Model_User extends Lib_Model {

	public $userId;
	protected $_sessionName = 'user';

	public function login($request) {
		$session = $this->getSession();
		$session->setExpirationHops(1, 'loginAttempt');
		$session->loginAttempt = 1;

		$passCode = $request->getPost('passcode');
		if (preg_match('/[A-z0-9\s]{6,8}/', $passCode)) {
			$passCode = strtolower(trim($passCode));
			$userId = $this->getDB()->query(
				"SELECT user_id FROM user WHERE passcode = ?", $passCode
			)->fetch();

			if ($userId > 0) {
				$session->userId = $this->userId = $userId;
				$this->_updateLastLogin();
				return true;
			}
		}

		return false;
	}

	public function logout() {
		$this->getSession()->unsetAll();
	}

	public function loggedIn() {
		$session = $this->getSession();
		if ($session && $session->userId) {
			$this->userId = $session->userId;
			return true;
		}
		return false;
	}

	public function isAdmin() {
		$result = false;
		$session = $this->getSession();

		if ($session && $session->userId) {
			$admin = $this->getDB()->query(
				"SELECT user_id FROM admin WHERE user_id = ?", $session->userId
			)->fetch();

			if ($admin)
				$result = true;
		}

		return $result;
	}

	public function getGuests() {
		if (!$this->userId)
			return false;

		$guests = $this->getDB()->query(
			"SELECT guest_id FROM guest WHERE user_id = ?", $this->userId
		)->fetchAll();

		//var_dump("SELECT guest_id FROM guest WHERE user_id = " . $this->userId);
		//var_dump($guests);

		if (empty($guests))
			return false;

		foreach ($guests as $i => $guestId) {
			$guest = new Model_Guest($this->getContainer());
			$guest->load($guestId);
			$guests[$i] = $guest;
		}

		return $guests;
	}

	protected function _updateLastLogin() {
		$this->getDB()->query(
			"UPDATE user SET lastlogin = datetime(now) WHERE user_id = ?",
			$this->userId
		);
	}

}
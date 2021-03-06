<?php

class Model_User extends Lib_Model {

	public $userId;
	protected $_sessionName = 'user';

	public function abroad() {
		$abroad = $this->getDB()->query(
			"SELECT international FROM user WHERE user_id = ?",
			$this->userId
		)->fetch();

		return ($abroad['international'] > 0);
	}

	public function login($request) {
		$session = $this->getSession();
		$session->setExpirationHops(1, 'loginAttempt');
		$session->loginAttempt = 1;

		$passCode = $request->getPost('passcode');
		$passCode = strtolower(str_replace(' ', '', trim($passCode)));
		if (preg_match('/[A-z0-9\s]{6,8}/', $passCode)) {
			$user = $this->getDB()->query(
				"SELECT user_id FROM user WHERE passcode = ?", $passCode
			)->fetch();

			if ($user['user_id'] > 0) {
				$session->userId = $this->userId = $user['user_id'];
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

		if (empty($guests))
			return false;

		foreach ($guests as $i => $guestId) {
			$guest = new Model_Guest($this->getContainer());
			$guest->load($guestId);
			$guests[$i] = $guest;
		}

		return $guests;
	}

	public function getPostcode() {
		$user = $this->getDB()->query(
			"SELECT passcode FROM user WHERE user_id = ?", $this->userId
		)->fetch();

		if (empty($user['passcode']))
			return '';

		$postcode = substr($user['passcode'], 0, strlen($user['passcode']) - 1);
		return strtoupper($postcode);
	}

	public function eveningOnly() {
		$user = $this->getDB()->query(
			"SELECT day FROM user WHERE user_id = ?", $this->userId
		)->fetch();

		return (0 === (int) $user['day']) ? true : false;
	}

	public function buyGifts($gifts) {
		$db = $this->getDB();

		foreach ($gifts as $id => $quantity) {
			if (empty($quantity)) {
				$db->query(
					"DELETE FROM user_basket WHERE user_id = ? AND gift_id = ?",
					array($this->userId, $id)
				);
			} else {
				$db->query(
					"REPLACE INTO user_basket (user_id, gift_id, quantity) " .
					"VALUES (?, ?, ?)",
					array($this->userId, $id, $quantity)
				);
			}
		}
	}

	public function getBoughtGifts() {
		$gifts = $this->getDB()->query(
			"SELECT g.name, g.price, quantity FROM user_basket ub " .
			"INNER JOIN gift g ON (g.gift_id = ub.gift_id) " .
			"WHERE user_id = ?",
			$this->userId
		)->fetchAll();

		return array_map(function($gift) {
			$gift['total'] = $gift['quantity'] * $gift['price'];
			return $gift;
		}, $gifts);
	}

	public function boughtGifts() {
		$gifts = $this->getDB()->query(
			"SELECT gift_id FROM user_basket WHERE user_id = ?",
			$this->userId
		)->fetch();

		return ($gifts && count($gifts) > 0);
	}

	protected function _updateLastLogin() {
		$this->getDB()->query(
			"UPDATE user SET lastlogin = datetime('now') WHERE user_id = ?",
			$this->userId
		);
	}

}

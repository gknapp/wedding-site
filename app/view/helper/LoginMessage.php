<?php

class View_Helper_LoginMessage extends Zend_View_Helper_Abstract {

	public function loginMessage() {
		$msg = 'Please enter your passcode to login';
		if ($this->view->user->getSession()->loginAttempt &&
			!$this->view->user->loggedIn()) {
			$msg = 'Your passcode is incorrect';
			$msg = sprintf('<span class="alert">%s</span>', $msg);
		}

		return $msg;
	}

}

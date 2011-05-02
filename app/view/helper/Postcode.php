<?php

class View_Helper_Postcode extends Zend_View_Helper_Abstract {

	public function postcode() {
		$user = $this->view->user;
		if (!$user->loggedIn())
			return '';

		return $this->view->escape($user->getPostcode());
	}

}

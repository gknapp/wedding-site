<?php

class View_Helper_Greeting extends Zend_View_Helper_Abstract {

	public function greeting() {
		$user = $this->view->user;
		if (!$user->loggedIn())
			return '';
		$guests = $user->getGuests();
		$firstNames = array_map(function($guest) {
				return $guest->forename;
			}, $guests
		);
		return $this->view->escape(join(' & ', $firstNames));
	}

}

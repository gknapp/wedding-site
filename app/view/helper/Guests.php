<?php

class View_Helper_Guests extends Zend_View_Helper_Abstract {

	public function guests() {
		$guests = $this->view->guests;
		$output = '';

		foreach ($guests as $guest)
			$output .= $this->view->partial('rsvp' . DS . '_guest.phtml', $guest);

		return $output;
	}

}

<?php

class View_Helper_ReceptionDrinks extends Zend_View_Helper_Abstract {

	public function receptionDrinks() {
		$guests = $this->view->guests;
		$output = '';

		foreach ($guests as $guest)
			$output .= $this->view->partial('rsvp' . DS . '_reception.phtml', $guest);

		return $output;
	}

}

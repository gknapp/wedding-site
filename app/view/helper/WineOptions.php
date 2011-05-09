<?php

class View_Helper_WineOptions extends Zend_View_Helper_Abstract {

	public function wineOptions() {
		$guests = $this->view->guests;
		$output = '';

		foreach ($guests as $guest)
			$output .= $this->view->partial('rsvp' . DS . '_wine.phtml', $guest);

		return $output;
	}

}

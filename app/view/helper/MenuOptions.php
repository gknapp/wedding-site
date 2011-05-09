<?php

class View_Helper_MenuOptions extends Zend_View_Helper_Abstract {

	public function menuOptions() {
		$guests = $this->view->guests;
		$output = '';

		foreach ($guests as $guest)
			$output .= $this->view->partial('rsvp' . DS . '_menu.phtml', $guest);

		return $output;
	}

}

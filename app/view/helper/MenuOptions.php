<?php

class View_Helper_MenuOptions extends Zend_View_Helper_Abstract {

	public function menuOptions() {
		return $this->view->partial(
			'rsvp' . DS . '_menu.phtml',
			array('guests' => $this->view->guests)
		);
	}

}

<?php

class View_Helper_Navigation extends Zend_View_Helper_Abstract {

	public function navigation() {
		if ($this->view->user->loggedIn() == false)
			return '';

		$request = new Lib_Request();
		$data = array(
			'tab' => $request->getControllerName(),
			'items' => array(
				array(
					'label' => 'RSVP',
					'controller' => 'rsvp'
				),
				array(
					'label' => 'Directions',
					'controller' => 'directions'
				),
				array(
					'label' => 'Accommodation',
					'controller' => 'accommodation'
				),
				array(
					'label' => 'Gifts',
					'controller' => 'gifts'
				)
			)
		);

		return $this->view->partial('_navigation.phtml', $data);
	}

}

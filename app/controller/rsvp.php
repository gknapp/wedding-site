<?php

class Controller_Rsvp extends Controller_LoggedIn {

	public function index() {
		$this->view->render(
			$this->getControllerName() . DS . 'index.phtml'
		);
	}

}

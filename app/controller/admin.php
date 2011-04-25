<?php

class Controller_Admin extends Lib_Controller {

	public function index() {
		$user = new Model_User($this->getContainer());
		if ($user->loggedIn() && $user->isAdmin()) {
			$this->view->user = $user;
			$this->view->render(
				$this->getRequest()->getControllerName() . DS . 'index.phtml'
			);
		} else {
			$this->getRequest()->redirect('/');
		}
	}

}

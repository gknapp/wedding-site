<?php

class Controller_Admin extends Controller_LoggedIn {

	public function preDispatch() {
		parent::preDispatch();
		if ($this->user->isAdmin() == false)
			$this->getRequest()->redirect('/');
	}

	public function index() {
		$this->view->guests = new Model_Guests(
			$this->getContainer()->database
		);
		$this->view->render();
	}

	public function guestlist() {
		$this->view->render(
			$this->getControllerName() . DS . 'guestlist.phtml'
		);
	}

	public function gifts() {
		$this->view->render(
			$this->getControllerName() . DS . 'gifts.phtml'
		);
	}

}

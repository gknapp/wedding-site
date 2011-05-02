<?php

class Controller_Admin extends Controller_LoggedIn {

	public function preDispatch() {
		parent::preDispatch();
		if ($this->user->isAdmin() == false)
			$this->getRequest()->redirect('/');
	}

	public function index() {
		$this->view->render(
			$this->getControllerName() . DS . 'index.phtml'
		);
	}

	public function guestlist() {
		//$guestlist = new Model_Guestlist($this->getContainer());
		//$this->view->guestlist =
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

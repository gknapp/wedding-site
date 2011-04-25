<?php

class Controller_Logout extends Lib_Controller {

	public function index() {
		$user = new Model_User($this->getContainer());
		$user->logout();
		$this->getRequest()->redirect('/');
	}

}

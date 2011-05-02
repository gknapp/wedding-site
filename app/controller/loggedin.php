<?php

class Controller_LoggedIn extends Lib_Controller {

	protected $user;

	public function preDispatch() {
		parent::preDispatch();
		$this->user = new Model_User($this->getContainer());
		$this->mustBeLoggedIn();
		$this->view->user = $this->user;
	}

	public function mustBeLoggedIn() {
		if ($this->user->loggedIn() == false)
			$this->getRequest()->redirect('/');
	}

}

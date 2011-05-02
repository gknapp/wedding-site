<?php

class Controller_Index extends Lib_Controller {

	protected $user;

	public function index() {
		$this->view->user = $user = new Model_User($this->getContainer());
		$this->_layout->setLayout('public');
		if ($user->isAdmin())
			$this->getRequest()->redirect('/admin');
		else if ($user->loggedIn())
			$this->getRequest()->redirect('/rsvp');
		else
			$this->view->render('public.phtml');
	}

}

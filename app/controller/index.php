<?php

class Controller_Index extends Lib_Controller {

	public function index() {
		$user = new Model_User($this->getContainer());
		$view = $user->loggedIn() ? 'index.phtml' : 'public.phtml';
		$this->view->user = $user;
		if ($user->isAdmin())
			$this->getRequest()->redirect('/admin');
		else
			$this->view->render('index' . DS . $view);
	}

}

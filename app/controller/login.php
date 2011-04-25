<?php

class Controller_Login extends Lib_Controller {

	public function index() {
		$request = $this->getRequest();
		if ($request->isPost()) {
			$user = new Model_User($this->getContainer());
			$user->login($request);
		}
		$request->redirect('/');
	}

}

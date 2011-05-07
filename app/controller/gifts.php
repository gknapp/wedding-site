<?php

class Controller_Gifts extends Controller_LoggedIn {

	public function index() {
		$gifts = new Model_Gifts($this->getContainer());
		$this->view->model = $gifts;
		$this->view->render();
	}

}

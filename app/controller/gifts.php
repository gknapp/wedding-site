<?php

class Controller_Gifts extends Controller_LoggedIn {

	public function index() {
		$gifts = new Model_Gifts($this->getContainer());
		$this->view->model = $gifts;
		$this->view->render();
	}

	public function buy() {
		$request = $this->getRequest();
		if (!$request->isPost())
			$request->redirect('/gifts');

		$post = $request->getPost();

		if (isset($post['gift']))
			$this->user->buyGifts($post['gift']);

		$this->view->post = $post;
		$this->view->render($this->getControllerName() . DS . 'thanks.phtml');
	}

}

<?php

class Controller_Rsvp extends Controller_LoggedIn {

	public function index() {
		$this->view->guests = $this->user->getGuests();
		$this->view->render(
			$this->getControllerName() . DS . 'index.phtml'
		);
	}

	public function attending() {
		$request = $this->getRequest();
		if (!$request->isPost())
		  $request->redirect('/rsvp');

		$this->_layout->disableLayout();

		foreach ($this->user->getGuests() as $guest) {
			if ($guest->guestId == $request->getPost('guest')) {
				$guest->rsvp($request->getPost('rsvp'));
				echo 'success';
				return;
			}
		}

		echo 'failed';
	}

}

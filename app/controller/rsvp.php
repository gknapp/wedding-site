<?php

class Controller_Rsvp extends Controller_LoggedIn {

	public function index() {
		$this->view->guests = $this->user->getGuests();
		$this->view->render();
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

	public function reception() {
		$request = $this->getRequest();
		if (!$request->isPost())
		  $request->redirect('/rsvp');

		$this->_layout->disableLayout();

		foreach ($this->user->getGuests() as $guest) {
			if ($guest->guestId == $request->getPost('guest')) {
				$guest->setReception($request->getPost('reception'));
				echo 'success';
				return;
			}
		}

		echo 'failed';
	}

	public function menu() {
		$request = $this->getRequest();
		if (!$request->isPost())
		  $request->redirect('/rsvp');

		$this->_layout->disableLayout();

		foreach ($this->user->getGuests() as $guest) {
			if ($guest->guestId == $request->getPost('guest')) {
				$guest->setMenu($request->getPost('menu'));
				echo 'success';
				return;
			}
		}

		echo 'failed';
	}

	public function dietary() {
		$request = $this->getRequest();
		if (!$request->isPost())
		  $request->redirect('/rsvp');

		$this->_layout->disableLayout();

		foreach ($this->user->getGuests() as $guest) {
			if ($guest->guestId == $request->getPost('guest_id')) {
				$guest->setDietary($request->getPost('requirements'));
				echo 'success';
				return;
			}
		}

		echo 'failed';
	}

	public function wine() {
		$request = $this->getRequest();
		if (!$request->isPost())
		  $request->redirect('/rsvp');

		$this->_layout->disableLayout();

		foreach ($this->user->getGuests() as $guest) {
			if ($guest->guestId == $request->getPost('guest')) {
				$guest->setWine($request->getPost('wine'));
				echo 'success';
				return;
			}
		}

		echo 'failed';
	}

}

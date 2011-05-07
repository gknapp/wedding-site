<?php

class View_Helper_Gifts extends Zend_View_Helper_Abstract {

	public function gifts() {
		$gifts = $this->view->model->getList();

		// deduct this users purchased gifts
		$bought = $this->view->user->getBoughtGifts();

		foreach ($bought as $bgift) {
			foreach ($gifts as $i => $gift) {
				if ($gift->name == $bgift['name']) {
					$gift->requested -= $bgift['quantity'];
					$gift->quantity = $bgift['quantity'];
					$gifts[$i] = $gift;
				}
			}
		}

		$output = '';

		foreach ($gifts as $gift) {
			$output .= $this->view->partial('gifts' . DS . '_row.phtml', $gift);
		}

		return $output;
	}

}

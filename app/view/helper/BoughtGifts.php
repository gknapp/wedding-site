<?php

class View_Helper_BoughtGifts extends Zend_View_Helper_Abstract {

	public function boughtGifts() {
		$gifts = $this->view->user->getBoughtGifts();
		$output = '';

		foreach ($gifts as $gift) {
			$output .= sprintf(
				'<li>%s x %s - £%s</li>',
				$gift['quantity'], $gift['name'], $gift['total']
			);
		}

		return $output;
	}

}

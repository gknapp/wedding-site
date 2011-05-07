<?php

class View_Helper_Gifts extends Zend_View_Helper_Abstract {

	public function gifts() {
		$gifts = $this->view->model->getList();
		$output = '';

		foreach ($gifts as $gift) {
			$output .= $this->view->partial('gifts' . DS . '_row.phtml', $gift);
		}

		return $output;
	}

}

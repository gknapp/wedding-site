<?php

class Model_Gifts extends Lib_Model {

	public function getList() {
		$gifts = $this->getDB()->query(
			"SELECT * FROM gift ORDER BY price ASC"
		)->fetchAll();

		$parent = $this; // can't pass $this as lexical variable
		return array_map(
			function ($data) use ($parent) {
				$gift = new Model_Gift($parent->getContainer());
				$gift->populate($data);
				return $gift;
			}, $gifts
		);
	}

}

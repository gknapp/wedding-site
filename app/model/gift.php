<?php

class Model_Gift extends Lib_Model {

	public $giftId;
	public $name;
	public $description;
	public $price;
	public $requested;
	public $quantity;

	public function populate($data) {
		$this->giftId = $data['gift_id'];
		$this->name = $data['name'];
		$this->description = $data['description'];
		$this->price = $data['price'];
		$this->requested = $data['requested'];
		$this->quantity = 0; // how many a user has bought
	}

}

<?php

class ServiceNotRegisteredException extends Exception {}

class Lib_Container {

	protected $services = array();

	function __set($id, $service) {
		$this->services[$id] = $service;
	}

	function __get($id) {
		if (!isset($this->services[$id])) {
			throw new ServiceNotRegisteredException(
				"Service '$id' has not been registered"
			);
		}

		if (is_callable($this->services[$id])) {
			return $this->services[$id]($this);
		}

		return $this->services[$id];
	}

	function hasService($id) {
		return isset($this->services[$id]);
	}

	function asSingleton($construct) {
		return function ($c) use ($construct) {
			static $instance;

			if (is_null($instance)) {
				$instance = $construct($c);
			}

			return $instance;
		};
	}

}

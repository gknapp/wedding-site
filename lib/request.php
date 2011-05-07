<?php

class Lib_Request {

	private $_sources = array('_GET', '_POST', '_COOKIE', '_SERVER');
	private $_path;
	private $_querystring;

	public function __construct() {
		$parts = parse_url($_SERVER['REQUEST_URI']);
		$this->_path = $parts['path'];
		if (isset($parts['query']))
			$this->_querystring = $parts['query'];
	}

	public function __get($key) {
		foreach ($this->_sources as $src) {
			if (isset($$src[$key]))
				return $$src[$key];
		}
	}

	public function redirect($location) {
		header('Location: ' . $location);
		exit;
	}

	public function getPath() {
		return $this->_path;
	}

	public function getQuerystring() {
		return $this->_querystring;
	}

	public function isPost() {
		return ($this->getMethod() == 'POST');
	}

	public function getPost($elem = null) {
		if ($elem && isset($_POST[$elem]))
			return $_POST[$elem];
		return $_POST;
	}

	public function getCookie($elem = null) {
		if ($elem && isset($_COOKIE[$elem]))
			return $_COOKIE[$elem];
		return $_COOKIE;
	}

	public function getServer($elem = null) {
		if ($elem && isset($_SERVER[$elem]))
			return $_SERVER[$elem];
		return $_SERVER;
	}

	public function getMethod() {
		if (isset($_SERVER['REQUEST_METHOD']))
			return $_SERVER['REQUEST_METHOD'];
	}

	public function getControllerName() {
		$path = substr($this->getPath(), 1);
		$controller = '';

		if (!empty($path))
			list($controller) = explode('/', strtolower($path));

		return $controller;
	}

	public function getActionName() {
		$path = substr($this->getPath(), 1);
		$bits = explode('/', strtolower($path));
		return isset($bits[1]) ? $bits[1] : '';
	}

}

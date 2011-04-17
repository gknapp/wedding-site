<?php

class Request {

	private $_sources = array('_GET', '_POST');
	private $_path;
	private $_querystring;

	public function __construct() {
		$parts = parse_url($_SERVER['REQUEST_URI']);
		$this->_path = $parts['path'];
		if (isset($parts['query']))
			$this->_querystring = $parts['query'];
	}

	public function getPath() {
		return $this->_path;
	}

	public function getQuerystring() {
		return $this->_querystring;
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
		return ($path) ? explode('/', $path, 1) : '';
	}

	public function getActionName() {
		$path = substr($this->getPath(), 1);
		$bits = explode('/', $path);
		return isset($bits[1]) ? $bits[1] : '';
	}

}

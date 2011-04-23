<?php

class Lib_Model {

	protected $_database;
	protected $_request;
	protected $_session;
	protected $_sessionName = 'default';

	private $_sessionInstance;

	public function __construct($container) {
		$this->_database = $container->database;
		$this->_request = $container->request;
		$this->_session = $container->session;
	}

	public function getDB() {
		return $this->_database;
	}

	public function getRequest() {
		return $this->_request;
	}

	public function getSession($ns = null) {
		$ns = ($ns == null) ? $this->_sessionName : $ns;
		if (!isset($this->_sessionInstance[$ns])) {
			$sessionFactory = $this->_session;
			$this->_sessionInstance[$ns] = $sessionFactory($ns);
		}
		return $this->_sessionInstance[$ns];
	}

}

<?php

class Lib_Model {

	protected $_container;
	protected $_sessionName = 'default';

	private $_sessionInstance;

	public function __construct($container) {
		$this->_container = $container;
	}

	public function getContainer() {
		return $this->_container;
	}

	public function getDB() {
		return $this->getContainer()->database;
	}

	public function getRequest() {
		return $this->getContainer()->request;
	}

	public function getSession($ns = null) {
		$ns = ($ns == null) ? $this->_sessionName : $ns;
		if (!isset($this->_sessionInstance[$ns])) {
			$sessionFactory = $this->getContainer()->session;
			$this->_sessionInstance[$ns] = $sessionFactory($ns);
		}
		return $this->_sessionInstance[$ns];
	}

}

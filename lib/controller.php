<?php

class Lib_Controller {

	protected $view;
	protected $_layout;
	protected $_container;

	public function __construct($container) {
		$this->_container = $container;
		$this->_setupView();
	}

	public function getRequest() {
		return $this->_container->request;
	}

	public function getControllerName() {
		return $this->getRequest()->getControllerName();
	}

	public function getContainer() {
		return $this->_container;
	}

	public function preDispatch() {}

	public function postDispatch() {
		echo $this->_renderView();
	}

	protected function _setupView() {
		$viewBase = BASEDIR . APPDIR . DS . 'view' . DS;
		$this->_layout = new Zend_Layout(array(
			'layout' => 'default',
			'layoutPath' => $viewBase . DS . 'layout'
		));
		$this->view = new Lib_View(array(
			'strictVars' => true
		));
		$this->view->setScriptPath($viewBase . 'scripts');
		$this->view->addHelperPath($viewBase . 'helper', 'View_Helper');
		$this->_layout->setView($this->view);
	}

	protected function _renderView() {
		$this->_layout->content = $this->view->buffer;
		return $this->_layout->render();
	}

}

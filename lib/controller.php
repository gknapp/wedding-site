<?php

class Lib_Controller {

	protected $_layout;
	protected $_view;
	protected $_container;

	public function __construct($container) {
		$this->_container = $container;
		$this->_setupView();
	}

	public function getRequest() {
		return $this->_container->request;
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
		$this->_view = new Lib_View(array(
			'strictVars' => true
		));
		$view = $this->_view->getView();
		$view->setScriptPath(
			$viewBase . DS . 'scripts' . DS . $this->_getControllerName()
		);
		$view->addHelperPath($viewBase . DS . 'helper');
		$this->_layout->setView($view);
	}

	protected function _getControllerName() {
		$name = $this->getRequest()->getControllerName();
		if (empty($name))
			$name = Lib_Dispatcher::DEFAULT_CONTROLLER;
		return $name;
	}

	protected function _renderView() {
		$this->_layout->content = $this->_view->buffer;
		return $this->_layout->render();
	}

}

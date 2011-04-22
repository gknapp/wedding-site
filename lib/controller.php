<?php

class Lib_Controller {

	protected $layout;
	protected $view;

	public function __construct() {
		$this->_setupView();
	}

	public function preDispatch() {}

	public function postDispatch() {
		echo $this->_renderView();
	}

	protected function _setupView() {
		$viewBase = BASEDIR . APPDIR . DS . 'view' . DS;
		$this->layout = new Zend_Layout(array(
			'layout' => 'default',
			'layoutPath' => $viewBase . DS . 'layout'
		));
		$this->view = new Lib_View(array(
			'strictVars' => true
		));
		$view = $this->view->getView();
		$view->setScriptPath(
			$viewBase . DS . 'scripts' . DS . $this->_getControllerName()
		);
		$view->addHelperPath($viewBase . DS . 'helper');
		$this->layout->setView($view);
	}

	protected function _getControllerName() {
		$request = new Lib_Request();
		$name = $request->getControllerName();
		if (empty($name))
			$name = Lib_Dispatcher::DEFAULT_CONTROLLER;
		return $name;
	}

	protected function _renderView() {
		$this->layout->content = $this->view->buffer;
		return $this->layout->render();
	}

}

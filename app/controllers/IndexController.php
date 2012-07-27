<?php

class IndexController extends Phalcon_Controller
{
	protected function initilize() {

	}

	function indexAction()
	{
		 $this->view->setTemplateAfter('web');
	}

}

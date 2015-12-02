<?php

namespace Application;

use \Application\Controller\Controller;

class Application
{
    protected $_config;

    public function init($config)
    {
        $this->_setConfig($config);
        return $this;
    }

    protected function _setConfig($config)
    {
        $this->_config = $config;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function run()
    {
        $controller = new Controller;
        $controller->indexAction($this);
    }

}
<?php

namespace Application\Services\Client\Request;

use \Application\Services\Client\Request\Adapter\IRequest;

class Request
{
    protected $_adapter;
    protected $_config;
    protected $_method;

    public function __construct(IRequest $adapter, Array $config)
    {
        $this->_init($adapter, $config);
    }

    protected function _init(IRequest $adapter, Array $config)
    {
        $events = isset($config['request']['events']) ? $config['request']['events'] : array();
        $method = isset($config['request']['method']) ? $config['request']['method'] : '';

        $this->_setAdapter($adapter);
        $this->_setConfig($config);
        $this->_setEvents($events);
        $this->_setMethod($method);
        
        return $this;
    }

    protected function _setAdapter(IRequest $adapter)
    {
        $this->_adapter = $adapter;
    }
    
    protected function _setConfig(Array $config)
    {
        $this->_config = $config;
    }
    protected function _setEvents(Array $events)
    {
        $this->_events = $events;
    }
    protected function _setMethod($method)
    {
        $this->_method = $method;
    }

    public function makeRequest()
    {
        $this->_adapter->makeRequest($this);
        return $this;
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    protected function getMethod()
    {
        return $this->_method;
    }

    public function get()
    {
        return $this->_adapter->getResponse();
    }

}
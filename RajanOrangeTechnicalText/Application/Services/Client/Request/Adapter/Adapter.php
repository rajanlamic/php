<?php

namespace Application\Services\Client\Request\Adapter;

use \Application\Services\Client\Request\Request;

abstract class Adapter implements IRequest
{
    protected $_url;
    protected $_data;
    protected $_response;
    protected $_request;

    const STATUS_CONNECTION_FAIL = 0;
    const STATUS_SUCCESS = 1;

    public function __construct()
    {
        
    }

    protected function _initRequest(Request $request)
    {
        $this->_setRequest($request);
        $this->_setUrl();
        $this->_setData();
    }

    protected function _setRequest($request)
    {
        $this->_request = $request;
    }

    protected function _setUrl()
    {
        $config = $this->getRequest()->getConfig();
        $service = isset($config['request']['service']) ? $config['request']['service'] : '';
        $method = isset($config['request']['method']) ? $config['request']['method'] : '';
        $websiteUrl = isset($config['services'][$service]['url']) ? $config['services'][$service]['url'] : '';
        $namespace = isset($config['services'][$service]['methods'][$method]['namespace']) ? $config['services'][$service]['methods'][$method]['namespace'] : '';

        $this->_url = $websiteUrl . $namespace;
    }

    protected function _setData()
    {
        $config = $this->getRequest()->getConfig();
        $data = isset($config['request']['data']) ? $config['request']['data'] : array();

        $out = '';
        if (count($data) > 0) {
            $amersand = '';
            foreach ($data as $key => $each) {
                $out .= $amersand . $key . '=' . $each;
                $amersand = '&';
            }
        }

        $this->_data = $out;
    }

    protected function getUrl()
    {
        return $this->_url;
    }

    protected function getData()
    {
        return $this->_data;
    }

    protected function getRequest()
    {
        return $this->_request;
    }

    public function getResponse()
    {
        return $this->_response;
    }

}
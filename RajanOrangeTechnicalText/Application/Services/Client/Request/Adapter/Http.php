<?php

namespace Application\Services\Client\Request\Adapter;

use \Application\Services\Client\Request\Adapter\Adapter;
use \Application\Services\Client\Request\Request;
use \Exception;

class Http extends Adapter
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Make the http post request and get the response back
     */
    public function makeRequest(Request $request)
    {
        try
        {
            $this->_initRequest($request);
            $response = $this->_doRequest();
            
            $this->_response->code = self::STATUS_SUCCESS;
            $this->_response->message = $response;
        }
        catch (Exception $e)
        {
            $this->_response->code = self::STATUS_CONNECTION_FAIL;
            $this->_response->message = $e->getMessage();
        }
    }

    protected function _doRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded'));
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData());

        $result = curl_exec($ch);

        if($result === false)
        {
            throw new Exception(curl_error($ch), 1001);
        }

        curl_close($ch);

        return $result;
    }

}
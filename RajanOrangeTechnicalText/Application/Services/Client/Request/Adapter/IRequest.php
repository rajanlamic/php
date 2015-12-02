<?php

namespace Application\Services\Client\Request\Adapter;
use \Application\Services\Client\Request\Request;

interface IRequest
{
    /**
     * Make the request
     */
    public function makeRequest(Request $request);

    /**
     * Get the response
     */
    public function getResponse();
}
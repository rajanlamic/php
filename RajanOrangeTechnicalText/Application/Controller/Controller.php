<?php

namespace Application\Controller;

use \Application\Services\Client\Request\Adapter\Http;
use \Application\Services\Client\Request\Request;

class Controller
{
    public function indexAction($application)
    {
        echo $this->getView();

        $request = $this->getRequest();
        $submit = isset($request['submit']) ? $request['submit'] : '';

        if ($submit) {
            $top = isset($request['top']) ? $request['top'] : '';
            $years = $this->getYears($request);

            $yearIterator = new \ArrayIterator($years);
            while ($yearIterator->valid()) {

                $params = array(
                    'request' => array(
                        'service' => 'socialsecurity',
                        'method' => 'getPolularity',
                        'data' => array(
                            'year' => $yearIterator->current(),
                            'top' => $top,
                            'number' => 'n',
                        ),
                    ),
                );

                $request = new Request(
                        new Http(), array_merge($params, $application->getConfig())
                );

                $rawResponse = $request->makeRequest()
                        ->get();

                echo $rawResponse->message;

                $yearIterator->next();
            }
        }
    }

    protected function getRequest()
    {
        return isset($_POST) ? $_POST : array();
    }

    protected function getView()
    {
        require 'View/View.html';
    }

    protected function getYears($request)
    {
        $yearFrom = (Int) isset($request['yearFrom']) ? $request['yearFrom'] : 0;
        $yearTo = (Int) isset($request['yearTo']) ? $request['yearTo'] : 0;

        $message = '';
        if ($yearFrom < 1880 || $yearFrom > 2010 || $yearTo < 1880 || $yearTo > 2010) {
            $message = "Date range should be 1880 to 2010";
        } else if ($yearFrom > $yearTo) {
            $message = "Date range not valid";
        }

        if ($message) {
            die($message);
        }

        $out = array();
        while ($yearTo >= $yearFrom) {
            $out[] = $yearFrom;
            $yearFrom++;
        }
        return $out;
    }

}
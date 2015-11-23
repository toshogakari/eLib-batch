<?php

namespace App\ActiveResources\Results;

use GuzzleHttp\Psr7\Response;

abstract class AbstractResult implements InterfaceResult
{

    protected $permit = [];

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

}
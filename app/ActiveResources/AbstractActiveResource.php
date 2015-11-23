<?php

namespace App\ActiveResources;

use App\ActiveResources\Exceptions\ClassNotFoundException;
use App\ActiveResources\Exceptions\InvalidInstanceException;
use App\ActiveResources\Exceptions\UndefinedProviderException;
use App\ActiveResources\Results\AbstractResult;
use App\ActiveResources\Results\ErrorResult;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Purl\Url;

abstract class AbstractActiveResource
{
    /**
     * @var string
     */
    protected $site;
    /**
     * @var string
     */
    protected $token;
    /**
     * @var array
     */
    protected $conditions = [];
    /**
     * @var mixed
     */
    protected $contents;
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $providers = [
        'Result' => null
    ];

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->initialize();

        if (!isset($this->providers['Result'])) {
            throw new UndefinedProviderException(
                'undefined set Result provider.');
        }

        if (!class_exists($this->providers['Result'])) {
            throw new ClassNotFoundException(
                'providers class not found to ' . $this->providers['Result']);
        }

        $this->client = new Client();
    }

    /**
     * Set Initialize Properties.
     * @return void
     */
    abstract protected function initialize();

    /**
     * join url to site and token .
     * @return string
     */
    abstract public function joinTokenUrl();


    /**
     * @param array $urls
     * @return ErrorResult|array
     */
    public function getMultiProcess(array $urls)
    {
        try {
            $promises = [];
            foreach ($urls as $key => $url) {
                $promises[$key] = $this->client->getAsync($url);
            }
            $responses = Promise\unwrap($promises);
            $ret = [];
            /** @var Response $response */
            foreach ($responses as $response) {
                $ret[] = $this->result($response);
            }
            return $ret;
        }
        catch (\Exception $e) {
            $ret = new ErrorResult;
        }
        return $ret;
    }

    /**
     * @return \App\ActiveResources\Results\AbstractResult
     */
    public function get()
    {
        try {
            $url = new Url($this->joinTokenUrl());
            $this->addQueries($url);
            $response = $this->client->request('GET', $url->__toString());
            $result = $this->result($response);
        }
        catch (\Exception $e) {
            $result = new ErrorResult;
        }

        return $result;
    }

    /**
     * @param array $conditions
     * @return $this
     */
    public function conditions(array $conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return $this
     */
    public function clearConditions()
    {
        $this->conditions = [];
        return $this;
    }

    /**
     * @param Response $response
     * @return AbstractResult
     */
    private function result(Response $response)
    {
        /** @var AbstractResult $result */
        $result  = new $this->providers['Result']($response);

        if (!$result instanceof AbstractResult) {
            throw new InvalidInstanceException(
                'invalid instance to ' . get_class($result));
        }

        return $result;
    }

    /**
     * @param Url $url
     */
    private function addQueries(Url $url)
    {
        if (!empty($this->conditions)) {
            foreach ($this->conditions as $k => $v) {
                $url->query->set($k, $v);
            }
            $this->clearConditions();
        }
    }

}
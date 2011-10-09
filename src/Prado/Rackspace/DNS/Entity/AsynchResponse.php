<?php

namespace Prado\Rackspace\DNS\Entity;

use Prado\Rackspace\DNS\Entity;

class AsynchResponse implements Entity
{
    /**
     * @var string
     */
    protected $jobId;
    
    /**
     * @var string
     */
    protected $request;
    
    /**
     * @var string
     */
    protected $response;
    
    /**
     * @var string
     */
    protected $status;
    
    /**
     * @var string
     */
    protected $error;
    
    /**
     * @var string
     */
    protected $verb;
    
    /**
     * @var string
     */
    protected $requestUrl;
    
    /**
     * @var string
     */
    protected $callbackUrl;
    
    public function __construct()
    {
        
    }
    
	/**
     * @return the $jobId
     */
    public function getJobId()
    {
        return $this->jobId;
    }

	/**
     * @return the $request
     */
    public function getRequest()
    {
        return $this->request;
    }

	/**
     * @return the $response
     */
    public function getResponse()
    {
        return $this->response;
    }

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @return the $error
     */
    public function getError()
    {
        return $this->error;
    }

	/**
     * @return the $verb
     */
    public function getVerb()
    {
        return $this->verb;
    }

	/**
     * @return the $requestUrl
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

	/**
     * @return the $callbackUrl
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

	/**
     * @param string $jobId
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    }

	/**
     * @param string $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

	/**
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

	/**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

	/**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

	/**
     * @param string $verb
     */
    public function setVerb($verb)
    {
        $this->verb = $verb;
    }

	/**
     * @param string $requestUrl
     */
    public function setRequestUrl($requestUrl)
    {
        $this->requestUrl = $requestUrl;
    }

	/**
     * @param string $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }
}

<?php

namespace Prado\Rackspace\Http;

use Zend\Http\Headers;
use Zend\Http\Client as ZendClient;
use Zend\Http\Request as ZendRequest;

class Client
{
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    /**
     * @var Prado\Rackspace\Http\AuthInterface
     */
    protected $_auth;
    
    /**
     * @var Zend\Http\Client
     */
    protected $_client;
    
    /**
     * Constructor.
     *  
     * @param Zend\Http\Client $client
     */
    public function __construct(ZendClient $client, AuthInterface $auth)
    {
        $this->_client = $client;
        $this->_auth   = $auth;
    }
    
    /**
     * @param string $uri The URI to GET
     * @return Zend\Http\Response The Zend Response generated.
     */
    public function get($uri)
    {
        $request = new ZendRequest;
        $request->setUri($uri);
        $request->setMethod(ZendRequest::METHOD_GET);
        $request->headers()->addHeaders(array_merge(array(
        	'Accept' => self::RESPONSE_FORMAT
        ), $this->_auth->getAuthHeaders()));
        
        $response = $this->_client->send($request);
    
        if (!$response->isSuccess()) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }
        
        return $response;
    }
    
    /**
     * @param string $uri The URI to GET
     * @return Zend\Http\Response The Zend Response generated.
     */
    public function post($uri, $data)
    {
        $request = new ZendRequest;
        $request->setUri($uri);
        $request->setMethod(ZendRequest::METHOD_POST);
        $request->setContent(json_encode($data));
        $request->headers()->addHeaders(array_merge(array(
            'Content-Type' => self::CONTENT_TYPE,
        	'Accept' => self::RESPONSE_FORMAT
        ), $this->_auth->getAuthHeaders()));
        
        $response = $this->_client->send($request);
        
        if (!$response->isSuccess()) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }
        
        return $response;
    }
}

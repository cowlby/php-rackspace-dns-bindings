<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Storage\StorageInterface;
use Zend\Http\Request as ZendRequest;
use Zend\Http\Client as ZendClient;

class RequestGenerator
{
    const KEY_AUTH_TOKEN = 'rs_dns.auth_token';
    const KEY_ACCOUNT_ID = 'rs_dns.account_id';
    
    const API_BASE    = 'https://dns.api.rackspacecloud.com';
    const API_VERSION = '/v1.0';
    
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    /**
     * @var string
     */
    protected $username;
    
    /**
     * @var string
     */
    protected $apiKey;
    
    /**
     * @var Prado\Rackspace\DNS\Storage\StorageInterface
     */
    protected $_storage;
    
    public function __construct($username, $apiKey, StorageInterface $storage)
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->_storage = $storage;
    }
    
    /**
     * @param string $path The path to the resource.
     * @return Zend\Http\Request
     */
    public function createRequest($path = '')
    {
        $request = new ZendRequest;
        $request->setUri($this->getEndpoint() . $path);
        $request->headers()->addHeaders(array(
            'Content-Type' => self::CONTENT_TYPE,
        	'Accept'       => self::RESPONSE_FORMAT,
            'X-Auth-Token' => $this->getAuthToken()
        ));
        
        return $request;
    }
    
    public function getEndpoint()
    {
        return self::API_BASE . self::API_VERSION . '/' . $this->getAccountId();
    }
    
    public function getAuthToken()
    {
        $authToken = $this->_storage->retrieve($this->getAuthTokenKey());
        
        if (NULL === $authToken) {
            
            $this->authenticate();
            $authToken = $this->_storage->retrieve($this->getAuthTokenKey());
        }
        
        return $authToken;
    }
    
    public function getAccountId()
    {
        $accountId = $this->_storage->retrieve($this->getAccountIdKey());
        
        if (NULL === $accountId) {
            
            $this->authenticate();
            $accountId = $this->_storage->retrieve($this->getAccountIdKey());
        }
        
        return $accountId;
    }
    
    public function getAuthTokenKey()
    {
        return md5(sprintf('%s:%s:%s', $this->username, $this->apiKey, self::KEY_AUTH_TOKEN));
    }
    
    public function getAccountIdKey()
    {
        return md5(sprintf('%s:%s:%s', $this->username, $this->apiKey, self::KEY_ACCOUNT_ID));
    }
    
    public function authenticate()
    {
        $request = new ZendRequest;
        $request->setMethod(ZendRequest::METHOD_GET);
        $request->setUri('https://auth.api.rackspacecloud.com/v1.0');
        $request->headers()->addHeaders(array(
            'X-Auth-User' => $this->username,
            'X-Auth-Key'  => $this->apiKey
        ));
        
        $client = new ZendClient;
        $response = $client->send($request);
        
        if (!$response->isSuccess()) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }
        
        $authToken = $response->headers()->get('X-Auth-Token')->getFieldValue();
        $serverUrl = $response->headers()->get('X-Server-Management-Url')->getFieldValue();
        $accountId = substr($serverUrl, strrpos($serverUrl, '/') + 1);
        
        $this->_storage->store($this->getAuthTokenKey(), $authToken);
        $this->_storage->store($this->getAccountIdKey(), $accountId);
        
        echo $this->_storage->retrieve($this->getAuthTokenKey());
        die;
        
        return TRUE;
    }
}

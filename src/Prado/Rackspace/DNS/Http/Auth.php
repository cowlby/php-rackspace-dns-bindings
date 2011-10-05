<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Storage\Storable;
use Prado\Rackspace\DNS\Storage\StorageInterface;
use Zend\Http\Headers;
use Zend\Http\Client as ZendClient;
use Zend\Http\Request as ZendRequest;

class Auth implements AuthInterface, Storable
{
    const KEY_AUTH_TOKEN = 'prado.rackspace.dns.auth_token';
    
    protected $username;
    
    protected $apiKey;
    
    protected $_client;
    
    protected $_storage;
    
    public function __construct($username, $apiKey, ZendClient $client)
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->_client  = $client;
    }
    
    public function getStorage()
    {
        return $this->_storage;
    }
    
    public function hasStorage()
    {
        return isset($this->_storage);
    }
    
    public function setStorage(StorageInterface $storage)
    {
        $this->_storage = $storage;
    }
    
    public function getAuthHeaders()
    {
        $authToken = NULL;
        
        if ($this->hasStorage()) {
            $authToken = $this->_storage->retrieve(self::KEY_AUTH_TOKEN);
        }
        
        if (NULL === $authToken) {
            
            $request = new ZendRequest;
            $request->setMethod(ZendRequest::METHOD_GET);
            $request->setUri('https://auth.api.rackspacecloud.com/v1.0');
            $request->headers()->addHeaders(array(
                'X-Auth-User' => $this->username,
                'X-Auth-Key'  => $this->apiKey
            ));
            
            $response = $this->_client->send($request);
            
            if (!$response->isSuccess()) {
                throw new \Exception($response->getBody(), $response->getStatusCode());
            }
            
            $authToken = $response->headers()->get('X-Auth-Token')->getFieldValue();
            
            if ($this->hasStorage()) {
                $this->_storage->store(self::KEY_AUTH_TOKEN, $authToken);
            }
        }
        
        return array('X-Auth-Token' => $authToken);
    }
}

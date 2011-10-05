<?php

namespace Prado\Rackspace\DNS\RequestGenerator

class RequestGenerator implements AuthInterface, Storable
{
    const KEY_AUTH_TOKEN = 'prado.rackspace.dns.auth_token';
    const KEY_ACCOUNT_ID = 'prado.rackspace.dns.account_id';
    
    protected $username;
    
    protected $apiKey;
    
    protected $authToken;
    
    protected $accountId;
    
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
        $authToken = $accountId = NULL;
        
        if ($this->hasStorage()) {
            
            $accountId = $this->_storage->retrieve(self::KEY_ACCOUNT_ID);
            $authToken = $this->_storage->retrieve(self::KEY_AUTH_TOKEN);
        }
        
        if (NULL === $authToken || $accountId === NULL) {
            
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
            $serverManagementUrl = $response->headers()->get('X-Server-Management-Url')->getFieldValue();
            $accountId = str_replace('https://servers.api.rackspacecloud.com/v1.0/', '', $serverManagementUrl);
            
            if ($this->hasStorage()) {
                
                $this->_storage->store(self::KEY_ACCOUNT_ID, $accountId);
                $this->_storage->store(self::KEY_AUTH_TOKEN, $authToken);
            }
        }
        
        $this->authToken = $authToken;
        $this->accountId = $accountId;
        
        return array('X-Auth-Token' => $authToken);
    }
}

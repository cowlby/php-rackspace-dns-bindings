<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Exception\CurlException;
use Prado\Rackspace\DNS\Exception\CloudDnsFault;
use Prado\Rackspace\DNS\Storage\StorageInterface;

class CurlAuthenticator implements Authenticator
{
    const AUTH_ENDPOINT_US = 'https://auth.api.rackspacecloud.com/v1.1';
    const AUTH_ENDPOINT_UK = 'https://lon.auth.api.rackspacecloud.com/v1.1';
    
    const SERVICE_ENDPOINT_US = 'https://dns.api.rackspacecloud.com/v1.0';
    const SERVICE_ENDPOINT_UK = 'https://lon.dns.api.rackspacecloud.com/v1.0';
    
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    const KEY_AUTH_TOKEN = 'rs_dns.auth_token';
    const KEY_ACCOUNT_ID = 'rs_dns.account_id';
    
    protected $username;
    
    protected $apiKey;
    
    protected $authToken;
    
    protected $accountId;
    
    protected $fullyAuthenticated;
    
    protected $storage;
    
    public function __construct($username, $apiKey, StorageInterface $storage)
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->storage = $storage;
        $this->fullyAuthenticated = FALSE;
    }
    
    public function getAuthHeaders()
    {
        $authToken = $this->authToken;
        
        if (NULL === $authToken) {
            $authToken = $this->storage->retrieve($this->getAuthTokenKey());
        }
        
        if (NULL === $authToken) {
            $this->authenticate();
            $authToken = $this->authToken;
        }
        
        return array('X-Auth-Token: ' . $authToken);
    }
    
    public function getAccountId()
    {
        $accountId = $this->accountId;
        
        if (NULL === $accountId) {
            $accountId = $this->storage->retrieve($this->getAccountIdKey());
        }
        
        if (NULL === $accountId) {
            $this->authenticate();
            $accountId = $this->accountId;
        }
        
        return $accountId;
    }

    public function setAuthToken($authToken)
    {
        $this->storage->store($this->getAuthTokenKey(), $authToken);
        $this->authToken = $authToken;
    }
    
    public function setAccountId($accountId)
    {
        $this->storage->store($this->getAccountIdKey(), $accountId);
        $this->accountId = $accountId;
    }
    
    public function getAuthTokenKey()
    {
        return md5(sprintf('%s:%s:%s', $this->username, $this->apiKey, self::KEY_AUTH_TOKEN));
    }
    
    public function getAccountIdKey()
    {
        return md5(sprintf('%s:%s:%s', $this->username, $this->apiKey, self::KEY_ACCOUNT_ID));
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.Authenticator::isFullyAuthenticated()
     */
    public function isFullyAuthenticated()
    {
        return $this->fullyAuthenticated;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.Authenticator::authenticate()
     */
    public function authenticate()
    {
        $api = new \Buzz\Browser;
        
        $response = $api->post(self::AUTH_ENDPOINT_US.'/auth', array(
            'Content-Type: application/json',
            'Accept: application/json'
        ), json_encode(array(
            'credentials' => array(
                'username' => $this->username,
                'key' => $this->apiKey
            )
        )));
        
        if (200 !== $statusCode = $response->getStatusCode()) {
            // Auth Exception.
            die;
        }
        
        $data = json_decode($response->getContent(), TRUE);
        echo "<pre>";
        print_r($data);
        die;
        
        $this->setAuthToken($data['auth']['token']['id']);
        $this->setAccountId($accountId);
        
        $this->fullyAuthenticated = TRUE;
    }
}

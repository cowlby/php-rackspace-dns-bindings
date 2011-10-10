<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Fault\DNSFault;

use Prado\Rackspace\DNS\Fault\UnauthorizedFault;
use Prado\Rackspace\DNS\Storage\StorageInterface;

class CurlAuthenticator implements Authenticator
{
    const KEY_AUTH_TOKEN = 'rs_dns.auth_token';
    const KEY_ACCOUNT_ID = 'rs_dns.account_id';
    
    const ENDPOINT_AUTH_US = 'https://auth.api.rackspacecloud.com/v1.0';
    
    protected $username;
    
    protected $apiKey;
    
    protected $authToken;
    
    protected $accountId;
    
    protected $fullyAuthenticated;
    
    protected $_storage;
    
    public function __construct($username, $apiKey, StorageInterface $storage)
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->_storage = $storage;
        $this->fullyAuthenticated = FALSE;
    }
    
    public function getAuthHeaders()
    {
        $authToken = $this->authToken;
        
        if (NULL === $authToken) {
            $authToken = $this->_storage->retrieve($this->getAuthTokenKey());
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
            $accountId = $this->_storage->retrieve($this->getAccountIdKey());
        }
        
        if (NULL === $accountId) {
            $this->authenticate();
            $accountId = $this->accountId;
        }
        
        return $accountId;
    }

    public function setAuthToken($authToken)
    {
        $this->_storage->store($this->getAuthTokenKey(), $authToken);
        $this->authToken = $authToken;
    }
    
    public function setAccountId($accountId)
    {
        $this->_storage->store($this->getAccountIdKey(), $accountId);
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
        $ch = curl_init(self::ENDPOINT_AUTH_US);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__.'/ca.pem');
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'parseAuthHeaders'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-User: ' . $this->username,
            'X-Auth-Key: ' . $this->apiKey
        ));
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch) !== 0) {
            die(curl_error($ch));
        }
        
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($statusCode < 200 || $statusCode >= 300) {
            switch ($statusCode) {
                
                case 401:
                    throw new UnauthorizedFault($response, 401);
                    break;
                    
                default:
                    throw new DnsFault($response, $statusCode);
                    break;
            }
        }
        
        $this->fullyAuthenticated = TRUE;
    }
    
    protected function parseAuthHeaders($ch, $header)
    {
        $matched = preg_match('/X-(Auth-Token|Server-Management-Url): (.*)/', $header, $matches);
        
        if ($matched !== 0) {
            switch ($matches[1]) {
                
                case 'Auth-Token':
                    $authToken = $matches[2];
                    $this->setAuthToken(trim($authToken));
                    break;
                    
                case 'Server-Management-Url':
                    $serverUrl = $matches[2];
                    $accountId = substr($serverUrl, strrpos($serverUrl, '/') + 1);
                    $this->setAccountId(trim($accountId));
                    break;
                    
                default:
                    break;
            }
        }
        
        return strlen($header);
    }
}

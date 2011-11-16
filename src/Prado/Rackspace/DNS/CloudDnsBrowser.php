<?php

namespace Prado\Rackspace\DNS;

use Buzz\Client\ClientInterface;
use Buzz\Message\Response;
use Buzz\Message\Request;
use Prado\Rackspace\DNS\Http\RestInterface;

class CloudDnsBrowser implements RestInterface
{
    const AUTH_VERSION = '/v1.1';
    const AUTH_HOST_US = 'https://auth.api.rackspacecloud.com';
    const AUTH_HOST_UK = 'https://lon.auth.api.rackspacecloud.com';
    
    const SERVICE_VERSION = '/v1.0';
    const SERVICE_HOST_US = 'https://dns.api.rackspacecloud.com';
    const SERVICE_HOST_UK = 'https://lon.dns.api.rackspacecloud.com';
    
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    const KEY_AUTH_TOKEN = 'rs_dns.auth_token';
    const KEY_ACCOUNT_ID = 'rs_dns.account_id';
    
    protected $username;
    
    protected $apiKey;
    
    protected $authToken;
    
    protected $accountId;
    
    protected $fullyAuthenticated;
    
    public function __construct($username, $apiKey, ClientInterface $client)
    {
        $this->username = $username;
        $this->apiKey = $apiKey;
        $this->client = $client;
        $this->fullyAuthenticated = FALSE;
    }
    
    public function get($path)
    {
        return $this->call($path, Request::METHOD_GET);
    }
    
    public function post($path, array $data)
    {
        return $this->call($path, Request::METHOD_POST, json_encode($data));
    }
    
    public function put($path, array $data)
    {
        return $this->call($path, Request::METHOD_PUT, json_encode($data));
    }
    
    public function delete($path)
    {
        return $this->call($path, Request::METHOD_DELETE);
    }
    
    public function call($path, $method, $content = '')
    {
        $this->authenticate();
        
        $resource = self::SERVICE_VERSION.'/'.$this->getAccountId().$path;
        $request = new Request($method, $resource, self::SERVICE_HOST_US);
        $request->setContent($content);
        $request->addHeaders(array(
            'Content-Type: '.self::CONTENT_TYPE,
            'Accept: '.self::RESPONSE_FORMAT,
            'X-Auth-Token: '.$this->getAuthToken()
        ));
        
        $response = new Response;
        $this->client->send($request, $response);
        
        if (200 !== $response->getStatusCode()) {
            
        }
        
        return json_decode($response->getContent(), TRUE);
    }
    
    public function getAuthToken()
    {
        return $this->authToken;
    }
    
    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }
    
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }
    
    public function isFullyAuthenticated()
    {
        return $this->fullyAuthenticated;
    }
    
    public function authenticate()
    {
        $request = new Request('POST', self::AUTH_VERSION.'/auth', self::AUTH_HOST_US);
        
        $request->addHeaders(array(
            'Content-Type: '.self::CONTENT_TYPE,
            'Accept: '.self::RESPONSE_FORMAT
        ));
        
        $request->setContent(json_encode(array(
        	'credentials' => array(
            	'username' => $this->username,
            	'key' => $this->apiKey
            )
        )));
        
        $response = new Response;
        $this->client->send($request, $response);
        
        if (200 !== $statusCode = $response->getStatusCode()) {
            // Auth Exception.
            die;
        }
        
        $data = json_decode($response->getContent(), TRUE);
        
        $authToken = $data['auth']['token']['id'];
        $accountId = array_pop(explode('/', $data['auth']['serviceCatalog']['cloudServers'][0]['publicURL']));
        
        $this->setAuthToken($authToken);
        $this->setAccountId($accountId);
        
        $this->fullyAuthenticated = TRUE;
    }
}

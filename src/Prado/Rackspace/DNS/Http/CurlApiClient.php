<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Fault\DNSFault;
use Prado\Rackspace\DNS\Fault\UnauthorizedFault;

class CurlApiClient implements RestInterface
{
    const ENDPOINT_API_US = 'https://dns.api.rackspacecloud.com/v1.0';
    
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    protected $_auth;
    
    public function __construct(Authenticator $auth)
    {
        $this->_auth = $auth;
    }
    
    public function get($path)
    {
        $ch = curl_init($this->getEndpoint() . $path);
        
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(array(
            'Content-Type: ' . self::CONTENT_TYPE,
        	'Accept: ' . self::RESPONSE_FORMAT,
            'Content-Length: 0'
        ), $this->_auth->getAuthHeaders()));
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch) !== 0) {
            die(curl_error($ch));
        }
        
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($statusCode < 200 || $statusCode >= 300) {
            switch ($statusCode) {
                
                case 401:
                    if (!$this->_auth->isFullyAuthenticated()) {
                        $this->_auth->authenticate();
                        return $this->get($path);
                    }
                    throw new UnauthorizedFault($response, 401);
                    break;
                    
                default:
                    throw new DNSFault($response, $statusCode);
                    break;
            }
        }
        
        $data = json_decode($response, TRUE);
        
        return $data;
    }
    
    public function post($path, $data)
    {
    }
    
    public function put($path, $data)
    {
    }
    
    public function delete($path)
    {
    }
    
    public function getEndpoint()
    {
        return self::ENDPOINT_API_US . '/' . $this->_auth->getAccountId();
    }
}

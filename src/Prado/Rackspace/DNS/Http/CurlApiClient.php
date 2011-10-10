<?php

namespace Prado\Rackspace\DNS\Http;

use Prado\Rackspace\DNS\Exception\CurlException;

class CurlApiClient implements RestInterface
{
    const SERVICE_ENDPOINT_US = 'https://dns.api.rackspacecloud.com/v1.0';
    const SERVICE_ENDPOINT_UK = 'https://lon.dns.api.rackspacecloud.com/v1.0';
    
    const CONTENT_TYPE    = 'application/json';
    const RESPONSE_FORMAT = 'application/json';
    
    const TIMEOUT = 20;
    
    /**
     * @var Prado\Rackspace\DNS\Authenticator
     */
    protected $_auth;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\DNS\Authenticator $auth An Authenticator instance
     */
    public function __construct(Authenticator $auth)
    {
        $this->_auth = $auth;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.RestInterface::get()
     */
    public function get($path)
    {
        $ch = $this->createCurlHandle($path);
        
        $response = $this->execCurlHandle($ch, array($this, 'get'), array($path));
        
        return json_decode($response, TRUE);
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.RestInterface::post()
     */
    public function post($path, array $data)
    {
        $ch = $this->createCurlHandle($path);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = $this->execCurlHandle($ch, array($this, 'post'), array($path, $data));
        
        return json_decode($response, TRUE);
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.RestInterface::put()
     */
    public function put($path, array $data)
    {
        $ch = $this->createCurlHandle($path);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = $this->execCurlHandle($ch, array($this, 'put'), array($path, $data));
        
        return json_decode($response, TRUE);
    }
    
    /**
     * @see Prado\Rackspace\DNS\Http.RestInterface::delete()
     */
    public function delete($path)
    {
        $ch = $this->createCurlHandle($path);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        $response = $this->execCurlHandle($ch, array($this, 'delete'), array($path));
        
        return json_decode($response, TRUE);
    }
    
    /**
     * Creates a curl handle with basic options and headers.
     * 
     * @param string $path    The path to create the handle for
     * @param array  $headers Optional array of additional headers to send
     */
    protected function createCurlHandle($path, array $headers = array())
    {
        $ch = curl_init();
        
        $headers = array_merge(array(
        	'Content-Type: ' . self::CONTENT_TYPE,
    		'Accept: ' . self::RESPONSE_FORMAT,
       ), $headers, $this->_auth->getAuthHeaders());
       
       $options = array(
            CURLOPT_URL => $this->getServiceEndpoint() . $path,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_SSL_VERIFYPEER => TRUE,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => __DIR__.'/api.pem',
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_HTTPHEADER => $headers
        );
        
        curl_setopt_array($ch, $options);
        
        return $ch;
    }
    
    /**
     * Executes the given curl handle, checks for errors, and returns the response.
     * 
     * @param resource $ch       The curl handle to exec
     * @param callback $callback A callback to fire on re-authentication
     * @param array    $params   Optional array of arguments for the callback
     * @throws Prado\Rackspace\DNS\Exception\CurlException
     * @throws Prado\Rackspace\DNS\Exception\CloudDnsFault
     * @return string The server response
     */
    protected function execCurlHandle($ch, $callback, array $params = array())
    {
        $response = curl_exec($ch);
        
        // Check for cURL errors.
        if (0 !== $errno = curl_errno($ch)) {
            throw new CurlException(curl_error($ch), $errno);
        }
        
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Reauthenticate if necessary on 401 errors.
        if ($statusCode == 401 && !$this->_auth->isFullyAuthenticated()) {
            $this->_auth->authenticate();
            return call_user_func_array($callback, $params);
        }
        
        // Throw appropriate CloudDnsFault if non-200s status code.
        if ($statusCode < 200 || $statusCode >= 300) {
            throw CloudDnsFault::createException($statusCode, $response);
        }
        
        curl_close($ch);
        
        return $response;
    }
    
    public function getServiceEndpoint()
    {
        return self::SERVICE_ENDPOINT_US . '/' . $this->_auth->getAccountId();
    }
}

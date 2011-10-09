<?php

namespace Prado\Rackspace\DNS;


use Prado\Rackspace\DNS\Entity\Domain;
use Prado\Rackspace\DNS\EntityManager\AsynchResponseManager;
use Prado\Rackspace\DNS\EntityManager\DomainManager;
use Prado\Rackspace\DNS\EntityManager\RecordManager;
use Prado\Rackspace\DNS\Http\CurlApiClient;
use Prado\Rackspace\DNS\Http\CurlAuthenticator;
use Prado\Rackspace\DNS\Http\RequestGenerator;
use Prado\Rackspace\DNS\CloudDNSService;
use Prado\Rackspace\DNS\Storage\NullStorageAdapter;
use Zend\Http\Client as ZendClient;

class ServiceContainer implements CloudDNSService
{
    protected static $shared = array();
    
    protected $username;
    
    protected $apiKey;
    
    protected $parameters = array();
    
    /**
     * Constructor.
     * 
     * @param string $username
     * @param string $apiKey
     * @param array  $parameters
     */
    public function __construct($username, $apiKey, array $parameters = array())
    {
        $this->username   = $username;
        $this->apiKey     = $apiKey;
        $this->parameters = array_merge(array(
            'storage.adapter' => new NullStorageAdapter
        ), $parameters);
    }
    
    /**
     * @return Prado\Rackspace\DNS\EntityManager\AsynchResponseManager
     */
    public function createAsynchResponseManager()
    {
        if (isset(self::$shared['asynch_response_manager'])) {
            return self::$shared['asynch_response_manager'];
        }
        
        $em = new AsynchResponseManager($this->getClient(), $this->getHydrator());
        
        return self::$shared['asynch_response_manager'] = $em;
    }
    
    /**
     * @return Prado\Rackspace\DNS\EntityManager\DomainManager
     */
    public function createDomainManager()
    {
        if (isset(self::$shared['domain_manager'])) {
            return self::$shared['domain_manager'];
        }
        
        $em = new DomainManager($this->getClient(), $this->getHydrator());
        
        return self::$shared['domain_manager'] = $em;
    }
    
    /**
     * @param Prado\Rackspace\DNS\Entity\Domain $domain
     * @return Prado\Rackspace\DNS\EntityManager\RecordManager
     */
    public function createRecordManager(Domain $domain)
    {
        return new RecordManager($this->getClient(), $this->getHydrator(), $domain);
    }
    
    /**
     * @return Prado\Rackspace\DNS\Http\CurlApiClient
     */
    protected function getClient()
    {
        if (isset(self::$shared['client'])) {
            return self::$shared['client'];
        }
        
        $client = new CurlApiClient($this->getAuthenticator());
        
        return self::$shared['client'] = $client;
    }
    
    public function getAuthenticator()
    {
        if (isset(self::$shared['auth'])) {
            return self::$shared['auth'];
        }
        
        $auth = new CurlAuthenticator($this->username, $this->apiKey, $this->getStorage());
        
        return self::$shared['auth'] = $auth;
    }
    
    /**
     * @return Prado\Rackspace\DNS\Storage\StorageInterface
     */
    protected function getStorage()
    {
        return $this->parameters['storage.adapter'];
    }
    
    /**
     * @return Prado\Rackspace\DNS\Hydrator
     */
    protected function getHydrator()
    {
        if (isset(self::$shared['hydrator'])) {
            return self::$shared['hydrator'];
        }
        
        return self::$shared['hydrator'] = new Hydrator;
    }
}

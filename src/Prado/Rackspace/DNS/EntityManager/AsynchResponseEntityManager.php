<?php

namespace Prado\Rackspace\DNS\EntityManager;

use BadMethodCallException;
use Prado\Rackspace\Http\Client;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Hydrator;
use Prado\Rackspace\DNS\UriGenerator;
use Prado\Rackspace\DNS\Model\Entity;
use Prado\Rackspace\DNS\Model\EntityManager;

class AsynchResponseEntityManager implements EntityManager
{
    /**
     * @var Prado\Rackspace\Http\Client
     */
    protected $_client;
    
    /**
     * @var Prado\Rackspace\DNS\Hydrator
     */
    protected $_hydrator;
    
    /**
     * @var Prado\Rackspace\DNS\UriGenerator
     */
    protected $_uriGenerator;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\Http\Client      $client
     * @param Prado\Rackspace\DNS\Hydrator     $hydrator
     * @param Prado\Rackspace\DNS\UriGenerator $uriGenerator
     */
    public function __construct(Client $client, Hydrator $hydrator, UriGenerator $uriGenerator)
    {
        $this->_client       = $client;
        $this->_hydrator     = $hydrator;
        $this->_uriGenerator = $uriGenerator;
    }
    
    public function create(Entity $entity)
    {
        throw new BadMethodCallException('Create method not supported on AsynchResponse');
    }
    
    public function remove(Entity $entity)
    {
        throw new BadMethodCallException('Remove method not supported on AsynchResponse');
    }
    
    public function update(Entity $entity)
    {
        throw new BadMethodCallException('Update method not supported on AsynchResponse');
    }
    
    public function find($id)
    {
        $uri = $this->_uriGenerator->getUri(sprintf('/status/%s?showDetails=true', $id));
        $response = $this->_client->get($uri);
        
        $json = json_decode($response->getBody(), TRUE);
        $entity = new AsynchResponse();
        
        $this->_hydrator->hydrateEntity($entity, $json);
        
        return $entity;
    }
    
    public function createList()
    {
        $uri = $this->_uriGenerator->getUri('/status');
        $response = $this->_client->get($uri);
        
        $json = json_decode($response->getBody(), TRUE);
        
        $list = array();
        foreach ($json['asyncResponses'] as $asyncResponse) {
            
            $entity = new AsynchResponse();
            $this->_hydrator->hydrateEntity($entity, $asyncResponse);
            $list[] = $entity;
        }
        
        return $list;
    }
}

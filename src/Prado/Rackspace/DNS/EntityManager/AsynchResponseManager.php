<?php

namespace Prado\Rackspace\DNS\EntityManager;

use BadMethodCallException;
use Prado\Rackspace\DNS\Http\Client;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Hydrator;
use Prado\Rackspace\DNS\Model\Entity;
use Prado\Rackspace\DNS\Model\EntityManager;

class AsynchResponseManager implements EntityManager
{
    /**
     * @var Prado\Rackspace\DNS\Http\Client
     */
    protected $_client;
    
    /**
     * @var Prado\Rackspace\DNS\Hydrator
     */
    protected $_hydrator;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\DNS\Http\Client  $client
     * @param Prado\Rackspace\DNS\Hydrator $hydrator
     */
    public function __construct(Client $client, Hydrator $hydrator)
    {
        $this->_client   = $client;
        $this->_hydrator = $hydrator;
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
    
    public function refresh(Entity $entity)
    {
        throw new BadMethodCallException('Refresh method not supported on AsynchResponse');
    }
    
    public function find($id)
    {
        $response = $this->_client->get(sprintf('/status/%s?showDetails=true', $id));
        
        $json = json_decode($response->getBody(), TRUE);
        $entity = new AsynchResponse();
        
        $this->_hydrator->hydrateEntity($entity, $json);
        
        return $entity;
    }
    
    public function createList()
    {
        $response = $this->_client->get('/status');
        
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

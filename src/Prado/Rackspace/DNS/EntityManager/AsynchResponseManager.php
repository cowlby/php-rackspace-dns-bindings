<?php

namespace Prado\Rackspace\DNS\EntityManager;

use BadMethodCallException;
use Prado\Rackspace\DNS\Http\RestInterface;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Entity\AsynchResponseList;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityManager;

class AsynchResponseManager implements EntityManager
{
    /**
     * @var Prado\Rackspace\DNS\Http\RestInterface
     */
    protected $_api;
    
    /**
     * @var Prado\Rackspace\DNS\Hydrator
     */
    protected $_hydrator;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\DNS\Http\RestInterface $rest
     * @param Prado\Rackspace\DNS\Hydrator           $hydrator
     */
    public function __construct(RestInterface $api, Hydrator $hydrator)
    {
        $this->_api = $api;
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
        $data = $this->_api->get(sprintf('/status/%s?showDetails=true', $id));
        
        $entity = new AsynchResponse;
        $this->_hydrator->hydrateEntity($entity, $data);
        
        return $entity;
    }
    
    public function createList()
    {
        $data = $this->_api->get('/status');
        
        $list = new AsynchResponseList;
        foreach ($data['asyncResponses'] as $asyncResponse) {
            
            $entity = new AsynchResponse;
            $this->_hydrator->hydrateEntity($entity, $asyncResponse);
            $list->addEntity($entity);
        }
        
        return $list;
    }
}

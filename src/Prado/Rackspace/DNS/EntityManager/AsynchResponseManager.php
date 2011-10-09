<?php

namespace Prado\Rackspace\DNS\EntityManager;

use BadMethodCallException;
use Prado\Rackspace\DNS\Http\RestInterface;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Hydrator;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityManager;

class AsynchResponseManager implements EntityManager
{
    /**
     * @var Prado\Rackspace\DNS\Http\RestInterface
     */
    protected $_rest;
    
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
    public function __construct(RestInterface $rest, Hydrator $hydrator)
    {
        $this->_rest = $rest;
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
        $data = $this->_rest->get(sprintf('/status/%s?showDetails=true', $id));
        
        $entity = new AsynchResponse();
        $this->_hydrator->hydrateEntity($entity, $data);
        
        return $entity;
    }
    
    public function createList()
    {
        $data = $this->_rest->get('/status');
        
        $list = array();
        foreach ($data['asyncResponses'] as $asyncResponse) {
            
            $entity = new AsynchResponse();
            $this->_hydrator->hydrateEntity($entity, $asyncResponse);
            $list[] = $entity;
        }
        
        return $list;
    }
}

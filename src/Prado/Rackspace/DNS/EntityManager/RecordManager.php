<?php

namespace Prado\Rackspace\DNS\EntityManager;

use DateTime;
use BadMethodCallException;
use Prado\Rackspace\DNS\Http\RestInterface;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Entity\Domain;
use Prado\Rackspace\DNS\Entity\Record;
use Prado\Rackspace\DNS\Entity\RecordList;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityManager;

class RecordManager implements EntityManager
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
     * @var Prado\Rackspace\DNS\Entity\Domain
     */
    protected $_domain;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\Http\RestInterface $apit
     * @param Prado\Rackspace\DNS\Hydrator       $hydrator
     */
    public function __construct(RestInterface $api, Hydrator $hydrator, Domain $domain)
    {
        $this->_api      = $api;
        $this->_hydrator = $hydrator;
        $this->_domain   = $domain;
    }
    
    public function create(Entity $entity)
    {
        throw new BadMethodCallException('Create method not yet implemented.');
    }
    
    public function remove(Entity $entity)
    {
        throw new BadMethodCallException('Remove method not yet implemented.');
    }
    
    public function update(Entity $entity)
    {
        throw new BadMethodCallException('Update method not yet implemented.');
    }
    
    public function refresh(Entity $entity)
    {
        throw new BadMethodCallException('Refresh method not yet implemented.');
    }
    
    public function find($id)
    {
        $data = $this->_api->get(sprintf('/domains/%s/records/%s', $this->_domain->getId(), $id));
        
        $entity = new Record;
        $this->_hydrator->hydrateEntity($entity, $data);
        
        return $entity;
    }
    
    public function createList()
    {
        $data = $this->_api->get(sprintf('/domains/%s/records', $this->_domain->getId()));
        
        
        $list = new RecordList;
        foreach ($data['records'] as $record) {
            
            $entity = new Record;
            $this->_hydrator->hydrateEntity($entity, $record);
            $list->addEntity($entity);
        }
        
        return $list;
    }
}

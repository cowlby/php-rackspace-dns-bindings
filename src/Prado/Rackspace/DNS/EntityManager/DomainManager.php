<?php

namespace Prado\Rackspace\DNS\EntityManager;

use DateTime;
use Prado\Rackspace\DNS\Http\RestInterface;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Entity\Domain;
use Prado\Rackspace\DNS\Entity\DomainList;
use Prado\Rackspace\DNS\Entity\Record;
use Prado\Rackspace\DNS\Hydrator;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityManager;

class DomainManager implements EntityManager
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
     * @param Prado\Rackspace\Http\RestInterface  $rest
     * @param Prado\Rackspace\DNS\Hydrator        $hydrator
     */
    public function __construct(RestInterface $rest, Hydrator $hydrator)
    {
        $this->_rest = $rest;
        $this->_hydrator = $hydrator;
    }
    
    public function create(Entity $entity)
    {
        $object = array();
        foreach (array('name', 'ttl', 'emailAddress', 'comment') as $field) {
            $get = sprintf('get%s', ucfirst($field));
            if ($entity->$get()) {
                $object[$field] = $entity->$get();
            }
        }
        
        $data = $this->_rest->post('/domains', array(
        	'domains' => array($object)
        ));
        
        $asynchResponse = new AsynchResponse;
        $this->_hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function remove(Entity $entity)
    {
        if (!$entity->getId()) {
            throw new \BadMethodCallException('Must set the ID of the domain you want to remove.');
        }
        
        $data = $this->_rest->delete(sprintf('/domains/%s', $entity->getId()));
        
        $asynchResponse = new AsynchResponse;
        $this->_hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function update(Entity $entity)
    {
    }
    
    public function refresh(Entity $entity)
    {
    }
    
    public function find($id)
    {
        $data = $this->_rest->get(sprintf('/domains/%s', $id));
        
        $entity = new Domain();
        $this->_hydrator->hydrateEntity($entity, $data);
        
        foreach ($data['recordsList']['records'] as $jsonRecord) {
            
            $record = new Record();
            $this->_hydrator->hydrateEntity($record, $jsonRecord);
            $entity->addRecord($record);
        }
        
        return $entity;
    }
    
    public function import(Domain $domain)
    {
        $object = array();
        foreach (array('name', 'contentType', 'content', 'comment') as $attribute) {
            $get = sprintf('get%s', ucfirst($attribute));
            if ($entity->$get()) {
                $object[$attribute] = $domain->$get();
            }
        }
        
        $data = $this->_rest->post('/domains/import', array(
        	'domains' => array($object)
        ));
        
        $asynchResponse = new AsynchResponse;
        $this->_hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function export(Domain $domain)
    {
        $data = $this->_rest->get(sprintf('/domains/%s/export', $domain->getId()));
        
        $asynchResponse = new AsynchResponse;
        $this->_hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function createList()
    {
        $data = $this->_rest->get('/domains');
        
        $list = new DomainList();
        foreach ($data['domains'] as $jsonDomain) {
            
            $entity = new Domain();
            $this->_hydrator->hydrateEntity($entity, $jsonDomain);
            $list->addEntity($entity);
        }
        
        return $list;
    }
}

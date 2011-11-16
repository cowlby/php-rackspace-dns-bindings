<?php

namespace Prado\Rackspace\DNS\EntityManager;

use DateTime;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityManager;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Entity\Domain;
use Prado\Rackspace\DNS\Entity\Record;
use Prado\Rackspace\DNS\Http\RestInterface;
use Prado\Rackspace\DNS\Exception\ItemNotFoundFault;

class DomainManager implements EntityManager
{
    /**
     * @var Prado\Rackspace\DNS\Http\RestInterface
     */
    protected $api;
    
    /**
     * @var Prado\Rackspace\DNS\EntityManager\Hydrator
     */
    protected $hydrator;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\Http\RestInterface         $api
     * @param Prado\Rackspace\DNS\EntityManager\Hydrator $hydrator
     */
    public function __construct(RestInterface $api, Hydrator $hydrator)
    {
        $this->api = $api;
        $this->hydrator = $hydrator;
    }
    
    /**
     * @see Prado\Rackspace\DNS.EntityManager::create()
     */
    public function create(Entity $entity)
    {
        $object = array();
        foreach (array('name', 'ttl', 'emailAddress', 'comment') as $field) {
            $get = sprintf('get%s', ucfirst($field));
            if ($entity->$get()) {
                $object[$field] = $entity->$get();
            }
        }
        
        $data = $this->api->post('/domains', array(
        	'domains' => array($object)
        ));
        
        $asynchResponse = new AsynchResponse;
        $this->hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function remove(Entity $entity)
    {
        if (!$entity->getId()) {
            throw new \InvalidArgumentException('Must set the ID of the domain you want to remove.');
        }
        
        $data = $this->api->delete(sprintf('/domains/%s', $entity->getId()));
        
        $asynchResponse = new AsynchResponse;
        $this->hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function update(Entity $entity)
    {
    }
    
    public function refresh(Entity $entity)
    {
    }
    
    /**
     * @see Prado\Rackspace\DNS.EntityManager::find()
     */
    public function find($id)
    {
        try {
            $data = $this->api->get(sprintf('/domains/%s', $id));
        } catch (ItemNotFoundFault $fault) {
            return NULL;
        }
        
        $entity = new Domain();
        $this->hydrator->hydrateEntity($entity, $data);
        
        foreach ($data['recordsList']['records'] as $jsonRecord) {
            
            $record = new Record();
            $this->hydrator->hydrateEntity($record, $jsonRecord);
            $entity->addRecord($record);
        }
        
        return $entity;
    }
    
    /**
     * @see Prado\Rackspace\DNS.EntityManager::findAll()
     */
    public function findAll()
    {
        $data = $this->api->get('/domains');
        
        $list = array();
        foreach ($data['domains'] as $domain) {
            
            $entity = new Domain();
            $this->hydrator->hydrateEntity($entity, $domain);
            $list[] = $entity;
        }
        
        return $list;
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
        
        $data = $this->api->post('/domains/import', array(
        	'domains' => array($object)
        ));
        
        $asynchResponse = new AsynchResponse;
        $this->hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
    
    public function export(Domain $domain)
    {
        $data = $this->api->get(sprintf('/domains/%s/export', $domain->getId()));
        
        $asynchResponse = new AsynchResponse;
        $this->hydrator->hydrateEntity($asynchResponse, $data);
        
        return $asynchResponse;
    }
}

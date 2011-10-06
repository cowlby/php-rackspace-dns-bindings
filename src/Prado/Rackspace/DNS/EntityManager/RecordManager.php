<?php

namespace Prado\Rackspace\DNS\EntityManager;


use DateTime;
use Prado\Rackspace\DNS\Http\Client;
use Prado\Rackspace\DNS\Entity\AsynchResponse;
use Prado\Rackspace\DNS\Entity\Record;
use Prado\Rackspace\DNS\Entity\RecordList;
use Prado\Rackspace\DNS\Hydrator;
use Prado\Rackspace\DNS\Model\Entity;
use Prado\Rackspace\DNS\Model\EntityManager;

class RecordManager implements EntityManager
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
     * @var Prado\Rackspace\DNS\Entity\Domain
     */
    protected $_domain;
    
    /**
     * Constructor.
     * 
     * @param Prado\Rackspace\Http\Client  $client
     * @param Prado\Rackspace\DNS\Hydrator $hydrator
     */
    public function __construct(Client $client, Hydrator $hydrator, Domain $domain)
    {
        $this->_client   = $client;
        $this->_hydrator = $hydrator;
        $this->_domain   = $domain;
    }
    
    public function create(Entity $entity)
    {
        
    }
    
    public function remove(Entity $entity)
    {
        
    }
    
    public function update(Entity $entity)
    {
        
    }
    
    public function refresh(Entity $entity)
    {
        
    }
    
    public function find($id)
    {
        $response = $this->_client->get(sprintf('/domains/%s/records/%s', $this->_domain->getId(), $id));
        
        $json = json_decode($response->getBody(), TRUE);
        
        $entity = new Record();
        $this->_hydrator->hydrateEntity($entity, $json);
        
        return $entity;
    }
    
    public function createList()
    {
        $response = $this->_client->get(sprintf('/domains/%s/records', $this->_domain->getId()));
        
        $json = json_decode($response->getBody(), TRUE);
        
        $entity = new Record();
        $this->_hydrator->hydrateEntity($entity, $json);
        
        return $entity;
    }
    
    public static function getFields()
    {
        return array('id', 'name', 'type', 'data', 'ttl', 'created', 'updated');
    }
}

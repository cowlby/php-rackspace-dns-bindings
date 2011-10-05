<?php

namespace Prado\Rackspace\DNSBundle\EntityManager;

use DateTime;
use Prado\Rackspace\DNSBundle\Entity\Domain;
use Prado\Rackspace\DNSBundle\Entity\Record;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zend\Http\Client as ZendClient;

class RecordEntityManager extends BaseEntityManager
{
    protected $accountId;
    
    protected $domainId;
    
    /**
     * @var Zend\Http\Client
     */
    protected $_client;
    
    public function __construct(ZendClient $client, $accountId, $domainId)
    {
        $this->_client = $client;
        $this->accountId = $accountId;
        $this->domainId  = $domainId;
    }
    
    public function create(Domain $domain)
    {
        
    }
    
    public function remove(Domain $domain)
    {
        
    }
    
    public function update(Domain $domain)
    {
        
    }
    
    public function find($id)
    {
        $this->_client->resetParameters();
        $uri = sprintf('https://dns.api.rackspacecloud.com/v1.0/%s/domains/%s/records/%s'
            ,$this->accountId
            ,$this->domainId
            ,$id
        );
        $this->_client->setUri($uri);
        
        $response = $this->_client->request(ZendClient::GET);
    
        if (!$response->isSuccessful()) {
            throw new HttpException($response->getStatus(), $response->getBody());
        }
        
        $json = json_decode($response->getBody(), TRUE);
        
        $record = new Record();
        foreach (self::getFields() as $field) {
            
        }
        $record->setId($json['id']);
        $record->setName($json['name']);
        $record->setType($json['type']);
        $record->setData($json['data']);
        $record->setTtl($json['ttl']);
        $record->setCreated(new DateTime($json['created']));
        $record->setUpdated(new DateTime($json['updated']));
        
        return $record;
    }
    
    public static function getFields()
    {
        return array('id', 'name', 'type', 'data', 'ttl', 'created', 'updated');
    }
}

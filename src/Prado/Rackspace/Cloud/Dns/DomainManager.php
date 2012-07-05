<?php

namespace Prado\Rackspace\Cloud\Dns;

use Prado\Rackspace\Cloud\Dns\Entity;
use Guzzle\Http\Client as GuzzleClient;

class DomainManager
{
	protected $client;
	
	protected $hydrator;
	
	public function __construct(GuzzleClient $client, Hydrator $hydrator)
	{
		$this->setClient($client);
		$this->setHydrator($hydrator);
	}
	
	public function setClient(GuzzleClient $client)
	{
		$this->client = $client;
		return $this;
	}
	
	public function setHydrator(Hydrator $hydrator)
	{
		$this->hydrator = $hydrator;
		return $this;
	}
    
    public function find($id)
    {
    	$response = $this->client->get('domains/%s', $id);
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
	
	public function fetchAll()
	{
		$response = $this->client->get('domains')->send();
		
		$json = json_decode($response->getBody(), TRUE);
		
		$list = array();
		foreach ($json['domains'] as $domain) {
			
			$entity = new Entity\Domain();
			$this->hydrator->hydrateEntity($entity, $domain);
			$list[] = $entity;
		}
		
		return $list;
	}
}

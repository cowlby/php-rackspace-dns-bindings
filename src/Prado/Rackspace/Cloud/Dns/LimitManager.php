<?php

namespace Prado\Rackspace\Cloud\Dns;

use Guzzle\Http\Client as GuzzleClient;

class LimitManager
{
	protected $client;
	
	public function __construct(GuzzleClient $client)
	{
		$this->setClient($client);
	}
	
	public function setClient(GuzzleClient $client)
	{
		$this->client = $client;
	}
	
	public function fetchAll()
	{
		$request = $this->client->get('limits');
		$response = $request->send();
	}
}

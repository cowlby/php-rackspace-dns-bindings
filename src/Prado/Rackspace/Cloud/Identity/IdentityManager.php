<?php

namespace Prado\Rackspace\Cloud\Identity;

use Prado\Rackspace\Cloud\Identity\Entity\ApiVersion;

use Guzzle\Http\Exception\BadResponseException;
use Prado\Rackspace\Cloud\Identity\Entity\ServiceCatalog;
use Prado\Rackspace\Cloud\Identity\Entity\Token;

class IdentityManager
{
	protected $container;
	
	protected $token;
	
	protected $serviceCatalog;
	
	public function __construct(CloudIdentityService $cis)
	{
		$this->setContainer($cis);
	}
	
	public function setContainer(CloudIdentityService $cis)
	{
		$this->container = $cis;
	}
	
	public function getContainer()
	{
		return $this->container;
	}
	
	public function listVersions()
	{
		$request = $this->container['rs.identity.client']->get('');
		
		try {
			$response = $request->send();
		} catch (BadResponseException $e) {
			throw $e;
		}
		
		$json = json_decode($response->getBody(), TRUE);
		$versions = array();
		foreach ($json['versions']['version'] as $jsonVersion) {
			$versions[] = ApiVersion::fromJson($jsonVersion);
		}
		
		return $versions;
	}
	
	public function getToken()
	{
		if ($this->token === NULL) {
			$this->authenticate();
		}
		
		return $this->token;
	}
	
	public function getServiceCatalog()
	{
		if ($this->serviceCatalog === NULL) {
			$this->authenticate();
		}
		
		return $this->serviceCatalog;
	}
	
	protected function authenticate()
	{
		$request = $this->container['rs.identity.client']->post('v1.1/auth');
		$request->setBody(json_encode(array(
			'credentials' => array(
				'username' => $this->container['rs.username'],
				'key' => $this->container['rs.api_key']
			)
		)));
		
		try {
			$response = $request->send();
		} catch (BadResponseException $e) {
			throw $e;
		}
		
		$json = json_decode($response->getBody(), TRUE);
		$this->token = Token::fromJson($json);
		$this->serviceCatalog = ServiceCatalog::fromJson($json);
		
		return $this;
	}
}

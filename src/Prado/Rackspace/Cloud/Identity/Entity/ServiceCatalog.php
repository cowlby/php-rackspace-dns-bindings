<?php

namespace Prado\Rackspace\Cloud\Identity\Entity;

class ServiceCatalog
{
	protected $catalog;
	
	public function __construct(array $catalog = NULL)
	{
		$this->setCatalog($catalog);
	}
	
	static public function fromJson(array $json)
	{
		if (!isset($json['auth']) &&
			!isset($json['auth']['serviceCatalog'])) {
			throw new \BadMethodCallException('Invalid auth json.');
		}
		
		return new self($json['auth']['serviceCatalog']);
	}
	
	public function setCatalog(array $catalog)
	{
		$this->catalog = $catalog;
		return $this;		
	}
	
	public function getCatalog()
	{
		return $this->catalog;
	}
	
	public function getCloudDnsEndpoint()
	{
		return $this->catalog['cloudDNS'][0]['publicURL'];
	}
}

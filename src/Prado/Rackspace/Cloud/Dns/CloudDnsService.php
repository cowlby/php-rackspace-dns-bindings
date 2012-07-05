<?php

namespace Prado\Rackspace\Cloud\Dns;

use Pimple;
use Prado\Rackspace\Cloud\Identity\CloudIdentityService;
use Guzzle\Service\Client as GuzzleClient;

class CloudDnsService extends Pimple
{
	protected $cis;
	
	public function __construct(CloudIdentityService $cis)
	{
		$this->setCloudIdentityService($cis);
		
		$this['rs.dns.client'] = $this->share(function() use ($cis) {
			
			$endpoint = $cis['rs.identity.manager']->getServiceCatalog()->getCloudDnsEndpoint();
			$client = new GuzzleClient($endpoint);
			
			$client->setConfig(array(
				'curl.CURLOPT_SSL_VERIFYHOST' => FALSE,
				'curl.CURLOPT_SSL_VERIFYPEER' => FALSE,
			));
			
			$client->setDefaultHeaders(array(
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'X-Auth-Token' => $cis['rs.identity.manager']->getToken()->getId()
			));
			
			return $client;
		});
		
		$this['rs.dns.hydrator'] = $this->share(function($cds) use ($cis) {
			return new Hydrator();
		});
		
		$this['rs.dns.limit_manager'] = $this->share(function($cds) use ($cis) {
			return new LimitManager($cds['rs.dns.client'], $cds['rs.dns.hydrator']);
		});
		
		$this['rs.dns.domain_manager'] = $this->share(function($cds) use ($cis) {
			return new DomainManager($cds['rs.dns.client'], $cds['rs.dns.hydrator']);
		});
	}
	
	public function setCloudIdentityService(CloudIdentityService $cis)
	{
		$this->cis = $cis;
	}
}

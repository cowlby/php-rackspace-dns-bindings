<?php

namespace Prado\Rackspace\Cloud\Identity;

use Pimple;
use Guzzle\Service\Client as GuzzleClient;

class CloudIdentityService extends Pimple
{
	public function __construct()
	{
		$this['rs.identity.client'] = $this->share(function($cis) {
			
			$client = new GuzzleClient($cis['rs.identity.endpoint']);
			
			$client->setConfig(array(
				'curl.CURLOPT_SSL_VERIFYHOST' => FALSE,
				'curl.CURLOPT_SSL_VERIFYPEER' => FALSE,
			));
			
			$client->setDefaultHeaders(array(
				'Content-Type' => 'application/json',
				'Accept' => 'application/json'
			));
			
			return $client;
		});
		
		$this['rs.identity.manager'] = $this->share(function($cis) {

			return new IdentityManager($cis);
		});
	}
}

<?php

namespace Prado\Rackspace\Cloud\Identity\Entity;

class Token
{
	protected $id;
	
	protected $expires;
	
	public function __construct($id, $expires)
	{
		$this->setId($id);
		$this->setExpires($expires);
	}
	
	static public function fromJson(array $json)
	{
		if (!isset($json['auth']) &&
		    !isset($json['auth']['token']) &&
			!isset($json['auth']['token']['id']) &&
			!isset($json['auth']['token']['expires'])) {
			throw new \BadMethodCallException('Invalid auth json.');
		}
		
		return new self($json['auth']['token']['id'], $json['auth']['token']['expires']);
	}
	
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function setExpires($expires)
	{
		if (!$expires instanceof \DateTime) {
			$expires = new \DateTime($expires);
		}
		
		$this->expires = $expires;
		return $this;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getExpires()
	{
		return $this->expires;
	}
}

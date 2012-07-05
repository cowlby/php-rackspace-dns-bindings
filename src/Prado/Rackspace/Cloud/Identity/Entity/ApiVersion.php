<?php

namespace Prado\Rackspace\Cloud\Identity\Entity;

class ApiVersion
{
	protected $id;
	
	protected $status;
	
	protected $updated;
	
	protected $link;
	
    public function __construct()
    {
    }
    
    static public function fromJson(array $json)
    {
    	if (!isset($json['id']) &&
    		!isset($json['status']) &&
    		!isset($json['updated']) &&
    		!isset($json['link'])) {
    		throw new \BadMethodCallException('Invalid json');
    	}
    	
    	$entity = new self();
    	$entity->setId($json['id']);
    	$entity->setStatus($json['status']);
    	$entity->setUpdated($json['updated']);
    	$entity->setLink($json['link']);
    	
    	return $entity;
    }
    
    public function setId($id)
    {
    	$this->id = $id;
    	return $this;
    }
    
    public function setStatus($status)
    {
    	$this->status = $status;
    	return $this;
    }
    
    public function setUpdated($updated)
    {
    	if (!$updated instanceof \DateTime) {
    		$updated = new \DateTime($updated);
    	}
    	
    	$this->updated = $updated;
    	return $this;
    }
    
    public function setLink(array $link)
    {
    	$this->link = $link;
    	return $this;
    }
    
    public function getId()
    {
    	return $this->id;
    }
    
    public function getStatus()
    {
    	return $this->status;
    }
    
    public function getUpdated()
    {
    	return $this->updated;
    }
    
    public function getLink()
    {
    	return $this->link;
    }
}

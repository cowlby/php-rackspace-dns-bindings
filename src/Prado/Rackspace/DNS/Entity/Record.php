<?php

namespace Prado\Rackspace\DNS\Entity;

use DateTime;
use Prado\Rackspace\DNS\Model\Entity;

class Record implements Entity
{
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $data;
    
    /**
     * @var integer
     */
    protected $ttl;
    
    /**
     * @var DateTime
     */
    protected $updated;
    
    /**
     * @var DateTime
     */
    protected $created;

	public function __construct()
    {
        
    }
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

	/**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }

	/**
     * @return the $ttl
     */
    public function getTtl()
    {
        return $this->ttl;
    }

	/**
     * @return the $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

	/**
     * @return the $created
     */
    public function getCreated()
    {
        return $this->created;
    }

	/**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

	/**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

	/**
     * @param integer $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

	/**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }

	/**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }
}

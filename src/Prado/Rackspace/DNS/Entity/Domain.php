<?php

namespace Prado\Rackspace\DNS\Entity;

use DateTime;
use Prado\Rackspace\DNS\Model\Entity;

class Domain implements Entity
{
    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var integer
     */
    protected $accountId;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $comment;
    
    /**
     * @var integer
     */
    protected $ttl;
    
    /**
     * @var string
     */
    protected $emailAddress;
    
    /**
     * @var DateTime
     */
    protected $updated;
    
    /**
     * @var DateTime
     */
    protected $created;
    
    /**
     * @var Prado\Rackspace\DNS\Entity\RecordList
     */
    protected $records;
    
    public function __construct()
    {
        $this->records = new RecordList();
    }
    
    public function getFields()
    {
        return array('id', 'name', 'accountId', 'emailAddress', 'comment', 'ttl', 'updated', 'created');
    }
    
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $accountId
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

	/**
     * @return the $ttl
     */
    public function getTtl()
    {
        return $this->ttl;
    }

	/**
     * @return the $emailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
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
     * @return the $records
     */
    public function getRecords()
    {
        return $this->records;
    }

	/**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param integer $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

	/**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

	/**
     * @param integer $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

	/**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
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
    
    public function addRecord(Record $record)
    {
        $this->records->addEntity($record);
    }
}

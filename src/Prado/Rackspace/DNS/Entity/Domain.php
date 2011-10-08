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
     * @var string
     */
    protected $contentType;
    
    /**
     * @var string
     */
    protected $content;
    
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
     * @return the $contentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }

	/**
     * @return the $content
     */
    public function getContent()
    {
        return $this->content;
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
     * @param integer $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

	/**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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

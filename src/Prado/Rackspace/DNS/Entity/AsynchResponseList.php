<?php

namespace Prado\Rackspace\DNS\Entity;

use ArrayIterator;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityList;

class AsynchResponseList implements EntityList
{
    protected $responses;
    
    public function __construct()
    {
        $this->responses = array();
    }
    
    public function addEntity(Entity $entity)
    {
        $this->responses[] = $entity;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->responses);
    }
}

<?php

namespace Prado\Rackspace\DNS\Entity;

use ArrayIterator;
use Prado\Rackspace\DNS\Entity;
use Prado\Rackspace\DNS\EntityList;

class RecordList implements EntityList
{
    protected $records;
    
    public function __construct()
    {
        $this->records = array();
    }
    
    public function addEntity(Entity $entity)
    {
        $this->records[] = $entity;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->records);
    }
}

<?php

namespace Prado\Rackspace\DNS\Entity;

use IteratorAggregate;
use ArrayIterator;

class RecordList implements IteratorAggregate
{
    protected $records;
    
    public function __construct()
    {
        $this->records = array();
    }
    
    public function addEntity(Record $record)
    {
        $this->records[] = $record;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->records);
    }
}

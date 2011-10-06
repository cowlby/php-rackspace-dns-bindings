<?php

namespace Prado\Rackspace\DNS\Entity;

use ArrayIterator;
use Prado\Rackspace\DNS\Model\Entity;
use Prado\Rackspace\DNS\Model\EntityList;

class DomainList implements EntityList
{
    protected $domains;
    
    public function __construct()
    {
        $this->domains = array();
    }
    
    public function addEntity(Entity $entity)
    {
        $this->domains[] = $entity;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->domains);
    }
}

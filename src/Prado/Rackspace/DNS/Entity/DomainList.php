<?php

namespace Prado\Rackspace\DNS\Entity;

use IteratorAggregate;
use ArrayIterator;

class DomainList implements IteratorAggregate
{
    protected $domains;
    
    public function __construct()
    {
        $this->domains = array();
    }
    
    public function addEntity(Domain $domain)
    {
        $this->domains[] = $domain;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->domains);
    }
}

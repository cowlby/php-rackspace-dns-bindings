<?php

namespace Prado\Rackspace\DNS;

use IteratorAggregate;

interface EntityList extends IteratorAggregate
{
    /**
     * Adds an Entity to the entity list.
     * 
     * @param Prado\Rackspace\DNS\Entity $entity
     */
    public function addEntity(Entity $entity);
}

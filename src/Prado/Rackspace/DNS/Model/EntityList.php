<?php

namespace Prado\Rackspace\Model;

interface EntityList extends IteratorAggregate
{
    public function addEntity(Entity $entity);
}

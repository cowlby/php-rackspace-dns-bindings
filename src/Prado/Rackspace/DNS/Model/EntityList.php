<?php

namespace Prado\Rackspace\DNS\Model;

use IteratorAggregate;

interface EntityList extends IteratorAggregate
{
    public function addEntity(Entity $entity);
}

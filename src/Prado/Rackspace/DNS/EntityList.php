<?php

namespace Prado\Rackspace\DNS;

use IteratorAggregate;

interface EntityList extends IteratorAggregate
{
    public function addEntity(Entity $entity);
}

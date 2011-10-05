<?php

namespace Prado\Rackspace\DNS\Model;

interface EntityManager
{
    public function create(Entity $entity);
    
    public function remove(Entity $entity);
    
    public function update(Entity $entity);
    
    public function find($id);
    
    public function createList();
}

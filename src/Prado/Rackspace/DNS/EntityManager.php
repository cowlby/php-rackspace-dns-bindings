<?php

namespace Prado\Rackspace\DNS;

interface EntityManager
{
    /**
     * Persists the Entity to the Cloud DNS service.
     * 
     * @param Prado\Rackspace\DNS\Entity $entity The entity to persist
     * @return Prado\Rackspace\DNS\Entity\AsynchResponse
     */
    public function create(Entity $entity);
    
    /**
     * Removes the Entity from the Cloud DNS service.
     * 
     * @param Prado\Rackspace\DNS\Entity $entity The Entity to remove
     * @return Prado\Rackspace\DNS\Entity\AsynchResponse
     */
    public function remove(Entity $entity);
    
    /**
     * Updates the Entity in the Cloud DNS service.
     * 
     * @param Prado\Rackspace\DNS\Entity $entity The Entity to update
     * @return Prado\Rackspace\DNS\Entity\AsynchResponse
     */
    public function update(Entity $entity);
    
    /**
     * Refreshes an Entity from data in the Cloud DNS service.
     * 
     * @param Prado\Rackspace\DNS\Entity $entity The Entity to refresh
     * @return Prado\Rackspace\DNS\Entity The refreshed Entity
     */
    public function refresh(Entity $entity);
    
    /**
     * Finds the Entity for the corresponding ID in the Cloud DNS service.
     * 
     * @param string $id The ID to look for
     */
    public function find($id);
    
    /**
     * Creates a list of records for the given Entity type.
     * 
     * @return Prado\Rackspace\DNS\EntityList The Entity list.
     */
    public function createList();
}

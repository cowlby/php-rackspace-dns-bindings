<?php

namespace Prado\Rackspace\DNS;

use Prado\Rackspace\DNS\Entity\Domain;

interface CloudDnsServiceInterface
{
    /**
     * Creates and returns a shared AsynchResponseManager instance.
     * 
     * @return Prado\Rackspace\DNS\EntityManager\AsynchResponseManager
     */
    public function createAsynchResponseManager();
    
    /**
     * Creates and returns a shared DomainManager instance.
     * 
     * @return Prado\Rackspace\DNS\EntityManager\DomainManager
     */
    public function createDomainManager();
    
    /**
     * Create and returns a RecordManager instance for the specified domain.
     * 
     * @param Prado\Rackspace\DNS\Entity\Domain $domain
     * @return Prado\Rackspace\DNS\EntityManager\RecordManager
     */
    public function createRecordManager(Domain $domain);
}

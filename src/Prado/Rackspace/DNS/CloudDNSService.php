<?php

namespace Prado\Rackspace\DNS;

use Prado\Rackspace\DNS\Entity\Domain;

interface CloudDNSService
{
    /**
     * @return Prado\Rackspace\DNS\EntityManager\AsynchResponseManager
     */
    public function createAsynchResponseManager();
    
    /**
     * @return Prado\Rackspace\DNS\EntityManager\DomainManager
     */
    public function createDomainManager();
    
    /**
     * @param Prado\Rackspace\DNS\Entity\Domain $domain
     * @return Prado\Rackspace\DNS\EntityManager\RecordManager
     */
    public function createRecordManager(Domain $domain);
}

<?php

namespace Prado\Rackspace\DNS\Storage;

use Symfony\Component\HttpFoundation\Session;

class SymfonySessionStorageAdapter implements StorageInterface
{
    /**
     * @var Symfony\Component\HttpFoundation\Session
     */
    protected $_session;
    
    /**
     * Constructor.
     * 
     * @param Symfony\Component\HttpFoundation\Session $session A Symfony Session instance.
     */
    public function __construct(Session $session)
    {
        $this->_session = $session;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::retrieve()
     */
    public function retrieve($key)
    {
        return $this->_session->get($key, NULL);
    }
    
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::store()
     */
    public function store($key, $value)
    {
        return $this->_session->set($key, $value);
    }
}

<?php

namespace Prado\Rackspace\DNS\Storage;

use Symfony\Component\HttpFoundation\Session;

class SymfonySessionStorageAdapter implements StorageInterface
{
    protected $_session;
    
    public function __construct(Session $session)
    {
        $this->_session = $session;
    }
    
    public function retrieve($key)
    {
        return $this->_session->get($key, NULL);
    }
    
    public function store($key, $value)
    {
        return $this->_session->set($key, $value);
    }
}

<?php

namespace Prado\Rackspace\DNS\Storage;

use Memcached;

class MemcachedStorageAdapter implements StorageInterface
{
    /**
     * @var Memcached
     */
    protected $_cache;
    
    /**
     * Constructor.
     * 
     * @param Memcached $cache A Memcached instance to use
     */
    public function __construct(Memcached $cache)
    {
        $this->_cache = $cache;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::retrieve()
     */
    public function retrieve($key)
    {
        $data = $this->_cache->get($key);
        
        return $data === FALSE ? NULL : $data;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::store()
     */
    public function store($key, $data)
    {
        return $this->_cache->set($key, $data);
    }
}

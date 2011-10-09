<?php

namespace Prado\Rackspace\DNS\Storage;

use Memcache;

class MemcacheStorageAdapter implements StorageInterface
{
    /**
     * @var Memcache
     */
    protected $_cache;
    
    /**
     * Constructor.
     * 
     * @param Memcache $cache A Memcache instance to use
     */
    public function __construct(Memcache $cache)
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

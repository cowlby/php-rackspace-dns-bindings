<?php

namespace Prado\Rackspace\DNS\Storage;

use Memcache;

class MemcacheStorageAdapter implements StorageInterface
{
    protected $_cache;
    
    public function __construct(Memcache $cache)
    {
        $this->_cache = $cache;
    }
    
    public function retrieve($key)
    {
        $data = $this->_cache->get($key);
        
        return $data === FALSE ? NULL : $data;
    }
    
    public function store($key, $data)
    {
        return $this->_cache->set($key, $data);
    }
}

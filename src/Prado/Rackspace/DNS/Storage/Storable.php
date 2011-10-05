<?php

namespace Prado\Rackspace\DNS\Storage;

interface Storable
{
    public function getStorage();
    
    public function hasStorage();
    
    public function setStorage(StorageInterface $storage);
}

<?php

namespace Prado\Rackspace\DNS\Http;

interface RestInterface
{
    public function get($path);
    
    public function post($path, array $data);
    
    public function put($path, array $data);
    
    public function delete($path);
}

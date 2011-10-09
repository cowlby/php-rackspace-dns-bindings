<?php

namespace Prado\Rackspace\DNS\Http;

interface RestInterface
{
    public function get($path);
    
    public function post($path, $data);
    
    public function put($path, $data);
    
    public function delete($path);
}

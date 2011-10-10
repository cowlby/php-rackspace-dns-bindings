<?php

namespace Prado\Rackspace\DNS\Http;

interface RestInterface
{
    /**
     * GETs the specified path from the Cloud DNS Service.
     * 
     * @param string $path The path to the resource
     * @return string The server response
     */
    public function get($path);
    
    /**
     * POSTs the specified data to the path on the Cloud DNS Service.
     * 
     * @param string $path The path to the resource
     * @param array  $data An array of json-ready data to send
     * @return string The server response
     */
    public function post($path, array $data);
    
    /**
     * PUTs the specified data to the path on the Cloud DNS Service.
     * 
     * @param string $path The path to the resource
     * @param array  $data An array of json-ready data to send
     * @return string The server response
     */
    public function put($path, array $data);
    
    /**
     * DELETEs the specified resource from the Cloud DNS Service.
     * 
     * @param string $path The path to the resource
     * @return string The server response
     */
    public function delete($path);
}

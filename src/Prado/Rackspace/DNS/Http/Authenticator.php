<?php

namespace Prado\Rackspace\DNS\Http;

interface Authenticator
{
    /**
     * Returns an array of headers (in single string format) to be used as
     * part of the authentication in a request.
     * 
     * @return array The authentication headers
     */
    public function getAuthHeaders();
    
    /**
     * Returns the account ID that the user must use to interact with the API.
     * 
     * @return string The account ID.
     */
    public function getAccountId();
    
    /**
     * Whether or not a full authentication was performed vs. retrieving the
     * auth token from a cache.
     * 
     * @return Boolean Whether full authentication took place.
     */
    public function isFullyAuthenticated();
    
    /**
     * The authenticate method must authenticate against the DNS auth
     * service (send an HTTP request) and get the latest auth token.
     * 
     * @return Boolean true when authentication is successful
     * @throws Prado\Rackspace\DNS\Fault\UnauthorizedFault
     */
    public function authenticate();
}

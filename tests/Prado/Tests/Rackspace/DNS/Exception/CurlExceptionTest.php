<?php

namespace Prado\Tests\Rackspace\DNS\Exception;

use \RuntimeException;
use Prado\Rackspace\DNS\Exception\CurlException;
use Prado\Rackspace\DNS\Exception\CloudDnsException;

/**
 * CurlException test case.
 */
class CurlExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Exception\CurlException
     */
    private $exception;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->exception = new CurlException('Mock exception message');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->exception = null;
    }
    
    public function testCatchableViaBaseExceptionInterface()
    {
        $this->assertTrue($this->exception instanceof CloudDnsException);
        $this->setExpectedException('Prado\Rackspace\DNS\Exception\CloudDnsException');
        
        throw $this->exception;
    }
    
    public function testCatchableViaSplException()
    {
        $this->assertTrue($this->exception instanceof RuntimeException);
        $this->setExpectedException('RuntimeException');
        
        throw $this->exception;
    }
}

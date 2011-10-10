<?php

namespace Prado\Tests\Rackspace\DNS\Exception;

use \RuntimeException;
use Prado\Rackspace\DNS\Exception\CloudDnsFault;
use Prado\Rackspace\DNS\Exception\CloudDnsException;

/**
 * CloudDnsFault test case.
 */
class CloudDnsFaultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Exception\CloudDnsFault
     */
    private $fault;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->fault = new CloudDnsFault;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->fault = null;
    }
    
    public function testCatchableViaBaseExceptionInterface()
    {
        $this->assertTrue($this->fault instanceof CloudDnsException);
        $this->setExpectedException('Prado\Rackspace\DNS\Exception\CloudDnsException');
        
        throw $this->fault;
    }
    
    public function testCatchableViaSplException()
    {
        $this->assertTrue($this->fault instanceof RuntimeException);
        $this->setExpectedException('RuntimeException');
        
        throw $this->fault;
    }
}

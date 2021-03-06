<?php

namespace Prado\Tests\Rackspace\DNS\Exception;

use \RuntimeException;
use Prado\Rackspace\DNS\Exception\BadRequestFault;
use Prado\Rackspace\DNS\Exception\CloudDnsFault;
use Prado\Rackspace\DNS\Exception\CloudDnsException;

/**
 * BadRequestFault test case.
 */
class BadRequestFaultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Exception\BadRequestFault
     */
    private $fault;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->fault = new BadRequestFault;
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
    
    public function testCatchableViaBaseFault()
    {
        $this->assertTrue($this->fault instanceof CloudDnsFault);
        $this->setExpectedException('Prado\Rackspace\DNS\Exception\CloudDnsFault');
        
        throw $this->fault;
    }
    
    public function testCatchableViaSplException()
    {
        $this->assertTrue($this->fault instanceof RuntimeException);
        $this->setExpectedException('RuntimeException');
        
        throw $this->fault;
    }
}

<?php

namespace Prado\Tests\Rackspace\DNS\Entity;

use Prado\Rackspace\DNS\Entity\AsynchResponse;

/**
 * AsynchResponse test case.
 */
class AsynchResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Entity\AsynchResponse
     */
    private $asynchResponse;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->asynchResponse = new AsynchResponse;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->asynchResponse = null;
    }
    
    public function testGettersAndSetters()
    {
        $fields = array('jobId', 'request', 'response', 'status', 'error', 'verb', 'requestUrl', 'callbackUrl');
        
        foreach ($fields as $field) {
            
            $getter = sprintf('get%s', ucfirst($field));
            $setter = sprintf('set%s', ucfirst($field));
            
            switch ($field) {
                
                case 'created':
                case 'updated':
                    $value = new DateTime;
                    break;
                    
                default:
                    $value = 'value1';
                    break;
            }
            
            $this->asynchResponse->$setter($value);
            $this->assertEquals($value, $this->asynchResponse->$getter());
        }
    }
    
    public function testGetIdReturnsIdentity()
    {
        $jobId = 'abcdef';
        $this->asynchResponse->setJobId($jobId);
        $this->assertEquals($jobId, $this->asynchResponse->getId());
        $this->assertEquals($this->asynchResponse->getJobId(), $this->asynchResponse->getId());
    }
}

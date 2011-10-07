<?php

namespace Prado\Tests\Rackspace\DNS;

use Prado\Rackspace\DNS\ServiceContainer;

/**
 * ServiceContainer test case.
 */
class ServiceContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\ServiceContainer
     */
    private $container;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $username = 'testUsername';
        $apiKey   = 'testApiKey';
        $this->container = new ServiceContainer($username, $apiKey);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->container = null;
    }

    /**
     * Tests ServiceContainer->createAsynchResponseManager()
     */
    public function testCreateAsynchResponseManager()
    {
        $em = $this->container->createAsynchResponseManager();
        $this->assertEquals('Prado\Rackspace\DNS\EntityManager\AsynchResponseManager', get_class($em));
    }

    /**
     * Tests ServiceContainer->createDomainManager()
     */
    public function testCreateDomainManager()
    {
        $em = $this->container->createDomainManager();
        $this->assertEquals('Prado\Rackspace\DNS\EntityManager\DomainManager', get_class($em));
    }

    /**
     * Tests ServiceContainer->createRecordManager()
     */
    public function testCreateRecordManager()
    {
        $domain = $this->getMock('Prado\Rackspace\DNS\Entity\Domain');
        $em = $this->container->createRecordManager($domain);
        
        $this->assertEquals('Prado\Rackspace\DNS\EntityManager\RecordManager', get_class($em));
    }
}

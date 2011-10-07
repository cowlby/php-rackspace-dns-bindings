<?php

namespace Prado\Tests\Rackspace\DNS;

use Prado\Rackspace\DNS\Hydrator;

/**
 * Hydrator test case.
 */
class HydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Hydrator
     */
    private $hydrator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->hydrator = new Hydrator;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->hydrator = null;
    }

    /**
     * Tests Hydrator->hydrateEntity()
     */
    public function testHydrateEntityWorksWithOneField()
    {
        $methods = array('getFields', 'setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
        
        $entity->expects($this->once())
            ->method('getFields')
            ->will($this->returnValue(array('prop1')));
            
        $entity->expects($this->once())
            ->method('setProp1')
            ->with($this->equalTo('value1'));
        
        $entity->expects($this->never())
            ->method('setProp2');
        
        $json = array('prop1' => 'value1', 'prop2' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }

    /**
     * Tests Hydrator->hydrateEntity()
     */
    public function testHydrateEntityWorksWithMultipleFields()
    {
        $methods = array('getFields', 'setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
        
        $entity->expects($this->once())
            ->method('getFields')
            ->will($this->returnValue(array('prop1', 'prop2')));
            
        $entity->expects($this->once())
            ->method('setProp1')
            ->with($this->equalTo('value1'));
        
        $entity->expects($this->once())
            ->method('setProp2')
            ->with($this->equalTo('value2'));
        
        $json = array('prop1' => 'value1', 'prop2' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }

    /**
     * Tests Hydrator->hydrateEntity()
     */
    public function testHydrateEntityWorksWithNoFields()
    {
        $methods = array('getFields', 'setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
        
        $entity->expects($this->once())
            ->method('getFields')
            ->will($this->returnValue(array()));
            
        $entity->expects($this->never())
            ->method('setProp1');
            
        $entity->expects($this->never())
            ->method('setProp2');
        
        $json = array('prop1' => 'value1', 'prop2' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }

    /**
     * Tests Hydrator->hydrateEntity()
     */
    public function testHydrateEntityWorksWithDifferentJsonFields()
    {
        $methods = array('getFields', 'setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
        
        $entity->expects($this->once())
            ->method('getFields')
            ->will($this->returnValue(array()));
            
        $entity->expects($this->never())
            ->method('setProp1');
            
        $entity->expects($this->never())
            ->method('setProp2');
        
        $json = array('prop3' => 'value1', 'prop4' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }
}

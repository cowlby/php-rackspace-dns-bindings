<?php

namespace Prado\Tests\Rackspace\DNS;

use ReflectionMethod;
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
    
    public function testHydrateEntityWorksWithOneField()
    {
        $methods = array('setProp1');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
            
        $entity->expects($this->once())
            ->method('setProp1')
            ->with($this->equalTo('value1'));
        
        $json = array('prop1' => 'value1');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }
    
    public function testHydrateEntityWorksWithMultipleFields()
    {
        $methods = array('setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
            
        $entity->expects($this->once())
            ->method('setProp1')
            ->with($this->equalTo('value1'));
        
        $entity->expects($this->once())
            ->method('setProp2')
            ->with($this->equalTo('value2'));
        
        $json = array('prop1' => 'value1', 'prop2' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }
    
    public function testHydrateEntityWorksWithNoFields()
    {
        $methods = array();
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
        
        $json = array();
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }
    
    public function testHydrateEntityWorksWithDifferentJsonFields()
    {
        $methods = array('setProp1', 'setProp2');
        $entity  = $this->getMock('Prado\Rackspace\DNS\Model\Entity', $methods);
            
        $entity->expects($this->never())
            ->method('setProp1');
            
        $entity->expects($this->never())
            ->method('setProp2');
        
        $json = array('prop3' => 'value1', 'prop4' => 'value2');
        $hydratedEntity = $this->hydrator->hydrateEntity($entity, $json);
    }
    
    public function testGetSetMethodsWorks()
    {
        $mock = $this->getMock('stdClass', array('setProp1', 'setProp2', 'notASetMethod'));
        
        $expected = array(new ReflectionMethod($mock, 'setProp1'), new ReflectionMethod($mock, 'setProp2'));
        $methods  = $this->hydrator->getSetMethods($mock);
        
        $this->assertEquals($expected, $methods);
    }
    
    public function testGetSetMethodsReturnsEmptyArrayForNoSetMethods()
    {
        $mock = $this->getMock('stdClass', array('notASetMethod1', 'notASetMethod2'));
        
        $this->assertEquals(array(), $this->hydrator->getSetMethods($mock));
    }
    
    public function testGetAttributeNameWorks()
    {
        $mock = $this->getMock('stdClass', array('setProp1'));
        
        $method = new ReflectionMethod($mock, 'setProp1');
        $attribute = $this->hydrator->getAttributeName($method);
        
        $this->assertEquals('prop1', $attribute);
    }
    
    public function testGetAttributeNameReturnsEmptyStringForInvalidSetterMethod()
    {
        $mock = $this->getMock('stdClass', array('set'));
        
        $method = new ReflectionMethod($mock, 'set');
        $attribute = $this->hydrator->getAttributeName($method);
        
        $this->assertEquals('', $attribute);
    }
    
    public function testIsSetMethodWorksForSetMethod()
    {
        $mock = $this->getMock('stdClass', array('setProp1'));
        
        $method = new ReflectionMethod($mock, 'setProp1');
        $this->assertTrue($this->hydrator->isSetMethod($method), 'setProp1 should be a set method');
    }
    
    public function testIsSetMethodWorksForOtherMethods()
    {
        $mock = $this->getMock('stdClass', array('getProp1', 'set', 'settings'));
        
        $method = new ReflectionMethod($mock, 'getProp1');
        $this->assertFalse($this->hydrator->isSetMethod($method), 'getProp1 should not a set method');
        
        $method = new ReflectionMethod($mock, 'set');
        $this->assertFalse($this->hydrator->isSetMethod($method), 'set should not be a set method');
        
        $method = new ReflectionMethod($mock, 'settings');
        $this->assertFalse($this->hydrator->isSetMethod($method), 'settings should not be a set method');
    }
}
